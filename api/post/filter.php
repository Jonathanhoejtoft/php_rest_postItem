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
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

// instantiate blog post obj
$post = new Post($db);
$data = json_decode(file_get_contents("php://input"));
//var_dump($data->catid);
$post->catarray = $data->catid;

//blog post query

$result = $post->filter();
//get row count
$num = $result->rowCount();

if($num > 0){
    $posts_arr = array();
    $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
            'created_at' => $created_at
        );

        //push to "data"
        array_push($posts_arr['data'], $post_item);
    }
    //turn to JSON
    echo json_encode($posts_arr);
}
else{
    //no posts
    echo json_encode(array('message' => 'No posts found'));
}

