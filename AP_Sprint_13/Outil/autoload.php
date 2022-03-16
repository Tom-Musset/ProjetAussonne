<?php
// session_start();
	function my_autoloader($class) 
	{	$result=substr($class,0,5);
		if (strcmp($result, 'contr') == 0)
		     include_once  'Controleur/'.$class . '.php';
		 else
			if (strcmp($result,"acces") ==0)
				include_once  'Outil/'.$class . '.php';
			else
				if (strcmp($result, 'conte') == 0)
					include_once  'Traitement/classeConteneur/'.$class . '.php';
				else
					if (strcmp($result, "metie") == 0)
						include_once  'Traitement/classeMetier/'.$class . '.php';
						else
						if (strcmp($result, "vueCe") == 0)
						include_once  'Vues/ihm/'.$class . '.php';
						
	}
	spl_autoload_register('my_autoloader');
?>