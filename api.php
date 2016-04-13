<?php
/**
 * Created by PhpStorm.
 * User: HoangAnhKhoa
 * Date: 4/13/16
 * Time: 4:51 PM
 */
include 'database.php';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $query = "SELECT * FROM products";
        $result = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $return = [];
        foreach ($result as $row) {
            $return[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price']
            ];
        }
        header('Content-type: application/json');
        print json_encode($return);
        break;
    case 'PUT':
//        $pathSegments = explode('/', $_SERVER['REQUEST_URI']);
//        $id = $pathSegments[2];
        $entityBody = file_get_contents('php://input');
        $array = json_decode($entityBody, true);

        $query = "UPDATE products
                    SET name=:name, description=:description, price=:price
                    WHERE id = :id";

        $array_updated = [];

        foreach($array as $value){
            $stmt = $con->prepare($query);

            $stmt->bindParam(':name', $value['name']);
            $stmt->bindParam(':description', $value['description']);
            $stmt->bindParam(':price', $value['price']);
            $stmt->bindParam(':id', $value['id']);

            if ($stmt->execute()) {
                $array_updated[] = $value;
            }
        }

        header('Content-type: application/json');
        print json_encode($array_updated);
        break;
    case 'DELETE':
        echo 'DELETE';
        break;
    case 'POST':
        echo 'POST';
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, PUT, DELETE');
        break;
}