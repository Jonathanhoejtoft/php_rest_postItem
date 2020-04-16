<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/24/2020
 * Time: 19:26
 */
//Headers
header('access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instatiate db & connect

$database = new Database();
$db = $database->connect();

// instantiate blog post obj
$post = new Post($db);

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//get post
$post->read_single();

//create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

//make json
print_r(json_encode($post_arr));