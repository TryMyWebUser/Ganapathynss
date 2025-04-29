<?php

// This is class file autoloaded
spl_autoload_register(function ($class) {
    require_once $class . ".class.php";
});

// Prevent browser caching
// header("Cache-Control: no-cache, must-revalidate");
// header("Pragma: no-cache");

?>