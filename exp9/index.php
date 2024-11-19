<?php
include 'db_connect.php';
session_start();

// Query to fetch products grouped by type
$sql = "SELECT * FROM products ORDER BY type";
$result = $conn->query($sql);

// Initialize arrays to store books by category
$categories = ['fiction' => [], 'historical' => [], 'moral-based' => [], 'mythological' => []];

// Fetch data and categorize books
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[$row['type']][] = $row;
    }
} else {
    echo "No books found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore Homepage</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Book Categories -->
    <main>
        <?php foreach ($categories as $category => $books): ?>
            <h2 class="category-heading"><?php echo ucfirst($category); ?></h2>
            <section class="book-grid">
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <img src="<?php echo $book['imageUrl']; ?>" alt="<?php echo $book['title']; ?>" class="book-image">
                        <h3 class="book-title"><?php echo $book['title']; ?></h3>
                        <p class="book-author"><?php echo $book['author']; ?></p>
                        <p class="book-price">Rs <?php echo $book['price']; ?></p>
                        
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="productId" value="<?php echo $book['productId']; ?>">
                            <input type="number" name="quantity" min="1" max="10" value="1" class="quantity-input">
                            <button type="submit" class="add-to-cart-button">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    </main>
</body>
</html>
