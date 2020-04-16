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
include_once '../../models/Post.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$title = $data->title;
$body = $data->body;
$author = $data->author;
$category_id = $data->category_id;


// instantiate blog post obj
$post = new Post($db);
//get raw data posted

//Set ID to update

$post->id = $id;

$post->title = $title;
$post->body = $body;
$post->author = $author;
$post->category_id = $category_id;
if($title = "" || empty($title)){
    echo json_encode(
        array('message' => 'post invalid - empty string')
    );
}
//update post
if($post->update()){
    echo json_encode(
        array('message' => 'post updated')
    );
}
else{
    echo json_encode(
        array('message' => 'post not updated')
    );
}