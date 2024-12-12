<?php
// Database connection details
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "portfolio";      

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Sanitize inputs to prevent SQL injection
$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$message = $conn->real_escape_string($message);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger' role='alert'>
            Invalid email format. Please go back and enter a valid email.
          </div>";
    exit();
}

// Prepare SQL statement to insert feedback
$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);  // "sss" indicates all parameters are strings

// Execute the statement and check if it was successful
if ($stmt->execute()) {
    echo "<div class='alert alert-success' role='alert'>
            Feedback submitted successfully! Thank you for your input.
          </div>";
} else {
    echo "<div class='alert alert-danger' role='alert'>
            Error: " . $stmt->error . "
          </div>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
