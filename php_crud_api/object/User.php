<?php

class User {

    // database connection and table name
    private $conn;
    private $table_name = "users";
    // object properties
    public $id;
    public $name;
    public $pwd;
    public $email;
    public $options;
    public $created;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function read(){
        // query to select all
        $query = "SELECT *
            FROM
                " . $this->table_name . "
            ORDER BY
                user_id";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    function create(){
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_name=:name,
                user_pwd=:pwd,
                user_email=:email,
                user_options=:options";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->pwd = htmlspecialchars(strip_tags($this->pwd));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->options = htmlspecialchars(strip_tags($this->options));
 
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":pwd", $this->pwd);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":options", $this->options);
 
        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // update the user
    function update() {
        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                user_name = :name,
                user_pwd = :pwd,
                user_email = :email,
                user_options = :options
            WHERE
                user_id = :id";
 
        // prepare query statement
        $stmt = $this->conn->prepare($query);
 
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->options = htmlspecialchars(strip_tags($this->options));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->pwd = htmlspecialchars(strip_tags($this->pwd));
 
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':pwd', $this->pwd);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':options', $this->options);
 
        // execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete(){
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
 
        // prepare query
        $stmt = $this->conn->prepare($query);
 
        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
 
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
 
        // execute query
        if ($stmt->execute()) {
            return true;
        }
 
        return false;
    }
}