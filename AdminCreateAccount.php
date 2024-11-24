<?php
session_start();

if (isset($_GET["Create"])&& $_GET["Create"]=="unsuccess") {
    $LastName = $_SESSION["LastName"];
    $FirstName = $_SESSION["FirstName"];
    $MiddleName = $_SESSION["MiddleName"];
    $Username = $_SESSION["Username"];
    $Pass = $_SESSION["Pass"];
    $Role = $_SESSION["Role"];
    $Email = $_SESSION["Email"];    

    if ($_GET["Create"] == "unsuccess") {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementsByTagName('small')[0].style.display = 'block';
                    document.getElementsByTagName('input')[4].style.borderColor = 'red';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="AdminCreateAccount.css">
</head>
<body>
    

<main>
    <!-- Sidebar -->
    <div class="container-fluid sideNav">
        
        <img src="cmuheader.png" alt="" id="CMUHEADER">
        
        <ul>
            <li class="sideButton" onclick="window.location.href='AdminDashboard.php'"><i class="fa-solid fa-chart-line"></i>Dashboard</li>
            <li class="sideButton" onclick="window.location.href='adminTicket.php'"><i class="fa-regular fa-rectangle-list"></i>Ticket list</li>
            <li class="sideButton" onclick="window.location.href='AdminCreateAccount.php'"><i class="fa-solid fa-user"></i>Create Account</li>
        </ul>
    </div>

    <!-- CONTENT -->
    <div class="container-fluid contentContainer">
        <div class="nav">
            <i class="fa-solid fa-bars" id="BarnBtn"></i>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin
                </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li class="ShapeBtn dropdown-item" onclick="window.location.href='login.php'">Log out</li>             
                    </ul>
            </div>
        </div>

        <h1>Create Account</h1>
        <div class="container-fluid AccountContainer">
            <form action="Process.php" method="post">
                <label for="FCreateAcc.php">Name:</label>
                <div class="nameContainer">
                    <input type="text" name="LastName" placeholder="Last Name" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $LastName?>" required>
                    <input type="text" name="FirstName" placeholder="First Name" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $FirstName?>" required>
                    <input type="text" name="MiddleName" placeholder="Middle Name" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $MiddleName?>" required>
                </div>

                <div class="EmailRoleContainer">
                    <div class="EmailContainer">
                        <label for="">Email Address:</label>
                        <input type="text" name="Email" placeholder="Email Address" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $Email?>" required>
                    </div>

                    <div class="roleContainer">
                        <label for="">Role:</label>
                        <select name="Role" id="" required>
                            <option value="">Role</option>
                            <option value="Student" <?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess" && $Role =="Student") echo "selected"?>>Student</option>
                            <option value="Admin" <?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess" && $Role ==" Admin") echo "selected"?>>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="UserContainer">
                    <label for="">Username</label>
                    <input type="text" placeholder="Username" name="Username" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $Username?>" required>
                    <small>Username Already Exist!</small>
                </div>

                <div class="PasswordContainer">
                    <label for="">Password:</label>
                    <input type="text" placeholder="Username" name="Password" value="<?php if(isset($_GET['Create'])&& $_GET["Create"]=="unsuccess") echo $Pass?>" required>
                </div>

                <button type="submit" id="CreateBtn" name="Action" value="CreateAcc">Create</button>
            </form>
        </div>
    </div>



</main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        const createButton = document.getElementById('createButton');
        const barBtn = document.getElementById('BarnBtn');
        const sideNav = document.getElementsByClassName('sideNav')[0];
        const contentContainer = document.getElementsByClassName('contentContainer')[0];

        barBtn.addEventListener('click', function(){
            sideNav.classList.toggle('Clicked');
            contentContainer.classList.toggle('Clicked');
            
        });
        function toAdminDash(){
            window.location.href = "AdminDashboard.php";
            console.log(6);
        }


    </script>
</body>
</html>