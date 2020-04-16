<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/24/2020
 * Time: 19:43
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

// instantiate blog post obj
$category = new Category($db);
//get raw data posted
//$name = $_POST["name"];
$data = json_decode(file_get_contents("php://input"));
if(empty($data->name)){
    $data->name = "";
}
$category->name = $data->name;

if($data->name == null || empty($data->name)){
    array('message' => 'post invalid - no category added');

}
//create category
if($category->create()){
    echo json_encode(
        array('message' => 'Category created')
    );
}
else{
    echo json_encode(
        array('message' => 'Category not created')
    );
}
