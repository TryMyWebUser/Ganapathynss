<?php

    include "../libs/load.php";

    // Start a session
    Session::start();

    if (Session::destroy())
    {
        header("Location: index.php");
        exit;
    }

?>