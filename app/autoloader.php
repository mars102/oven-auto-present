<?php
namespace autoloader;
Class autoloader
{
	public function __construct() {
		spl_autoload_register(function($class_name) {
			//echo "<br/>NAME $class_name<br/>";
			/*if( (strripos($class_name,'\\')!==true)) 
			{
			   	echo "".$class_name.'<br/>';
				$input = explode('\\', $class_name);
				$class_name = array_pop($input).'.php';
				$input[] = $class_name;
				$input = implode('/', $input);
				//echo "<br/>".$input."<br/>";
				if(\file_exists($input))
				{
					require $input;
					return true;
				}
				else
				{
					return false;
				}
			}*/
			$classPath = \explode('\\',$class_name);
			if(count($classPath)>1)
			{ 
				$input = array_pop($classPath).'.php';
				$classPath[] = $input;
				$path = implode('/',$classPath);
				if(\file_exists($path))
				{
					include_once $path;
					return true;
				}
				return false;
			}
			else{
				$class = $classPath[0];
				//echo $class;
				$array_path = array(
					'/app/components/PDF/dompdf/',
					'/app/components/PDF/dompdf/include/',
					'/app/components/PDF/dompdf/lib/',
					'/app/components/PDF/dompdf/lib/fonts/',
					'/app/components/PDF/dompdf/lib/html5lib/',
					'/app/components/PDF/dompdf/lib/php-font-lib/'
				);
				
				foreach($array_path as $path){
					//echo $path;
					$path = ROOT.$path.$class.'.php';
					//echo $path;
					if(is_file($path)) {
						//echo $path;
						include_once ($path);	
						return true;
					}	
				}
			}
		});
	}
}