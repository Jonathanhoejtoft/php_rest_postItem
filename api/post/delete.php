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
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));
// instantiate blog post obj
$post = new Post($db);
//get raw data posted

//Set ID to update

$post->id = $data->id;


//update post
if($post->delete()){
    echo json_encode(
        array('message' => 'post deleted')
    );
}
else{
    echo json_encode(
        array('message' => 'post not deleted')
    );
}