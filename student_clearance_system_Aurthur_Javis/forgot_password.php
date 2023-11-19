<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-button {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 15px;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <input type="submit" name="send" value="Reset Password">
        </form>
        <a href="login.php" class="back-button">Back</a>
    </div>

    <?php
    require __DIR__ . '/vendor/autoload.php';
    session_start();

    {
        // Include PHPMailer files
        require 'Exception.php';
        require 'PHPMailer.php';
        require 'SMTP.php';

        // Display errors
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the user's email address from the form
            $email = $_POST["email"];

            // Establish a database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "student_clearance";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check for database connection errors
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the email column exists in the 'students' table
            $sql_describe = "DESCRIBE students";
            $result_describe = $conn->query($sql_describe);

            if ($result_describe) {
                // Check if the 'email' column exists
                $email_column_exists = false;

                while ($row = $result_describe->fetch_assoc()) {
                    if ($row['Field'] == 'email') {
                        $email_column_exists = true;
                        break;
                    }
                }

                if ($email_column_exists) {
                    // Continue with the rest of your code
                    // Check if the email exists in the database
                    $sql_select = "SELECT * FROM students WHERE email = ?";
                    $stmt_select = $conn->prepare($sql_select);

                    if ($stmt_select) {
                        $stmt_select->bind_param("s", $email);
                        $stmt_select->execute();
                        $result_select = $stmt_select->get_result();

                        if ($result_select->num_rows > 0) {
                            // The email exists in the database, proceed with generating and sending a new password
                            $password = generateTemporaryPassword();

                            // Update the user's record with the new password
                            $sql_update = "UPDATE students SET password = ? WHERE email = ?";
                            $stmt_update = $conn->prepare($sql_update);

                            if ($stmt_update) {
                                // Hash the new password before storing it
                                $hashed_new_password = $password;

                                $stmt_update->bind_param("ss", $hashed_new_password, $email);
                                $stmt_update->execute();

                                // Create a PHPMailer object
                                $mail = new \PHPMailer\PHPMailer\PHPMailer();
                                try {
                                    // Set mailer to use SMTP
                                    $mail->isSMTP();

                                    // Specify SMTP server
                                    $mail->Host = 'smtp.gmail.com';

                                    // Enable SMTP authentication
                                    $mail->SMTPAuth = true;

                                    // SMTP username and password
                                    $mail->Username = 'dr.ryanuc@gmail.com';
                                    $mail->Password = 'cmjcxitnufilicjs';

                                    // Enable TLS encryption
                                    $mail->SMTPSecure = 'ssl';

                                    // TCP port to connect to
                                    $mail->Port = 465;

                                    // Set sender and recipient
                                    $mail->setFrom('noreply@gmail.com', 'ATJ');
                                    $mail->addAddress($email);

                                    // Email subject and body
                                    $mail->Subject = 'Password Reset Instructions';
                                    $mail->Body = "Dear Student,
                                    
                                    We understand you're having trouble accessing your account. To assist you in resetting your password, please follow the steps below:
                                    
                                    Copy the Verification Code:
                                    Your unique verification code is: [$password]. Please copy this code.
                                    
                                    Login to Your Account:
                                    Visit our website and enter your username along with the copied verification code to log in.
                                    Navigate to the Change Password Page:
                                    Once logged in, go to your account page. Look for the 'Change Password' option.
                                    Enter a New Password:
                                    Follow the prompts to create a new password. Ensure it meets our security requirements.
                                    Save Changes:
                                    After entering the new password, save the changes. Your password has now been successfully updated.
                                    For security reasons, it's essential to complete this process promptly. If you encounter any issues or did not initiate this password reset, 
                                    please contact our support team immediately at ndukadavid448@gmail.com.
                                    
                                    Thank you for your cooperation.
                                    Best regards,
                                    Arthur Javis University";
                                    
                                    // Send the email
                                    $mail->send();
                                    echo "An email has been sent with your new password.<br>";

                                } catch (Exception $e) {
                                    echo '<div class="error">Failed to send the new password email. Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                    error_log('SMTP Error: ' . $e->getMessage());
                                }

                                $stmt_update->close();
                            } else {
                                echo "Failed to update the new password. Error: " . $conn->error . "<br>";
                            }
                        } else {
                            echo "Email not found in our records.<br>";
                        }

                        $stmt_select->close();
                    } else {
                        echo "Failed to retrieve table information. Error: " . $conn->error . "<br>";
                    }
                }

                // Close the database connection
                $conn->close();
            }
        }
    }
    
    function generateTemporaryPassword() {
        // Generate a random temporary password with a fixed length of 8 characters
        $length = 8;
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $temporary_password = substr(str_shuffle($characters), 0, $length);
        return $temporary_password;
    }
    ?>
    <?php 
    header("refresh:5;url=login.php");
    ?>
</body>
</html>
