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
    <link rel="stylesheet" href="Home.css">
</head>
<body>
    <div class="nav">
        <img src="cmuheader.png" alt="">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $LastName?>
            </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="ShapeBtn dropdown-item" onclick="window.location.href='Process.php?Logout=True'">Log out</li>            
                </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid mainContainer">
        <h1 id="PageHeading">My Ticket</h1>
        <div class="btnContainer">
        <!-- <select name="filter" id="filter" onchange="window.location.href='Home.php?Filter=' + this.value;">
            <option value="">Status</option>
            <option value="All" <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "All") echo "selected"?>>All</option>
            <option value="Open" <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Open") echo "selected"?>>Open</option>
            <option value="Pending" <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Pending") echo "selected"?>>Pending</option>
            <option value="Resolved" <?php if(isset($_GET["Filter"]) && $_GET["Filter"] == "Resolved") echo "selected"?> >Resolved</option>
        </select> -->

            <button id="createButton" onclick="window.location.href='Create.php'">Create ticket</button>
        </div>
                
        <div class="ticketContainer">
            <div class="row">
                <div class="col-12 col-md-4 TicketHeading">Subject</div>
                <div class="col-12 col-md-2 TicketHeading">Ticket ID</div>
                <div class="col-12 col-md-2 TicketHeading">Last updated</div>
                <div class="col-12 col-md-2 TicketHeading">Status</div>
                <div class="col-12 col-md-2 ">
            </div>
                
            </div>

            <!-- <div class="row">
                <div class="col-12 col-md-4 Subject" style="color:#d08211" onclick="window.location.href='view.php'"><span>Subject: </span>Student Portal not working</div>
                <div class="col-12 col-md-2"><span>Ticket ID: </span>0001</div>
                <div class="col-12 col-md-2"><span>Last Updated: </span> October 19, 2024 8:37pm</div>
                <div class="col-12 col-md-2"><span>Status: </span>Pending</div>
                <div class="col-12 col-md-2 d-flex">
                    <form action="">
                        <button type ="submit" name ="Action" value="Edit" id="EditBtn"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                    </form>
                    <button type ="submit" name ="Action" value="Delete" id="DeleteBtn" onclick="window.location.href='Process.php?Delete=True'"><i class="fa-solid fa-trash"></i> Delete</button>
                </div>
            </div> -->

            <?php

            if(isset($_GET["Filter"])){
                switch($_GET["Filter"]){
                    case "All":
                        $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId";
                        break;
                    case "Open":
                        $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId and Stat = 'Open'";
                        break;

                    case "Pending":
                        $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId and Stat = 'Pending'";
                        break;

                    case "Resolved":
                        $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId and Stat = 'Resolved'";
                        break;
                    default:
                        $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId";
                }
            }else{
                $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId";
            }
            include "connection.php";
            // $SQL = "SELECT * FROM ticket WHERE AccountID = $AccountId";
            $result = $conn->query($SQL);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-4 Subject" onclick="window.location.href=\'view.php?TicketNum='.$row["TicketNum"].'\'"><span>Subject: </span>'.$row["subj"].'</div>';
                    echo '<div class="col-12 col-md-2"><span>Ticket ID: </span>'.$row["TicketNum"].'</div>';
                    echo '<div class="col-12 col-md-2"><span>Last Updated: </span>'.ConvertDate($row["LastUpdatedAt"]).'</div>';
                    echo '<div class="col-12 col-md-2"><span>Status: </span>'.$row["Stat"].'</div>';
                    // echo '<div class="col-12 col-md-2 d-flex">
                    //         <button type ="submit" name ="Action" value="Edit" id="EditBtn" onclick="window.location.href=\'Edit.php?TicketNum='.$row["TicketNum"].'\'"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                    //         <button type ="submit" name ="Action" value="Delete" id="DeleteBtn" onclick="window.location.href=\'Process.php?Delete=True&TicketNum='.$row["TicketNum"].'\'"><i class="fa-solid fa-trash"></i> Delete</button>
                    //     </div>';
                    switch($row["Stat"]){
                        case "Open":
                             echo '<div class="col-12 col-md-2 d-flex">
                                    <button type ="submit" name ="Action" value="Edit" id="EditBtn" onclick="window.location.href=\'Edit.php?TicketNum='.$row["TicketNum"].'\'"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                    <button type ="submit" name ="Action" value="Edit" id="DeleteBtn" onclick="deleteTicket('.$row["TicketNum"].')"><i class="fa-solid fa-pen-to-square"></i> Delete</button>
                                    
                                  </div>';
                            break;
                            case "Pending": case "Resolved":
                             echo '<div class="col-12 col-md-2 d-flex">
                
                                </div>';
                            break;
                        
                    }  
                    echo '</div>';
                }
            }else{
                echo "No Record Found";
            }

            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function filterTickets() { 
            var filterValue = document.getElementById('filter').value; 
            if(filterValue) { 
                window.location.href = 'Home.php?Filter=' + filterValue; 
            } 
        }
        function deleteTicket(TicketNum){
            if(confirm("Are you sure you want to delete this ticket?")){
                window.location.href = `Process.php?Delete=True&TicketNum=${TicketNum}`
            }
        }
        let stars =  document.getElementsByClassName("star");
        let output = document.getElementById("output");
        
        // Funtion to update rating
        function gfg(n) {
            remove();
            for (let i = 0; i < n; i++) {
                if (n == 1) cls = "one";
                else if (n == 2) cls = "two";
                else if (n == 3) cls = "three";
                else if (n == 4) cls = "four";
                else if (n == 5) cls = "five";
                stars[i].className = "star " + cls;
            }
        }
        
        // To remove the pre-applied styling
        function remove() {
            let i = 0;
            while (i < 5) {
                stars[i].className = "star";
                i++;
            }
        }
    </script>
</body>
</html>