<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['docId'])) {
	$docId = intval($_GET['docId']);
	$sql = "DELETE FROM documents WHERE id = $docId";

	if ($conn->query($sql) === TRUE) {
		echo "Документ успешно удален!";
	} else {
		echo "Ошибка при удалении документа: " . $conn->error;
	}

	$conn->close();
} else {
	echo "Некорректный запрос.";
}
?>