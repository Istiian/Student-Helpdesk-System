<?php 
session_start();
if (isset($_SESSION["AccountID"])) {
    $AccountId = $_SESSION["AccountID"];
    $FirstName = $_SESSION["FirstName"];
    $LastName = $_SESSION["LastName"];
}else{
    header("Location: login.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Create.css">
</head>
<body>
    <div class="nav">
        <img src="cmuheader.png" alt="">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Forlaje
            </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="ShapeBtn dropdown-item" onclick="window.location.href='login.php'">Log out</li>            
                </ul>
        </div>
    </div>


    <!-- Content -->
    <div class="container-fluid HeadingContainer">
        <h1>Submit a ticket</h1>
        <button onclick="window.location.href='Home.php'">Back?</button>
    </div>

    <div class="MainContainer container-fluid">
        <form action="Process.php" method="post" onsubmit="return FormValidation()">
            <div class="inputContainer">
                <label for="">Email:</label>
                <input type="text" name="Email" class="Inputs">
                <small>Required</small>
            </div>

            <div class="inputContainer">
                <label for="">Concern:</label>
                <select name="Concern" id="" class="Inputs">
                    <option value=""></option>
                    <option value="CMU Student Email Address">CMU Student Email Address</option>
                    <option value="Enrollment">Enrollment</option>
                    <option value="Certifications and Academic Records">Certifications and Academic Records</option>
                    <option value="Library Services">Library Services</option>
                    <option value="Health and Wellness Concern">Health and Wellness Concern</option>
                    <option value="Class Scheduling and Conflicts">Class Scheduling</option>
                    <option value="CMU Student portal">CMU Student Portal</option>
                </select>
                <small>Required</small>
            </div>

            <div class="inputContainer">
                <label for="">Subject:</label>
                <input type="text" name="Subject" class="Inputs">
                <small>Required</small>
            </div>

            <div class="inputContainer">
                <label for="">Description:</label>
                <textarea name="Description" id="" class="Inputs"></textarea>
                <small>Required</small>
            </div>

            <button type="submit" name="Action" value="CreateTicket">Create Ticket</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function FormValidation(){
            
            var Inputs = document.querySelectorAll(".Inputs");
            var Small = document.querySelectorAll("small");
            var Submit = true;
            

            Inputs.forEach((Input, index) => {
                if (Input.value.trim() == "") {
                    Small[index].style.visibility = "visible";
                    Input.style.borderColor="red";
                    Submit = false;
                } else {
                    Small[index].style.visibility = "hidden"; // Hide the error message
                    Input.style.borderColor="black";
                }
            });

            return Submit;
        }
    </script>
</body>
</html>