<?php
include 'connection.php';
date_default_timezone_set('Asia/Manila');
if (isset($_GET['Logout']) && $_GET['Logout'] == "True") {
    //Unsession variables that contain confidential data
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
if (isset($_GET['Delete']) && $_GET['Delete'] == "True") {
    $TicketNum = $_GET["TicketNum"];
    $DeleteTicket = "DELETE FROM ticket WHERE TicketNum = $TicketNum";
    $DeleteReplies = "DELETE FROM reply WHERE TicketNum = $TicketNum";
    $conn->query($DeleteReplies);
    $conn->query($DeleteTicket);
    header("Location: Home.php?Delete=success");
}


if (isset($_POST['Action'])) {
    $Action = $_POST['Action'];
    
    switch ($Action) {
        case 'ChangePass':
            $Username = $_POST["User"];
            $OldPass = $_POST["OldPass"];
            $NewPass = $_POST["NewPass"];

            $Select = "SELECT Username, Pass FROM user WHERE Username = ?";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $Username);
            $stmt->execute();
            $Result = $stmt->get_result();

            if ($Result->num_rows > 0) {
                $row = $Result->fetch_assoc();
                if ($row["Username"] == $Username) {
                    if ($row["Pass"] == $OldPass) {
                        
                        $Update = "UPDATE user SET Pass = ? WHERE Username = ?";
                        $updateStmt = $conn->prepare($Update);
                        $updateStmt->bind_param("ss", $NewPass, $Username);

                        if ($updateStmt->execute()) {
                            //If change password is success
                            header("Location: login.php?ChangePass=true");
                            exit();
                        } else {
                             //If change password is not success because some credentials doesn't match the records on DB
                            header("Location: ChangePass.php?Credentials=false");
                            exit();
                        }
                        $updateStmt->close();
                    } else {
                         //If change password is not success because INPUTED PASS doesn't match the records on DB
                        header("Location: ChangePass.php?Credentials=false");
                        exit();
                    }
                } else {
                    //If change password is not success because INPUTED USERNAME doesn't match the records on DB
                    header("Location: ChangePass.php?Credentials=false");
                    exit();
                }
            } 
            // else {
            //     header("Location: ChangePass.php?Credentials=false");
            //     exit();
            // }

            $stmt->close();
            break;
        case 'CreateAcc':
            $LastName = $_POST["LastName"];
            $FirstName = $_POST["FirstName"];
            $MiddleName = $_POST["MiddleName"];
            $Username = $_POST["Username"];
            $Pass = $_POST["Password"];
            $Role = $_POST["Role"];
            $Email = $_POST["Email"];

            $GetUserData = "SELECT * FROM user";
            $results = $conn->query($GetUserData);

            $duplicateUsername = false;

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    if ($Username == $row["Username"]) {
                        $duplicateUsername = true;
                        break;
                    }
                }
            }

            if ($duplicateUsername) {
                session_start();
                $_SESSION["LastName"] = $LastName;
                $_SESSION["FirstName"] = $FirstName;
                $_SESSION["MiddleName"] = $MiddleName;
                $_SESSION["Username"] = $Username;
                $_SESSION["Pass"] = $Pass;
                $_SESSION["Role"] = $Role;
                $_SESSION["Email"] = $Email;
                header("Location: AdminCreateAccount.php?Create=unsuccess");
                exit();
            } else {
                $SQL = "INSERT INTO user (LastName, FirstName, MiddleName, Username, Pass, Role, Email) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmnt = $conn->prepare($SQL);
                $stmnt->bind_param("sssssss", $LastName, $FirstName, $MiddleName, $Username, $Pass, $Role, $Email);

                if ($stmnt->execute()) {
                    header("Location: AdminCreateAccount.php?Create=success");
                    exit();
                } else {
                    echo "Error: " . $SQL . "<br>" . $conn->error;
                }
            }

            $stmnt->close();
            break;
        case 'Update':
            if (isset($_GET["TicketNum"])) {
                $TicketNum = $_GET["TicketNum"];
            }
            $Email = $_POST["Email"];
            $Concern = $_POST["Concern"];
            $Description = $_POST["Description"];
            $Subject = $_POST["Subject"];

            $SQL = "UPDATE ticket SET Email = ?, Concern = ?, Description = ?, subj = ? WHERE TicketNum = $TicketNum";
            $stmnt = $conn->prepare($SQL);
            $stmnt->bind_param("ssss", $Email, $Concern, $Description, $Subject);
            if ($stmnt->execute()) {
                UpdateDate($TicketNum, $conn);
                header("Location: Home.php?msg=edited");
                exit();
            } else {
                echo "Failed to update record: " . mysqli_error($conn);
            }
            break;
        case 'Login':
            session_start();
            $sql = "SELECT * FROM user";
            $result = $conn->query($sql);
            
            $UserEntered = $_POST["User"];
            $PassEntered = $_POST["Password"];
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if($UserEntered == $row["Username"] and $PassEntered == $row["Pass"]){
                        
                        $_SESSION['AccountID'] = $row["AccountID"];
                        $_SESSION['LastName'] = $row["LastName"];
                        $_SESSION['FirstName'] = $row["FirstName"];
                        $_SESSION['Role'] = $row["Role"];


                        if($row["Role"]== "Student"){
                            header("Location: Home.php");
                        }else{
                            header("Location: adminTicket.php");
                        }
                        exit();
                    }else{
                        header("Location: login.php?credentials=wrong");
                    }
                }
            }
            $stmnt->close();
            break;
        case 'ReplyTicket':
            session_start();
            if(isset($_GET["TicketNum"]) && isset($_SESSION["AccountID"])&& isset($_SESSION["LastName"])){
                $TicketNum = $_GET["TicketNum"];
                $AccountID = $_SESSION["AccountID"];
                $LastName = $_SESSION["LastName"];
                $Role = $_SESSION["Role"];
                echo "Reply Variables are found";
            }else{
                echo "Reply Variables are not found";
            }

            $Message = $_POST["Message"];
            $CreateReply = "INSERT INTO reply(DateCreated, Message, TicketNum, LastName) VALUES (CURRENT_TIMESTAMP, ?, ?, ?)";
            $stmnt = $conn ->prepare($CreateReply);
            $stmnt->bind_param("sis", $Message, $TicketNum, $LastName);
            if($stmnt->execute()){
                UpdateDate($TicketNum, $conn);
                // header("Location: view.php?TicketNum=$TicketNum");
                if($Role =="Student"){
                    header("Location: view.php?TicketNum=$TicketNum");
                }else{
                    header("Location: Adminview.php?TicketNum=$TicketNum");
                }
            }else{
                echo "Failed";
            }
            $stmnt->close();
            break;
        case 'CreateTicket':
            session_start();
            if (isset($_SESSION["AccountID"]) && isset($_SESSION["FirstName"]) && isset($_SESSION["LastName"])) {
                $AccountId = $_SESSION["AccountID"];
                $FirstName = $_SESSION["FirstName"];
                $LastName = $_SESSION["LastName"];
                $FullName = "{$LastName}, {$FirstName}";
            } else {
                echo "User is not logged in.";
                exit();
            }
        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $Status = "Open";
                $Email = $_POST["Email"];
                $Concern = $_POST["Concern"];
                $Description = $_POST["Description"];
                $Subject = $_POST["Subject"];
                
                $SQL = "INSERT INTO Ticket(DateCreated, LastUpdatedAt, Stat, Email, Concern, Description, subj, FullName, AccountID)
                VALUES (CURRENT_TIMESTAMP,CURRENT_TIMESTAMP, ?, ?, ?, ?, ?, ?, ?)";

                $stmnt = $conn->prepare($SQL);
                $stmnt->bind_param("ssssssi", $Status, $Email, $Concern, $Description, $Subject, $FullName, $AccountId);

                if ($stmnt->execute()) {
                    header("Location: Home.php?Create=success");
                    
                    exit();
                } else {
                    echo "Error: " . $SQL . "<br>" . $conn->error;
                }
                $stmnt->close();
            }
            $conn-> close();
            break;
        default:
            echo "Invalid Action";
            break;
    }
}

$conn->close();

function UpdateDate($TicketNum, $conn) {
    
    $Update = "UPDATE ticket SET LastUpdatedAt = CURRENT_TIMESTAMP WHERE TicketNum = $TicketNum";
    if ($conn->query($Update) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}



?>
