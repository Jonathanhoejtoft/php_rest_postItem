<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/24/2020
 * Time: 13:45
 */

class Post{
    //db setup
    /**
     * @var PDO   <--- need by PhpStorm to find Methods of PDO
     */
    private $conn;
    private $table = "posts";

    //public proberties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    public $catarray;

    //Constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //get posts
    public function read(){

        //create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';

        //prepare statement

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    //get specific posts
    public function filter(){
        $string = implode( ",", $this->catarray);
        //var_dump($string);
        $query = '';
        //var_dump($this->catarray);
        if(empty($string)){
            //create query
            $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
        }
        else{
            $array = explode(',', $string); //split string into array seperated by ', '
            //create query
            $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                  WHERE p.category_id in (' . implode(',', array_map('intval', $array)) . ')
                                ORDER BY
                                  p.created_at DESC
                                  ';
        }



        //prepare statement

        $stmt = $this->conn->prepare($query);
        //bind params
        //$stmt->bindParam(':catid',$this->catarray);


        $stmt->execute();

        return $stmt;
    }

    public function read_single(){
        //get single post
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                WHERE
                                p.id = ?
                                LIMIT 0,1';
        //Preapre statement
        $stmt = $this->conn->prepare($query);
        //bind id
        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    //create post
    public function create(){
        //create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //bind data
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
        if($this->title == '' || empty($this->title)){
            return false;
        }
        elseif($this->body == '' || empty($this->body)){
            return false;
        }
        elseif($this->author == '' || empty($this->author)){
            return false;
        }
        elseif($this->category_id == 0){
            return false;
        }
        else{
            if($stmt->execute()){
                return true;
            }

            printf("Errors: %s. \n",$stmt->error);

            return false;
        }
        //execute query

    }
    //update post
    public function update(){
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
        WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':id',$this->id);

        if($this->title == '' || empty($this->title)){
            return false;
        }
        elseif($this->body == '' || empty($this->body)){
            return false;
        }
        elseif($this->author == '' || empty($this->author)){
            return false;
        }
        else{
            if($stmt->execute()){
                return true;
            }

            printf("Errors: %s. \n",$stmt->error);

            return false;
        }
        //execute query

    }
    //delete post
    public function delete(){
        //create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':id',$this->id);


            if($stmt->execute()){
                return true;
            }

            printf("Errors: %s. \n",$stmt->error);

            return false;

        //execute query

    }
}