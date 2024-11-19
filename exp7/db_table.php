<?php

$servername = "localhost";
$username = "root";         
$password = "";             

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    $error_message = "Connection failed: " . $conn->connect_error;
    display_error($error_message);
    exit();
}

$sql = "CREATE DATABASE IF NOT EXISTS db";
if ($conn->query($sql) === TRUE) {
    $success_message_db = "Database created successfully.";
} else {
    $error_message = "Error creating database: " . $conn->error;
    display_error($error_message);
    exit();
}

$conn->select_db("db");

$sql = "CREATE TABLE IF NOT EXISTS courses_enrolled (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(50) NOT NULL,
    course_name VARCHAR(50) NOT NULL,
    grade VARCHAR(2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    $success_message_table = "Table 'courses_enrolled' created successfully.";
} else {
    $error_message = "Error creating table: " . $conn->error;
    display_error($error_message);
    exit();
}

$sql = "INSERT INTO courses_enrolled (student_name, course_name, grade)
        VALUES
        ('Alice Johnson', 'Mathematics', 'A'),
        ('Bob Smith', 'Physics', 'B'),
        ('Charlie Brown', 'Chemistry', 'A')";

if ($conn->query($sql) === TRUE) {
    $success_message_data = "Sample data inserted successfully.";
} else {
    $error_message = "Error inserting data: " . $conn->error;
    display_error($error_message);
    exit();
}

$sql = "SELECT student_id, student_name, course_name, grade FROM courses_enrolled";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .success {
            color: #4F8A10;
            background-color: #DFF2BF;
            padding: 15px;
            border: 1px solid #4F8A10;
            border-radius: 5px;
            text-align: center;
            width: 60%;
            margin-bottom: 10px;
        }
        .error {
            color: #D8000C;
            background-color: #FFBABA;
            padding: 20px;
            border: 1px solid #D8000C;
            border-radius: 5px;
            text-align: center;
            width: 60%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
function display_error($message) {
    echo "<div class='error'>$message</div>";
}

if (isset($error_message)) {
    display_error($error_message);
}

if (isset($success_message_db)) {
    echo "<div class='success'>$success_message_db</div>";
}

if (isset($success_message_table)) {
    echo "<div class='success'>$success_message_table</div>";
}

if (isset($success_message_data)) {
    echo "<div class='success'>$success_message_data</div>";
}

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course Name</th>
                <th>Grade</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["student_id"] . "</td>
                <td>" . $row["student_name"] . "</td>
                <td>" . $row["course_name"] . "</td>
                <td>" . $row["grade"] . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    display_error("No students found in the database.");
}

$conn->close();
?>

</body>
</html>
