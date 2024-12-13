<?php
include 'db_connect.php';

if (isset($_GET['docId'])) {
    $docId = intval($_GET['docId']);
    $sql = "SELECT * FROM documents WHERE id = $docId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doc = $result->fetch_assoc();
        echo json_encode($doc);
    } else {
        echo json_encode(['error' => 'Документ не найден']);
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Не указан идентификатор документа']);
}
?>