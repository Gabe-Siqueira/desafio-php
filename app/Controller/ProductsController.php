<?php

class ProductsController
{

    public function index()
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('products.html');

            $products = Product::index();

            $parameters = array();
            $parameters['route'] = 'Products';
            $parameters['products'] = $products;

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
            $template = $twig->load('addProduct.html');

            $categories = Category::index();

            $parameters = array();
            $parameters['route'] = 'New Product';
            $parameters['categories'] = $categories;

            $response = $template->render($parameters);
            echo $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function store()
    {
        try {

            foreach ($_POST['category'] as $key => $value) {
                if (empty($value)) {
                    echo '<script>alert("Field Categories invalid");</script>';
                    echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=create"</script>';

                    return false;
                }
            }

            if (empty($_POST['name']) || empty($_POST['sku']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['description'])) {
                echo '<script>alert("Fill in all fields!");</script>';
                echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=create"</script>';

				return false;
			}

            exit;

            if (isset($_FILES['image'])) {
                $ext = strtolower(substr($_FILES['image']['name'], -4));
                $nameFile = md5(time()).$ext;
                $directory = "upload/";

                $imagePath = $directory.$nameFile;

                move_uploaded_file($_FILES['image']['tmp_name'], 'assets/'.$imagePath);
            }else{
                echo '<script>alert("Image error");</script>';

                return false;
            }

            $dados['name'] = $_POST['name'];
            $dados['sku'] = $_POST['sku'];
            $dados['price'] = $_POST['price'];
            $dados['quantity'] = $_POST['quantity'];
            $dados['description'] = $_POST['description'];
            $dados['category'] = $_POST['category'];
            $dados['image'] = $nameFile;

            Product::store($dados);

            echo '<script>alert("Product created successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        }
        
    }

    public function edit($dados)
    {
        try {                
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('editProduct.html');

            $categories = Category::index();
            $products = Product::show($dados);

            $array_product_category = explode(",", $products->id_category);

            $count = 0;
            foreach ($categories as $row) {
                if (in_array($row->id, $array_product_category)) { 
                    $categories[$count]->selected = 1;
                }else{
                    $categories[$count]->selected = 0;
                }
                $count++;
            }

            $parameters = array();
            $parameters['route'] = 'Edit Product';
            $parameters['id'] = $products->id;
            $parameters['name'] = $products->name;
            $parameters['sku'] = $products->sku;
            $parameters['price'] = $products->price;
            $parameters['description'] = $products->description;
            $parameters['quantity'] = $products->quantity;
            $parameters['image'] = $products->image;
            $parameters['categories'] = $categories;

            $response = $template->render($parameters);
            echo $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update()
    {
        try {

            $image = $_POST['image'];
            
            if (!empty($_FILES['image']['name'])) {
                $ext = strtolower(substr($_FILES['image']['name'], -4));
                $nameFile = md5(time()).$ext;
                $directory = "assets/upload/";

                $imagePath = $directory.$nameFile;

                if(file_exists($directory.$image)){
                    unlink($directory.$image);
                }

                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            }else{
                $nameFile = $image;
            }

            $dados['id'] = $_POST['id'];
            $dados['name'] = $_POST['name'];
            $dados['sku'] = $_POST['sku'];
            $dados['price'] = $_POST['price'];
            $dados['quantity'] = $_POST['quantity'];
            $dados['description'] = $_POST['description'];
            $dados['category'] = $_POST['category'];
            $dados['image'] = $nameFile;

            Product::update($dados);

            echo '<script>alert("Product updated successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        }
        
    }

    public function delete($dados)
    {
        try {
            $products = Product::show($dados);

            Product::delete($dados);

            if(file_exists('assets/upload/'.$products->image)){
                unlink('assets/upload/'.$products->image);
            }

            echo '<script>alert("Product deleted successfully!");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        } catch(Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/desafio/?pagina=products&metodo=index"</script>';
        }
        
    }

}

?>