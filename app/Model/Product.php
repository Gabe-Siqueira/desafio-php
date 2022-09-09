<?php

class Product 
{

    public static function index()
    {
		try {
			$con = Connection::getConn();

        	$sql = "SELECT * FROM product";
			$sql = $con->prepare($sql);
			$sql->execute();

			$result = array();

			while ($row = $sql->fetchObject('category')) {
				$result[] = $row;
			}

			if (!$result) {
				throw new Exception("Não foi encontrado nenhum registro no banco");		
			}

			return $result;

		} catch (Exception $e) {
			$e->getMessage();
		}
    
    }

	public static function show($id)
    {
		try {

			$con = Connection::getConn();

        	$sql = "SELECT * FROM product WHERE id = :id";
			$sql = $con->prepare($sql);
			$sql->bindValue(':id', $id, PDO::PARAM_INT);
			$sql->execute();

			$result = $sql->fetchObject('category');

			if (!$result) {
				throw new Exception("No record found");	
			}

			return $result;

		} catch (Exception $e) {
			$e->getMessage();
		}
    
    }

	public static function store($dados)
	{
		try {
			$name = $dados['name'];
			$sku = $dados['sku'];
			$price = $dados['price'];
			$description = $dados['description'];
			$quantity = $dados['quantity'];
			$image = $dados['image'];

			$id_category = implode(",", $dados['category']);

			if (empty($id_category) || empty($name) || empty($sku) || empty($price) || empty($description) || empty($quantity) || empty($image)) {
				throw new Exception("Fill in all fields");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('INSERT INTO product (id_category, `name`, sku, price, `description`, quantity, `image`) VALUES (:id_category, :name, :sku, :price, :description, :quantity, :image)');
			$sql->bindValue(':id_category', $id_category);	
			$sql->bindValue(':name', $name);
			$sql->bindValue(':sku', $sku);
			$sql->bindValue(':price', $price);
			$sql->bindValue(':description', $description);
			$sql->bindValue(':quantity', $quantity);
			$sql->bindValue(':image', $image);
			$response = $sql->execute();

			if ($response == 0) {
				throw new Exception("Failed to insert post");

				return false;
			}

			return true;
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	public static function update($dados)
	{
		try {
			$id = $dados['id'];
			$name = $dados['name'];
			$sku = $dados['sku'];
			$price = $dados['price'];
			$description = $dados['description'];
			$quantity = $dados['quantity'];
			$image = $dados['image'];
			$category = implode(",", $dados['category']);

			if (empty($id) || empty($category) || empty($name) || empty($sku) || empty($price) || empty($description) || empty($quantity) || empty($image)) {
				throw new Exception("Fill in all fields");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('UPDATE product SET id_category = :id_category, `name` = :name, sku = :sku, price = :price, `description` = :description, quantity = :quantity,  `image` = :image WHERE id = :id');
			$sql->bindValue(':id', $id);
			$sql->bindValue(':id_category', $category);
			$sql->bindValue(':name', $name);
			$sql->bindValue(':sku', $sku);
			$sql->bindValue(':price', $price);
			$sql->bindValue(':description', $description);
			$sql->bindValue(':quantity', $quantity);
			$sql->bindValue(':image', $image);
			$response = $sql->execute();

			if ($response == 0) {
				throw new Exception("Failed to update post");

				return false;
			}

			return true;
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	public static function delete($id)
	{
		try {

			if (empty($id)) {
				throw new Exception("Fill in all fields");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('DELETE FROM product WHERE id = :id');
			$sql->bindValue(':id', $id);
			$response = $sql->execute();

			if ($response == 0) {
				throw new Exception("Failed to delete post");

				return false;
			}

			return true;
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
    
}

?>