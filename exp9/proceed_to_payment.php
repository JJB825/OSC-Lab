<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$finalTotal = $_POST['finalTotal'];

$stmt = $conn->prepare("INSERT INTO payments (userId, status, amount, paymentDate) VALUES (?, 'pending', ?, CURDATE())");
$stmt->bind_param("ii", $userId, $finalTotal);
$stmt->execute();

echo "<script>alert('Proceeding to payment'); window.location.href = 'index.php';</script>";
$conn->close();
?>
