<?php

namespace Study\Core;

class Template{
	
	protected $kernel;
	
	protected $viewDir;
	protected $viewClass;
	
	protected $cache;

	protected $parseChipRoles = [
		'/"/'			   					 => '\"',
		"/{@ extends '(\w+?).chip.php' @}/"  => " extends $1_chip {\n",
		'/{% endstruct %}/'					 => "\";\n}",
		"/{% struct ([a-z]+) %}/"			 => "public function struct_$1 (){\n echo \"",
		"/{% foreach (\w+) as (\w+) %}/" 	 => "\";\nforeach(isset(\$this->parameters['$1']) ? \$this->parameters['$1'] : $$1 as $$2):\necho\"",
		'/{% endforeach %}/'				 => "\";\nendforeach;\necho \"",
		'/{{ ([a-z]+) }}/'					 => "\";\necho \$this->parameters['$1'];\necho \"",
		'/{{ ([a-z]+).([a-z]+) }}/'		 	 => "\";\necho $$1['$2'];\necho\"",
		'/{% if (\w+) %}/'				 	 => "\";\nif(isset(\$this->parameters['$1']) ? \$this->parameters['$1'] : $$1 ):\necho \"",
		'/{% endif %}/'						 => "\";\nendif;\necho \"",
		"/{{ form.row\('([a-zA-Z]+)'\) }}/"	 => "\";\necho \$this->parameters['form']->row('$1');\necho \"",
		"/{{ form.start\(([\w\s-=]*)([,]?)([\w\s'=-]*)\) }}/" => "\";\necho \$this->parameters['form']->start(\"$1\",\"$3\");\necho \"",
		"/{{ form.end\(\) }}/"				 => "\";\necho \$this->parameters['form']->end();\necho \"",
		"/{{ errors\('all'\) }}/"			 => "\";\nforeach(errors('all') as \$error){\necho \$error;\n}\necho\"",
		"/{{ success\('([a-zA-Z]+)'\) }}/"	 => "\";\necho isset(\$_SESSION['$1']) ? \$_SESSION['$1'] : \"\";unset(\$_SESSION['$1']);\necho\"",
		"/{{ path\('([a-zA-Z_]+)'\) }}/"	=> "\";\necho path('$1');\necho \"",
		"/{{ path\('([a-zA-Z_]+)',\s+{([a-zA-Z']+):([a-zA-Z]+).([a-zA-Z]+)}\) }}/"	
			=> "\";\necho path(['$1', [$2=>$$3['$4']]]);\necho \"",
		"/{'\([a-zA-Z]+\)':\([\w+]\)}/"		 => "['$1'=>'$2']",
		"/{{ asset\('([a-zA-Z.\/_\d-]+)'\) }}/" => "/std/assets/$1",
	];
	
	public function __construct($kernel){
		$this->kernel = $kernel;
		$this->viewDir = $this->kernel->getRootDir().'../app/Resources/views/';
		$this->cache   = $this->kernel->getRootDir().'../var/cache/chip/';
	}
	
	protected function parseChip($contents, $viewClass){
		$contents = preg_replace(array_keys($this->parseChipRoles), array_values($this->parseChipRoles), $contents);
		if(strstr($contents, ' extends ')){
			$contents = "class $viewClass ".$contents;
		}else{
			$contents = "class $viewClass {".$contents;
		}
		
		$contents = "<?php\nnamespace cache\chip;\n".$contents."\n}";
		$this->cache($viewClass, $contents);
	}
	
	protected function cache($viewClass, $contents){
		$config = parse_ini_file($this->kernel->getRootDir().'../app/config/parameters.ini');
		if(!is_file($this->cache.$viewClass.'.php') || 
			time()-filemtime($this->cache.$viewClass.'.php') > $config['cache'] ){
			file_put_contents($this->cache.$viewClass.'.php', $contents);
		}
	}
	
	protected $parseLayoutDefineFunction = [
		'/{% endstruct %}/'					 => "\";\n}",
		"/{% struct ([a-z]+) %}/"			 => "public function struct_$1 (){\n echo \"",
	];
	
	protected $parseLayoutCallFunction = [
		'/"/'			   					 		=> '\"',
		'/{{ ([a-z]+) }}/'							=> "\";\necho \$this->parameters['$1'];\necho \"",
		"/{% struct ([a-z]+) %}{% endstruct %}/"	=> "\";\n\$this->struct_$1();\n echo \"",
		"/{{ asset\('([a-zA-Z.\/_\d-]+)'\) }}/" 	=> "/std/assets/$1",
		"/{{ path\('([a-zA-Z_]+)'\) }}/"			=> "\";\necho path('$1');\necho \"",
		"/{{ path\('([a-zA-Z_]+)',\s+{([a-zA-Z']+):([a-zA-Z]+).([a-zA-Z]+)}\) }}/"
		=> "\";\necho path(['$1', [$2=>$$3['$4']]]);\necho \"",
	];
	
	protected function ChipConstruct(){
		$_parameters = "\nprotected \$parameters;";
		$_construct = "\npublic function __construct(\$parameters){\n
			\$this->parameters = \$parameters;\n
		}\n";
		return $_parameters.$_construct;
	}
	
	protected function layoutDefineFunction($contents){
		$contents = explode('{% struct',$contents);
		$functions = [];

		foreach( $contents as $content ){
			#$function = strtr('{% struct'.$content, $this->parseLayoutRoles);
			$function = preg_replace(array_keys($this->parseLayoutDefineFunction), array_values($this->parseLayoutDefineFunction), '{% struct'.$content);
			
			$functions[] = substr($function, 0, stripos($function, '}')+1);
		}

		unset($functions[0]);
				
		return implode("\n",$functions);
	}
	
	protected function parseLayout($contents, $parentClass){
		$content = "<?php\nnamespace cache\chip;\n";
		$content .= "class $parentClass {\n";
		$content .= $this->ChipConstruct();
		$content .= "public function display(){\n echo\"";
		$content = $content.preg_replace(array_keys($this->parseLayoutCallFunction), array_values($this->parseLayoutCallFunction), $contents)."\";\n}\n";

		$functions = $this->layoutDefineFunction($contents);

		$contents = $content.$functions."\n}";
		$this->cache($parentClass, $contents);
		#if(!is_file($this->cache.$parentClass.'.php')){
			#file_put_contents($this->cache.$parentClass.'.php', $contents);
		#}
	}
	
	protected function parseParent($content){
		if(strstr($content, '{@ extends')){
			$parentView = substr($content, stripos($content, "{@ extends'"), stripos($content, "' @}"));
			$parentView = substr($parentView, stripos($parentView, "'")+1);
			$parentClass = strtr(substr($parentView, 0, strripos($parentView, '.')), ['/'=>'_', '.'=>'_']);

			$contents = file_get_contents($this->viewDir.$parentView);
			
			$contents = preg_replace("/\s|��/"," ",$contents);
			#var_dump($contents);
			$this->parseLayout($contents, $parentClass);
			#$this->($parentClass);
		}
	}
	
	public function render($view, $parameters){
		
		$viewClass = strtr(substr($view, 0, strripos($view, '.')), ['/'=>'_', '.'=>'_']);
		
		$contents = file_get_contents($this->viewDir.$view);
		$contents = preg_replace("/\s|��/"," ",$contents);
		$this->parseParent($contents);
		$this->parseChip($contents, $viewClass);
		
		$class = 'cache\chip\\'.$viewClass;
		
		return new $class($parameters);
		
		#include($this->viewDir.$view);
	}
}