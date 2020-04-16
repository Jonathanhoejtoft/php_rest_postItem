<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/25/2020
 * Time: 15:01
 */
//Headers
header('access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/Category.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$name = $data->name;

// instantiate blog post obj
$category = new Category($db);
//get raw data posted

//Set ID to update

$category->id = $id;
$category->name = $name;

if($name = "" || empty($name)){
    echo json_encode(
        array('message' => 'post invalid - empty string')
    );
}
//update post
if($category->update()){
    echo json_encode(
        array('message' => 'Category updated')
    );
}
else{
    echo json_encode(
        array('message' => 'Category not updated')
    );
}