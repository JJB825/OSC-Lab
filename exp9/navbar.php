<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <a href="index.php">Home</a>
    <a href="cart.php">Your Cart</a>
    
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <span class="greeting">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>

<style>
    /* Navbar styling */
    nav {
        display: flex;
        align-items: center;
        justify-content: space-around;
        background-color: #333;
        padding: 1em;
    }
    nav a, .greeting {
        color: white;
        text-decoration: none;
        font-size: 1em;
        margin: 0 0.5em;
    }
    nav a:hover {
        color: #ddd;
    }
    .greeting {
        font-weight: bold;
    }
</style>
