<?php
session_start();
if (isset($_SESSION["AccountID"])) {
    $AccountId = $_SESSION["AccountID"];
    $FirstName = $_SESSION["FirstName"];
    $LastName = $_SESSION["LastName"];

}
include "connection.php";
if(isset($_GET["Change"])){
    $ChangeStat = $_GET["Change"];
    $TicketNum = $_GET["TicketNum"];
    $UpdateStat = "UPDATE ticket SET Stat = '$ChangeStat' WHERE TicketNum = '$TicketNum'";
    if($conn->query($UpdateStat)){
        echo "success";
        
    }else{
        echo "notsuccess";
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
    <link rel="stylesheet" href="adminTicket.css">
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
                    <?php echo $LastName ?>
                </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li class="ShapeBtn dropdown-item" onclick="window.location.href='login.php'">Log out</li>                      
                    </ul>
            </div>
        </div>

        <div class="container-fluid mainContainer">
        <div class="btnContainer">
            <select name="filter" id="filter" onchange="window.location.href='adminTicket.php?Filter=' + this.value;">
                <option value="">Filter?</option>
                <option value="All" <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "All") echo "selected" ?>>All</option>
                <option value="Open"  <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Open") echo "selected" ?>>Open</option>
                <option value="Pending"  <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Pending") echo "selected" ?>>Pending</option>
                <option value="Resolved"  <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Resolved") echo "selected" ?>>Resolved</option>
            </select>
        </div>
                
        <div class="ticketContainer">
            <div class="row">
                <div class="col-12 col-md-6 TicketHeading" >Subject</div>
                <div class="col-12 col-md-2 TicketHeading">Ticket ID</div>
                <div class="col-12 col-md-2 TicketHeading">Last updated</div>
                <div class="col-12 col-md-2 TicketHeading">Status</div>
                
            </div>

            <?php
            if(isset($_GET["Filter"])){
                switch($_GET["Filter"]){
                    case "All":
                        $SQL = "SELECT * FROM ticket";
                        break;
                    case "Open":
                        $SQL = "SELECT * FROM ticket WHERE Stat = 'Open'";
                        break;

                    case "Pending":
                        $SQL = "SELECT * FROM ticket WHERE Stat = 'Pending'";
                        break;

                    case "Resolved":
                        $SQL = "SELECT * FROM ticket WHERE Stat = 'Resolved'";
                        break;
                    default:
                        $SQL = "SELECT * FROM ticket";
                }
            }else{
                $SQL = "SELECT * FROM ticket";
            }
            // include "connection.php";
            // $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId";
            $result = $conn->query($SQL);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-6 Subject" style="color:#d08211" onclick="window.location.href=\'Adminview.php?TicketNum='.$row["TicketNum"].'\'"><span>Subject: </span>'.$row["subj"].'</div>';
                    echo '<div class="col-12 col-md-2"><span>Ticket ID: </span>'.$row["TicketNum"].'</div>';
                    echo '<div class="col-12 col-md-2"><span>Last Updated: </span>'.ConvertDate($row["LastUpdatedAt"]).'</div>';
                    echo '<div class="col-12 col-md-2">
                            <span>Status: </span>
                            <select class="TicketStatus" name="" id="Status" onchange="window.location.href=\'adminTicket.php?Change=\' + this.value + \'&TicketNum='.$row["TicketNum"].'\'">
                                <option value="Open" '.($row["Stat"] == "Open" ? "selected" : "").'>Open</option>
                                <option value="Pending" '.($row["Stat"] == "Pending" ? "selected" : "").'>Pending</option>
                                <option value="Resolved" '.($row["Stat"] == "Resolved" ? "selected" : "").'>Resolved</option>
                            </select>
                        </div>';

                    echo '</div>';
                }
            }else{
                echo "No Record Found";
            }
            ?>
            <!-- <div class="row">
                <div class="col-12 col-md-6" onclick="window.location.href='AdminView.php'"><span>Subject: </span> Not Working</div>
                <div class="col-12 col-md-2"><span>Ticket ID: </span>0001</div>
                <div class="col-12 col-md-2"><span>Last Updated: </span>December 25, 2024</div>
                <div class="col-12 col-md-2"><span>Status: </span>
                    <select name="" id="Status">
                        <option value="">Open</option>
                        <option value="">Pending</option>
                        <option value="">Hold</option>
                        <option value="">Close</option>
                    </select>
                </div> 
            </div> -->

            
        </div>
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