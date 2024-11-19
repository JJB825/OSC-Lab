<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<h2 style='text-align:center;'>Please login to view your cart.</h2>";
    exit();
}

$userId = $_SESSION['userId'];

// Fetch cart items for the logged-in user
$sql = "SELECT cartitems.cartid, cartitems.title, cartitems.quantity, cartitems.price, 
               (cartitems.quantity * cartitems.price) AS total 
        FROM cartitems
        INNER JOIN orders ON cartitems.cartid = orders.cartid
        WHERE orders.userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>    
        <h1>Your Shopping Cart</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th> <!-- Added Action Column -->
                </tr>
            </thead>
            <tbody>
                <?php
                $finalTotal = 0;
                while ($row = $result->fetch_assoc()):
                    $finalTotal += $row['total'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>Rs <?php echo $row['price']; ?></td>
                        <td>Rs <?php echo $row['total']; ?></td>
                        <td>
                            <form action="remove_from_cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="cartid" value="<?php echo $row['cartid']; ?>">
                                <button type="submit" style="background-color:red; color:white; border:none; padding:5px 10px; cursor:pointer;">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="final-total-label">Final Total:</td>
                    <td class="final-total-value">Rs <?php echo $finalTotal; ?></td>
                </tr>
            </tfoot>
        </table>
    </main>
    <form action="proceed_to_payment.php" method="POST">
        <input type="hidden" name="finalTotal" value="<?php echo $finalTotal; ?>">
        <button class="proceed-button">Proceed to Payment</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
