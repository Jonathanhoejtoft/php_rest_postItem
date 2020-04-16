<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/24/2020
 * Time: 13:56
 */
//Headers
header('access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

// instantiate blog post obj
$category = new Category($db);

//category query

$result = $category->read();
//get row count
$num = $result->rowCount();

if($num > 0){
    $cat_arr = array();
    $cat_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $cat_item = array(
            'id' => $id,
            'name' => $name
        );

        //push to "data"
        array_push($cat_arr['data'], $cat_item);
    }
    //turn to JSON
    echo json_encode($cat_arr);
}
else{
    //no categories
    echo json_encode(array('message' => 'No posts found'));
}

