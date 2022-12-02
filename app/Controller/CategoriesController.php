<?php

class CategoriesController
{

    public function index()
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('categories.html');

            $categories = Category::index();

            $parameters = array();
            $parameters['route'] = 'Categories';
            $parameters['categories'] = $categories;

            $response = $template->render($parameters);
            echo $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function create()
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('addCategory.html');

            $parameters = array();
            $parameters['route'] = 'New Category';

            $response = $template->render($parameters);
            echo $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function store()
    {
        try {
            Category::store($_POST);

            echo '<script>alert("Category created successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        }
        
    }

    public function edit($dados)
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('editCategory.html');

            $categories = Category::show($dados);

            $parameters = array();
            $parameters['route'] = 'Edit Category';
            $parameters['id'] = $categories->id;
            $parameters['name'] = $categories->name;
            $parameters['code'] = $categories->code;

            $response = $template->render($parameters);
            echo $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {
            Category::update($_POST);

            echo '<script>alert("Category updated successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        }
        
    }

    public function delete($dados)
    {
        try {
            Category::delete($dados);

            echo '<script>alert("Category deleted successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio-php/?pagina=categories&metodo=index"</script>';
        }
        
    }

}

?>