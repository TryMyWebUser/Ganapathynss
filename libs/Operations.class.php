<?php

class Operations
{
    public static function getUser()
    {
        $conn = Database::getConnect();
        $userSession = $conn->real_escape_string(Session::get('login_user'));

        $sql = "SELECT * FROM `users` WHERE `email` = '$userSession' OR `name` = '$userSession' OR `phone` = '$userSession' LIMIT 1";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }
    public static function targetUser()
    {
        $conn = Database::getConnect();
        $userSession = $_GET['username'];

        $sql = "SELECT * FROM `users` WHERE `name` = '$userSession' LIMIT 1";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }
    public static function getUsers()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `users` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getCategory()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `category` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getProducts()
    {
        $conn = Database::getConnect();
        $sql = "SELECT * FROM `products` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getCateChecker($conn)
    {
        $sql = "SELECT * FROM `category` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getProductChecker($conn)
    {
        $sql = "SELECT * FROM `products` ORDER BY `created_at` ASC";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }

    public static function getCatePage($page, $conn)
    {
        $sql = "SELECT * FROM `category` WHERE `page` = '$page'";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function getProductPage($page, $conn)
    {
        $sql = "SELECT * FROM `products` WHERE `category` = '$page'";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    
    public static function getCate($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `category` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
    public static function getProduct($conn)
    {
        $getID = $_GET['edit_id'];
        $sql = "SELECT * FROM `products` WHERE `id` = '$getID'";
        $result = $conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
}

?>