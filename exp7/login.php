<?php
session_start();

$emailErr = $passwordErr = $loginErr = '';
$email = $password = '';

$servername = "localhost";
$username = "root";         
$password = "";             
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $stmt = $conn->prepare("SELECT password FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_email'] = $email;

                if (isset($_POST['remember'])) {
                    setcookie("email", $email, time() + (86400 * 30), "/"); // 30 days
                    setcookie("password", $password, time() + (86400 * 30), "/"); // 30 days
                } else {
                    setcookie("email", "", time() - 3600, "/");
                    setcookie("password", "", time() - 3600, "/");
                }

                header("Location: dashboard.php");
                exit();
            } else {
                $loginErr = "Invalid email or password.";
            }
        } else {
            $loginErr = "Invalid email or password.";
        }

        $stmt->close();
    }
}

if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $emailErr; ?></span><br/>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <span class="error"><?php echo $passwordErr; ?></span><br/>

            <div class="checkbox-container">
                <input type="checkbox" id="remember" name="remember" <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>>
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-login">Login</button>
        </form>
        <span class="error"><?php echo $loginErr; ?></span>
    </div>
</body>
</html>
