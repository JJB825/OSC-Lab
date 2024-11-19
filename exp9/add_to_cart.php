<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>alert('Please log in first!'); window.location.href = 'login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];

// Check if item is already in the cart
$stmt = $conn->prepare("SELECT cartid, quantity FROM cartitems WHERE productId = ? AND EXISTS 
                        (SELECT 1 FROM orders WHERE orders.cartid = cartitems.cartid AND orders.userid = ?)");
$stmt->bind_param("ii", $productId, $userId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update quantity if item is in cart
    $stmt->bind_result($cartid, $existingQuantity);
    $stmt->fetch();
    $newQuantity = $existingQuantity + $quantity;

    $updateStmt = $conn->prepare("UPDATE cartitems SET quantity = ? WHERE cartid = ?");
    $updateStmt->bind_param("ii", $newQuantity, $cartid);
    $updateStmt->execute();
    $updateStmt->close();
} else {
    // Insert new item if not in cart
    $productQuery = $conn->prepare("SELECT * FROM products WHERE productId = ?");
    $productQuery->bind_param("i", $productId);
    $productQuery->execute();
    $product = $productQuery->get_result()->fetch_assoc();
    $price = $product['price'];
    $title = $product['title'];

    $insertCartItem = $conn->prepare("INSERT INTO cartitems (productId, title, quantity, price) VALUES (?, ?, ?, ?)");
    $insertCartItem->bind_param("isii", $productId, $title, $quantity, $price);
    $insertCartItem->execute();
    $cartId = $conn->insert_id;

    $insertOrder = $conn->prepare("INSERT INTO orders (userId, cartId) VALUES (?, ?)");
    $insertOrder->bind_param("ii", $userId, $cartId);
    $insertOrder->execute();
}

$conn->close();

echo "<script>alert('Book added to cart successfully!'); window.location.href = 'cart.php';</script>";
