<?php
include 'db_connect.php';

function logQuery($query, $type) {
    $logMessage = "[" . date("Y-m-d H:i:s") . "] " . $type . " QUERY: " . $query . "\n";
    echo "<script>console.log('{$type} QUERY: {$query}');</script>";
}

parse_str(file_get_contents("php://input"), $_PUT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fio = $_POST['fio'];
    $dob = $_POST['dob'];
    $pension_date = $_POST['pension_date'];
    $dismissal_date = $_POST['dismissal_date'];
    $work_experience = $_POST['work_experience'];
    $transfer_date = $_POST['transfer_date'];
    $transfer_amount = $_POST['transfer_amount'];
    $order_number = $_POST['order_number'];
    $named_transfer_date = $_POST['named_transfer_date'];
    $named_transfer_amount = $_POST['named_transfer_amount'];
    $username = $_POST['username'];
    $record_date = $_POST['record_date'];
    $record_time = $_POST['record_time'];

    $sql = "INSERT INTO documents (fio, dob, pension_date, dismissal_date, work_experience, transfer_date, transfer_amount, order_number, named_transfer_date, named_transfer_amount, username, record_date, record_time) VALUES ('$fio', '$dob', '$pension_date', '$dismissal_date', '$work_experience', '$transfer_date', '$transfer_amount', '$order_number', '$named_transfer_date', '$named_transfer_amount', '$username', '$record_date', '$record_time')";

    logQuery($sql, "INSERT");

    if ($conn->query($sql) === TRUE) {
        $newDocId = $conn->insert_id;
        echo "Документ сохранен! ID: $newDocId";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT" && isset($_GET['docId'])) {
    $docId = intval($_GET['docId']);
    $fio = $_PUT['fio'];
    $dob = $_PUT['dob'];
    $pension_date = $_PUT['pension_date'];
    $dismissal_date = $_PUT['dismissal_date'];
    $work_experience = $_PUT['work_experience'];
    $transfer_date = $_PUT['transfer_date'];
    $transfer_amount = $_PUT['transfer_amount'];
    $order_number = $_PUT['order_number'];
    $named_transfer_date = $_PUT['named_transfer_date'];
    $named_transfer_amount = $_PUT['named_transfer_amount'];
    $username = $_PUT['username'];
    $record_date = $_PUT['record_date'];
    $record_time = $_PUT['record_time'];

    $sql = "UPDATE documents SET fio='$fio', dob='$dob', pension_date='$pension_date', dismissal_date='$dismissal_date', work_experience='$work_experience', transfer_date='$transfer_date', transfer_amount='$transfer_amount', order_number='$order_number', named_transfer_date='$named_transfer_date', named_transfer_amount='$named_transfer_amount', username='$username', record_date='$record_date', record_time='$record_time' WHERE id=$docId";

    logQuery($sql, "UPDATE");

    if ($conn->query($sql) === TRUE) {
        echo "Документ обновлен!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>