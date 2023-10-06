<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">Users list</a>
            <a href="/register.php" class="btn btn-primary">Register</a>
        </div>
    </nav>
    <div class="m-5">
        <h1>Users</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentTimestamp = date("Y-m-d H:i:s");
                $logContents = file_get_contents("users.txt");
                $existingUsers = json_decode($logContents, true);

                if ($existingUsers) {
                    foreach ($existingUsers as $user) {
                        echo "<tr>";
                        echo "<td>" . $user["id"] . "</td>";
                        echo "<td>" . $user["name"] . "</td>";
                        echo "<td>" . $user["email"] . "</td>";
                        echo "<td>" . $user["password"] . "</td>";
                        echo "<td>" . $user["created_at"] . "</td>";
                        echo "</tr>";
                    }
                } else {
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
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>