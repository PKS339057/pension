<?php
include 'db_connect.php';

$sql = "SELECT id, record_date, transfer_amount, named_transfer_amount FROM documents";
$result = $conn->query($sql);

$documents = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $documents[] = $row;
    }
}

echo json_encode($documents);

$conn->close();
?>