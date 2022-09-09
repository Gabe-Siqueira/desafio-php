<?php

class Category 
{

    public static function index()
    {
		try {
			$con = Connection::getConn();

        	$sql = "SELECT * FROM category";
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

        	$sql = "SELECT * FROM category WHERE id = :id";
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
			$code = $dados['code'];

			if (empty($name) || empty($code)) {
				throw new Exception("Fill in all fields");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('INSERT INTO category (`name`, code) VALUES (:name, :code)');
			$sql->bindValue(':name', $name);
			$sql->bindValue(':code', $code);
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
			$code = $dados['code'];

			if (empty($id) || empty($name) || empty($code)) {
				throw new Exception("Fill in all fields");

				return false;
			}

			$con = Connection::getConn();

			$sql = $con->prepare('UPDATE category SET `name` = :name, code = :code WHERE id = :id');
			$sql->bindValue(':id', $id);
			$sql->bindValue(':name', $name);
			$sql->bindValue(':code', $code);
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

			$sql = $con->prepare('DELETE FROM category WHERE id = :id');
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