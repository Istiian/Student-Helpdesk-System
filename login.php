<?php
if (isset($_GET["credentials"])){
    if($_GET["credentials"] === "wrong") {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const Invalidtext = document.getElementById('Invalid');
                Invalidtext.classList.add('Show');
            });
        </script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<style>
   
</style>
<body>
    <div class="container-fluid">
        <div class="container">
            <div class="LogoContainer">
                <img src="cmulogo.png" alt="CMU Logo">
                <h4 class="m-4">CMU Student Helpdesk</h4>
            </div>
        </div>
        <div class="container" >
            <h3 class="m-4">Sign in</h3>
            <h6 id="Invalid">Password or Username is incorrect! Please try again.</h6>

            <form action="Process.php" method="post" id="loginForm">
                <div class="my-2">
                    <label for="user">Username:</label>
                    <input type="text" name="User" placeholder="Enter your username" id="User" required>
                    <p>Required</p>
                </div>
                
                <div class="my-2">
                    <label for="pass">Password:</label>
                    <input type="password" name="Password" id="Pass" placeholder="Enter your password" required>
                    <p>Required</p>
                </div>
                <button type="submit" class="mb-2" id="submitBtn" name="Action" value="Login">Log in</button>
                <a href="ChangePass.php" class="mb-2">Change Password?</a>
            </form>
        </div>
    </div>
    
    <script>
        const SubmitBtn = document.getElementById('submitBtn');
        const UserInput = document.getElementById('User');
        const PassInput = document.getElementById('Pass');
        const paragraph = document.querySelectorAll('p');
        const Input = document.querySelectorAll('input');
        const loginForm = document.getElementById('loginForm');

        // Validation for log in input
        SubmitBtn.addEventListener('click', function(){
            if(UserInput.value === "" ||PassInput.value === "" ){
                if(UserInput.value ===""){
                    paragraph[0].setAttribute('style', 'visibility:visible;')
                    Input[0].setAttribute('style', 'border-bottom: 1px solid red;')
                }
                if(PassInput.value === ""){
                    paragraph[1].setAttribute('style', 'visibility:visible;')
                    Input[1].setAttribute('style', 'border-bottom: 1px solid red;')
                }
            }
        });
    </script>
</body>
</html>