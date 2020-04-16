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
include_once '../../models/Post.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

// instantiate blog post obj
$post = new Post($db);
//get raw data posted
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;
if($data->category_id == null){
    array('message' => 'post invalid - no category selected');

}
if($data->title = ""){
    echo json_encode(
        array('message' => 'post invalid - empty string')
    );
}
//create post
if($post->create()){
    echo json_encode(
        array('message' => 'post created')
    );
}
else{
    echo json_encode(
        array('message' => 'post not created')
    );
}
