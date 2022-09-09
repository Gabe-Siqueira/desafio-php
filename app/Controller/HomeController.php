<?php

class HomeController
{

    public function index()
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('home.html');

            $products = Product::index();

            $parameters = array();
            $parameters['route'] = 'Dashboard';
            $parameters['products'] = $products;

            $conteudo = $template->render($parameters);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>