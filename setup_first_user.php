<?php
include_once 'includes/functions.php';
$connection = db();
if ($connection->connect_error) die($connection->connect_error);
$query = "CREATE TABLE users (
          forename VARCHAR(32) NOT NULL,
          surname VARCHAR(32) NOT NULL,
          login VARCHAR(32) NOT NULL UNIQUE,
          password VARCHAR(32) NOT NULL
          )";
$result = $connection->query($query);

if (!$result) die($connection->error);

$forename = 'Administrator';
$surname = 'Root';
$login = 'admin';
$password = 'admin';
$token = hash('ripemd128', "$salt1$password$salt2");

add_user($connection, $forename, $surname, $login, $token);
$connection->close();
?>