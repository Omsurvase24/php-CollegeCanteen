<?php
session_start();

include 'config/database.php';

if (isset($_POST)) {
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);

    $json = $json;

    $served = $json['served'];
    $id = $json['id'];

    $query = "UPDATE orders SET served=$served WHERE id=$id";

    $result = mysqli_query($conn, $query);
    echo 'Success';
}
