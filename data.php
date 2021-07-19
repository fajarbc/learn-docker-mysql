<?php
include('connection.php');
echo "\n<br>";
$data = $databaseConnection->query("SELECT * FROM db_users.tb_users");
while($row = $data->fetch_assoc()) {
    print_r($row);
}