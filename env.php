<?php
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
    } else {
        $uri = 'http://';
    }
    
    $APP_URL = $uri.$_SERVER['HTTP_HOST'];
    $DATABASE_URL = "localhost";
    $SERVER_NAME = "localhost";
    $USERNAME = "root";
    $PASSWORD = "";
    $DATABASE_NAME = "pvbdb";
?>
