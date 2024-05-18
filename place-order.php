<?php
session_start();

include 'config/database.php';

function getMysqlDatetimeFromDate(int $day, int $month, int $year)
{
    $dt = new DateTime();
    $dt->setDate($year, $month, $day);
    $dt->setTime(0, 0, 0, 0);
    return $dt->format('Y-m-d H:i:s');
}

if (isset($_POST)) {
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);

    $json = $json['data'];


    try {
        $query = "INSERT INTO orders (title, price, quantity, order_date, user) VALUES (?, ?, ?, ?, ?)";

        $prepared_statement = $conn->prepare($query);


        foreach ($json as $item) {
            $price = intval(str_replace('Rs. ', '', $item['price']));
            $dt = getMysqlDatetimeFromDate(date('d'),  date('m'),  date('Y'));
            $id = $_SESSION['user_id'];
            $prepared_statement->bind_param('siisi', $item['title'], $price, $item['quantity'], $dt, $id);

            $prepared_statement->execute();
        }

        $prepared_statement->close();

        echo 'Success';
    } catch (Exception $e) {
        echo 'Error';
    }
}
