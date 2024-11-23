<?php
    if (isset($_GET["Credentials"])){
    if($_GET["Credentials"] === "false") {
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
            <h3 class="m-2">Change Password</h3>
            <h6 id="Invalid">Username or Password is Invalid! Please try again.</h6>
            <form action="Process.php" method="POST" id="loginForm" onsubmit="return FormValidation()">
                <div class="">
                    <label for="user">Username:</label>
                    <input type="text" name="User" placeholder="Enter your username" id="User" class="Inputs">
                    <p>Required</p>
                </div>
                
                <div class="">
                    <label for="pass">Old Password:</label>
                    <input type="password" name="OldPass" id="OldPass" placeholder="Enter your Old password" class="Inputs">
                    <p>Required</p>
                </div>

                <div class="">
                    <label for="pass">New Password:</label>
                    <input type="password" name="NewPass" id="NewPass" placeholder="Enter your New password" class="Inputs">
                    <p>Required</p>
                </div>

                <button type="submit" class="mb-3" id="submitBtn" name="Action" value="ChangePass">Change Password</button>

                
            </form>
        </div>
    </div>
    <script>
        function FormValidation(){
            
            var Inputs = document.querySelectorAll(".Inputs");
            var p = document.querySelectorAll("p");
            var Submit = true;
            

            Inputs.forEach((Input, index) => {
                if (Input.value.trim() == "") {
                    p[index].style.visibility = "visible";
                    Input.style.borderColor="red";
                    Submit = false;
                } else {
                    p[index].style.visibility = "hidden"; // Hide the error message
                    Input.style.borderColor="black";
                }
            });

            return Submit;
        }
    </script>
</body>
</html>