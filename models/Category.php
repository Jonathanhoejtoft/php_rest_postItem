<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 3/25/2020
 * Time: 16:56
 */
class Category{
    /**
     * @var PDO   <--- need by PhpStorm to find Methods of PDO
     */
    private $conn;
    private $table = 'categories';

    public $id;
    public $name;
    public $created_at;

    //Contructor
    public function __construct($db){
        $this->conn = $db;
    }

    //get categories
    public function read(){
        //create query
        $query = 'SELECT
        id,
        name,
        created_at
        FROM
        '.$this->table .'
        ORDER BY
        created_at DESC';

        //prepare stmt
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;
    }

    public function create(){
        $query = 'INSERT INTO ' .$this->table. ' SET name = :name';

        //prepare stmt
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
        $stmt->bindParam(':name',$this->name);
        if($this->name == ""){
            return false;
        }
        else{
            if($stmt->execute()){
                return true;
            }

            printf("Errors: %s. \n",$stmt->error);

            return false;
        }

    }
    public function update(){
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
        name = :name
        WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':id',$this->id);

        if($this->name == '' || empty($this->name)){
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
    //delete category
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
            if($this->id == ""){
                return false;
            }
            else{
                return true;

            }
        }
        else{
            printf("Errors: %s. \n",$stmt->error);
            return false;
        }



        //execute query

    }
}