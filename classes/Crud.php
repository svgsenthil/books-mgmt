<?php

include_once "Interfaces\CrudInterface.php";

use Interfaces\CrudInterface;

class Crud extends Database implements CrudInterface
{

    public $id;
    public $title;
    public $price;
    public $description;
    public $category;
    public $image;

    //Table Name
    private $table_name = "book";
    private $catgory_table = "category";
    //Read Data from Database
    public function read()
    {
        $db_query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $statement = $this->connection->query($db_query);
        $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();

        return $statement;
    }

    public function getCategory()
    {
        $db_query = "SELECT * FROM " . $this->catgory_table . " ORDER BY id ASC";
        $statement = $this->connection->query($db_query);
        $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();

        return $statement;
    }

    //Store Data into Database
    public function create()
    {
        try {
            $db_query = "INSERT INTO
                            " . $this->table_name . "
                                (title,
                                price,
                                description,
                                category,
                                image)
                            VALUES(
                                :title,
                                :price,
                                :description,
                                :category,
                                :image)";

            $statement = $this->connection->prepare($db_query);

            //Function to filter the form input
            function sanitize_data($data)
            {
                $trimmed_data = trim($data);
                $str_splash_data = stripslashes($trimmed_data);
                $html_chars_data = htmlspecialchars($str_splash_data);
                return $html_chars_data;
            }

            $title = sanitize_data($this->title);
            $price = sanitize_data($this->price);
            $description = sanitize_data($this->description);
            $category = sanitize_data(implode(',', $this->category));
            $image = sanitize_data($this->image['name']);

            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':price', $price, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':category', $category, PDO::PARAM_STR);
            $statement->bindParam(':image', $image, PDO::PARAM_STR);
            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo "Error Message: " . $e->getMessage();
        }
    }

    //Show Single Record by ID form Database 
    public function show($id)
    {
        $db_query = "SELECT *FROM " . $this->table_name . " WHERE id = '$id' LIMIT 0,1";
        $statement = $this->connection->prepare($db_query);
        $statement->bindParam('id', $id, PDO::PARAM_INT);
        $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();

        return $statement;
    }

    //Update Data of Database
    public function update()
    {
        try {
            $db_query = "UPDATE
                            " . $this->table_name . "
                        SET
                            title    = :title,
                            price   = :price,
                            description = :description,
                            category = :category,
                            image   = :image
                        WHERE
                            id = :id";

            $statement = $this->connection->prepare($db_query);

            //Function to filter the form input
            function sanitize_data($data)
            {
                $trimmed_data = trim($data);
                $str_splash_data = stripslashes($trimmed_data);
                $html_chars_data = htmlspecialchars($str_splash_data);
                return $html_chars_data;
            }

            $title = sanitize_data($this->title);
            $price = sanitize_data($this->price);
            $description = sanitize_data($this->description);
            $category = sanitize_data($this->category);
            $image = sanitize_data($this->image);
            $id = sanitize_data($this->id);

            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':price', $price, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':category', $category, PDO::PARAM_STR);
            $statement->bindParam(':image', $image, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error Message: " . $e->getMessage();
        }
    }

    //Delete Data from Database
    public function delete()
    {
        try {
            $db_query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $statement = $this->connection->prepare($db_query);
            $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error Message: " . $e->getMessage();
        }
    }
}