<?php
$databaseHostname = "localhost";
$databaseUsername = "root";
$databasePassword = "rahasia";
$databaseName = "";
$databasePort = "3306";

$databaseConnection = mysqli_connect($databaseHostname, $databaseUsername, $databasePassword, $databaseName, $databasePort);
if(!$databaseConnection) {
    die("Error database connection!");
}
echo "Database connected!";