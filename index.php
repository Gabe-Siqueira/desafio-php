<?php

ini_set('display_errors', 'On');

$system_path = 'http://'.$_SERVER['HTTP_HOST'].'/desafio-php/';

$image_path = 'assets/upload/';

require_once 'app/Core/Core.php';

require_once 'lib/DataBase/Connection.php';

require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErrorController.php';
require_once 'app/Controller/ProductsController.php';
require_once 'app/Controller/CategoriesController.php';

require_once 'app/Model/Category.php';
require_once 'app/Model/Product.php';

require_once 'vendor/autoload.php';

$template = file_get_contents('app/Template/index.html');

ob_start();

    $core = new Core;
    $core->start($_GET);

    $exit = ob_get_contents();

ob_end_clean();

$variable = str_replace('{{contents}}', $exit, $template);
echo $variable;

?>
