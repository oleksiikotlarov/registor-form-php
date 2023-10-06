<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $logContents = file_get_contents("users.txt");
    $existingUsers = json_decode($logContents, true);
    $errors = array();
    $currentTimestamp = date("Y-m-d H:i:s");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Incorrect email";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords are different";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    foreach ($existingUsers as $user) {
        if ($user["email"] === $email) {
            $errors[] = "Email is already taken";
            $logFile = "log.txt";
            if (!file_exists($logFile)) {
                touch($logFile);
            }
            $message = "Email is already taken " . $user["email"] . " " . $currentTimestamp;
            file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
            break;
        }        
    }

    if (empty($errors)) {

        $usersFile = "users.txt";
        if (!file_exists($usersFile)) {
            touch($usersFile);
            $data = array(
                array(
                    "id" => 1,
                    "name" => "John Doe",
                    "email" => "john@example.com",
                    "password" => "password1",
                    "created_at" => $currentTimestamp,
                ),
                array(
                    "id" => 2,
                    "name" => "Jane Smith",
                    "email" => "jane@example.com",
                    "password" => "password2",
                    "created_at" => $currentTimestamp,
                ),
                array(
                    "id" => 3,
                    "name" => "Alice Johnson",
                    "email" => "alice@example.com",
                    "password" => "password3",
                    "created_at" => $currentTimestamp,
                ),
                array(
                    "id" => 4,
                    "name" => "Bob Brown",
                    "email" => "bob@example.com",
                    "password" => "password4",
                    "created_at" => $currentTimestamp,
                )
            );
            $logMessage = json_encode($data);
            file_put_contents($usersFile, $logMessage);
        }


        if ($existingUsers === null) {
            $existingUsers = [];
        }

        if (empty($errors)) {
            $newUser = array(
                "id" => count($existingUsers) + 1,
                "name" => $firstName . " " . $lastName,
                "email" => $email,
                "password" => $password,
                "created_at" => $currentTimestamp,
            );
            $existingUsers[] = $newUser;

            $logMessage = json_encode($existingUsers);
            file_put_contents("users.txt", $logMessage);

            $response = array(
                "success" => true,
                "message" => "You successfully registered"
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            "success" => false,
            "errors" => $errors
        );
        echo json_encode($response);
    }
} else {
    http_response_code(403);
    echo "No access";
}
