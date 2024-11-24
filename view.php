<?php 
session_start();

if (isset($_SESSION["AccountID"])) {
    $AccountId = $_SESSION["AccountID"];
    $FirstName = $_SESSION["FirstName"];
    $LastName = $_SESSION["LastName"];
    $TicketNum = $_GET["TicketNum"];
    
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
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="nav">
        <img src="cmuheader.png" alt="">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Forlaje
            </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="ShapeBtn dropdown-item" onclick="window.location.href='Process.php?Logout=True'">Log out</li>     
                </ul>
        </div>
    </div>

    <?php 
        include "connection.php";
        $TicketInfo = "SELECT * FROM ticket WHERE TicketNum = $TicketNum";
        
        $TicketInfoResult = mysqli_query($conn, $TicketInfo);
        
        if($TicketInfoResult -> num_rows>0){
            $row = $TicketInfoResult ->fetch_assoc();
            $TicketNum = $row["TicketNum"];
            $Status = $row["Stat"];
            $LastUpdatedAt = $row["LastUpdatedAt"];
            $Subj = $row["subj"];
            $Description = $row["Description"];
            $DateCreated = $row["DateCreated"];
            $Concern = $row["Concern"];
            $Email = $row["Email"];
        }
    ?>
    <!-- Content -->
   <h1><a href="Home.php">Back?</a></h1>
    <div class="container-fluid InfoContainer">
        <div class="row py-1">
            <div class="col-6 ">
                <label for=""><strong>Ticket ID: </strong> <span><?php echo $TicketNum?></span></label>
                
            </div>

            <div class="col-6">
                <label for=""><strong>Status: </strong><span><?php echo $Status?></span></label>
                
            </div>
        </div>

        <div class="row py-1">
            <div class="col-6">
                <label for=""><strong>Concern: </strong> <span><?php echo $Concern?></span></label>
                
            </div>

            <div class="col-6">
                <label for=""><strong>Email: </strong> <span><?php echo $Email?></span></label>
            </div>
        </div>

        <div class="row py-1">
            <div class="col-6">
                <label for=""><strong>Date Created: </strong> <span><?php echo ConvertDate($DateCreated)?></span></label>
                
            </div>

            <div class="col-6">
                <label for=""><strong>Last Updated: </strong> <span><?php echo ConvertDate($LastUpdatedAt)?></span></label>
            </div>
        </div>

        <div class="row py-1">
            

            <div class="col-6">
                <?php
                    if($Status == "Open"){
                        echo '<button type ="submit" name ="Action" value="Edit" id="EditBtn" onclick="window.location.href='.$TicketNum.'"><i class="fa-solid fa-pen-to-square"></i> Edit</button>';
                        echo '<button type ="submit" name ="Action" value="Edit" id="DeleteBtn" onclick="deleteTicket('.$TicketNum.')"><i class="fa-solid fa-pen-to-square"></i> Delete</button>';
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="container-fluid TicketContentContainer">
        <h3><?php echo $Subj?></h3>
        <p><?php echo $Description?></p>
    </div>

    <?php 
       
        $FetchReply = "SELECT * FROM reply WHERE TicketNum = $TicketNum";

        $FetchResult = mysqli_query($conn, $FetchReply);

        if($FetchResult -> num_rows >0){
            while($row = $FetchResult-> fetch_assoc()){
                echo '<div class="container-fluid ReplyContainer">
                        <div class="UserInfo">
                            <h6>'.$row["LastName"].'</h6>
                            <p>'.ConvertDate($row["DateCreated"]).'</p>
                        </div>   
                        <p>'.$row["Message"].'</p>
                    </div>';
            }
        }else{
            
        }
    
    ?>
    <div class="container-fluid ReplyInput">
        <form action="Process.php?TicketNum=<?php echo $_GET["TicketNum"] ?>" method="post" onsubmit="return validateForm()">
            <textarea name="Message" id="Message" placeholder="Enter your reply here..."></textarea>
            <button type="submit" name="Action" value="ReplyTicket">Reply</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        const createButton = document.getElementById('createButton');

        function validateForm() {
            const message = document.getElementById("Message").value.trim();
            if (message === "") {
                
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
        function deleteTicket(TicketNum){
            if(confirm("Are you sure you want to delete this ticket?")){
                window.location.href = `Process.php?Delete=True&TicketNum=${TicketNum}`
            }
        }
    </script>
</body>
</html>