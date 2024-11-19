<?php
session_start();
include 'db_connect.php';

if (!isset($_POST['cartid'])) {
    header("Location: cart.php");
    exit();
}

$cartid = $_POST['cartid'];
$userId = $_SESSION['userId'];

// Delete cart item for the user
$stmt = $conn->prepare("DELETE FROM cartitems WHERE cartid = ? AND EXISTS 
                        (SELECT 1 FROM orders WHERE orders.cartid = ? AND orders.userid = ?)");
$stmt->bind_param("iii", $cartid, $cartid, $userId);
$stmt->execute();

$conn->close();

header("Location: cart.php");
exit();
?>
