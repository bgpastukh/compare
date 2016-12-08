<?php

class Model_Main extends Model
{
    public $link;

    public function connectDB()
    {
        // DB connection
        $link = mysqli_connect("localhost", "root", "", "mydb");

        if (!$link) {
            throw new Exception('Can not connect to DB');
        }

        $this->link = $link;
    }

    public function check()
    {
        // search changes
        $link = $this->link;
        $errors = [];
        $lines = file("plentycar-6.csv");
        array_shift($lines);
        foreach ($lines as $line){
            $words = explode(",", $line);
            $id = $words[0];
            $price = $words[3];
            $sql = "SELECT `id`, `name`, `price` FROM `products` WHERE `id`='{$id}'";
            $result = mysqli_query($link, $sql);
            if(!mysqli_query($link, $sql))
            {
                throw new Exception("Error - ".mysqli_error($link)) ;
            }
            $row = mysqli_fetch_array($result);

            if ( trim($price) != trim($row['price'])) {
                $str =  "Price of <b>" . $row['name'] . "</b> has been changed! Row id = <b>" . $row['id']."</b>";
                array_push($errors, $str);
            }
        }
        if (!$errors){
            return "There are no price changes!";
        }
        return $errors;
    }

    public function drop()
    {
        // clear DB
        $link = $this->link;
        $sql = "DELETE FROM `products`";
        if (!mysqli_query($link, $sql))
        {
            throw new Exception("Can`t delete data!");
        }
    }

    public function load()
    {
        // loading new price
        $link = $this->link;
        $this->drop();
        $lines = file("plentycar-6.csv");
        array_shift($lines);
        $sql = "INSERT INTO products(`id`, `manufacturer`, `name`, `price`) VALUES ";
        $item = "";
        foreach($lines as $line) {
            $values = explode(",", $line);
            $query = "";
            foreach ($values as $word) {
                $query .= "'" . $word . "',";
            }
            $query = substr($query, 0, -1);
            $item .= "(" . $query ."),";
        }
        $sql .= $item;
        $sql = substr($sql, 0, -1);
        if(!mysqli_query($link, $sql))
        {
            $message =  "Error - ".mysqli_error($link);
        }
        else {
            $message =  "Success!";
        }

        return $message;
    }
}