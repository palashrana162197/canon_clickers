<?php
// Display a simple message
echo "hi";
echo "<br>";

// Check if the form has been submitted
if (isset($_POST['name'])) {
    echo "hello";
}
echo "<br>";

// Database connection details
$server = "localhost";
$username = "root";
$password = ""; // Use the actual password if required
$database = "canon";

// Establish connection
$connection = new mysqli($server, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo "connected<br>";

// Retrieve and sanitize user inputs
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['Email']);
$message = htmlspecialchars($_POST['message']);

// Prepare SQL statement
$stmt = $connection->prepare("INSERT INTO `contact us` (name, email, message) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare statement failed: " . $connection->error);
}

// Bind parameters
$stmt->bind_param("sss", $name, $email, $message);

// Execute the statement
if ($stmt->execute()) {
    echo "Data inserted<br>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$connection->close();

// Email configuration
$to = 'palashbhair@gmail.com'; // Replace with your email address
$subject = 'New Contact Form Submission';
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Email body
$email_body = "Name: $name\nEmail: $email\nMessage:\n$message";

// Send email
if (mail($to, $subject, $email_body, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
?>
