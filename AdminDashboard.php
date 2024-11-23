

<?php
include "connection.php";
$GetTicket = "SELECT * FROM ticket";
$NumOfPending = 0;
$NumOfResolved = 0;
$NumOfOpen = 0; 

$result = $conn->query($GetTicket);
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        switch ($row["Stat"]){
            case "Pending":
                ++$NumOfPending;
                break;
            case "Resolved":
                ++$NumOfResolved;
                break;
            case "Open":
                ++$NumOfOpen;
        }
        
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
    <link rel="stylesheet" href="AdminDashboard.css">
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

        <div class="container-fluid InfoContainer">
            <div class="box">
                <p>Open Ticket</p>
                <p><?php echo $NumOfOpen ?></p>
            </div>

            <div class="box">
                <p>Pending Ticket</p>
                <p><?php echo $NumOfPending ?></p>
            </div>

            <div class="box">
                <p>Close Ticket</p>
                <p><?php echo $NumOfResolved?></p>
            </div>
        </div>
        
        <div class="chartContainer">
            <canvas id="myChart"></canvas>
        </div>
            
        </div>
    </div>

</main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    </script>
    <?php 
        echo'<script>
                const Tickets = ["Open", "Pending", "Close"];
                const NumOfTicket = ['.$NumOfOpen.', '.$NumOfPending.', '.$NumOfResolved.'];
                const barColors = ["#007BFF", "#FFC107", "#28A745"];

                new Chart("myChart", {
                type: "pie",
                data: {
                    labels: Tickets,
                    datasets: [{
                    backgroundColor: barColors,
                    data: NumOfTicket
                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                    display: true,
                    text: ""
                    }
                }
                });
            </script>';
    ?>
</body>
</html>