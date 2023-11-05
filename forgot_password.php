<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email address from the form
    $email = $_POST["email"];

    // Establish a database connection (replace with your database connection details)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_clearance";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for database connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The email exists in the database, proceed with generating and sending a temporary password
        $temporary_password = generateTemporaryPassword();
        // Store the temporary password in your database (you should have a table for this)

        // Send an email to the user with the temporary password
        $subject = "Temporary Password";
        $message = "Your temporary password is: $temporary_password";
        $headers = "From: la.benjamib@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "An email has been sent with a temporary password.";
        } else {
            echo "Failed to send the temporary password email.";
        }
    } else {
        echo "Email not found in our records.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

function generateTemporaryPassword() {
    // Generate a random temporary password (adjust the length and complexity as needed)
    $length = 10;
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $temporary_password = substr(str_shuffle($characters), 0, $length);
    return $temporary_password;
}
?>
