<?php
// Database configuration
$servername = "your_servername"; // From InfinityFree
$username = "your_username";     // From InfinityFree
$password = "your_password";     // From InfinityFree
$dbname = "your_dbname";         // From InfinityFree

// Email configuration
$to_email = "mr.prem2006@gmail.com";
$from_email = "noreply@yourdomain.com"; // Use your domain email
$subject = "New Contact Form Message";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    $date = date("Y-m-d H:i:s");

    // Validate input
    if (empty($name) || empty($email) || empty($message)) {
        die("Please fill all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Insert into database
    $sql = "INSERT INTO contacts (name, email, message, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $message, $date);

    if ($stmt->execute()) {
        // Send email to you
        $email_body = "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Date: $date\n\n";
        $email_body .= "Message:\n$message";
        
        $headers = "From: $from_email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        mail($to_email, $subject, $email_body, $headers);
        
        // Send confirmation email to the user
        $user_subject = "Thank you for contacting Prem Prasad Pradhan";
        $user_message = "Dear $name,\n\nThank you for reaching out to me. I have received your message and will get back to you shortly.\n\nBest regards,\nPrem Prasad Pradhan";
        
        $user_headers = "From: $from_email\r\n";
        
        mail($email, $user_subject, $user_message, $user_headers);
        
        // Redirect with success message
        header("Location: contact.html?message=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>