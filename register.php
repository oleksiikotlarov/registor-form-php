<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">Navbar</a>
        </div>
    </nav>
    <main class="d-flex flex-column justify-content-center align-items-center m-4">
        <h1 class="mb-3">Register</h1>

        <div id="successMessage" class="alert alert-success d-none mt-3"></div>
        <a id="backBtn" class="btn btn-secondary d-none mt-4" href="/index.php">Go back</a>

        <div id="errorMessage" class="d-flex flex-row align-items-center mt-3"></div>

        <form id="registrationForm" action="submit.php" method="POST" class="container text-start">
            <div class="row">
                <div class="mb-3 col">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>

                <div class="mb-3 col">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com">
            </div>
            <div class="row mb-3">
                <div class="mb-3 col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3 col">
                    <label for="confirmPassword" class="form-label">Confirm password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input class="btn btn-primary" type="submit" value="Register">
            </div>

        </form>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("registrationForm");
            var successMessage = document.getElementById("successMessage");
            var errorMessage = document.getElementById("errorMessage");
            var backBtn = document.getElementById("backBtn");

            form.addEventListener("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "submit.php", true);
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");


                var isValid = true;

                if (isValid) {
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    successMessage.textContent = response.message;
                                    successMessage.classList.remove("d-none");
                                    backBtn.classList.remove("d-none");
                                    errorMessage.classList.add("d-none");
                                    form.style.display = "none";
                                } else {
                                    if (response.errors) {
                                        errorMessage.innerHTML = '';

                                        response.errors.forEach(function(error) {
                                            var errorElement = document.createElement("div");
                                            errorElement.textContent = error;
                                            errorElement.classList.add("alert"); 
                                            errorElement.classList.add("alert-warning");
                                            errorElement.classList.add("m-3");  
                                            errorMessage.appendChild(errorElement);
                                        });

                                        errorMessage.classList.remove("d-none");
                                    } else {
                                        errorMessage.textContent = "Registration failed. Please try again later.";
                                        errorMessage.classList.remove("d-none");
                                    }
                                }
                            }
                        }
                    };

                    xhr.send(formData);
                } else {
                    errorMessage.textContent = "Please fix the errors above.";
                    errorMessage.classList.remove("d-none");
                }
            });
        });
    </script>
</body>

</html>