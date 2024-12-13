<?php
$host = getenv("DATABASE_HOST");
$dbname = getenv("DATABASE_NAME");
$username = getenv("DATABASE_USER");
$password = getenv("DATABASE_PASSWORD");

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
