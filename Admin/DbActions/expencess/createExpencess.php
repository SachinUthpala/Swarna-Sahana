<?php

require_once '../Db.conn.php';
session_start();

if(isset($_POST['createTask'])){
    $date = date('Y-m-d');
    $userID = (int)$_POST['userID'];
    $exType = $_POST['expences_type'];
    $amount = (int)$_POST['amount'] * 8;
    $userName = $_POST['userNAme'];

    $distance = $amount / 8 ;
    $distance = (int)$distance;
    

    $findUserAvailableSql = "SELECT * FROM total_expencess WHERE userID = '$userID'";
    $resultAvailableSql = mysqli_query($conn , $findUserAvailableSql);
    
    if($resultAvailableSql->num_rows > 0){
        $sqlForTotal = "SELECT amount FROM total_expencess WHERE userID = '$userID'";
        $TotalResult = mysqli_query($conn , $sqlForTotal);
        $totalFeeRow = $TotalResult->fetch_assoc();
    
        $totalFee_last = (int)$totalFeeRow['amount'] + (int)$amount; 

        $sqlForUpdateTotal = "UPDATE `total_expencess` SET `amount`='$totalFee_last' WHERE userID = '$userID'";
        $sqlForUpdateTotal_result = mysqli_query($conn , $sqlForUpdateTotal);

        // ///////////////////////
  
    
           

                $sqlInsertExpences = "INSERT INTO `expencess`( `user_id`, `expencess_type`, `amount`, `date` , `reciptImg` , `distance`) 
                VALUES ('$userID' , '$exType' , '$amount' , '$date' , 'none' , '$distance')";
                $resultsqlInsertExpences = mysqli_query($conn , $sqlInsertExpences);
           
     
        // ///////////////////////

        

    }else{
        $sqlInsetUerEx = "INSERT INTO `total_expencess`(`userID`, `userName`, `amount`) 
        VALUES ('$userID' , '$userName' , $amount)";
        $resultsqlInsetUerEx = mysqli_query($conn , $sqlInsetUerEx);


        
    
     
                $sqlInsertExpences = "INSERT INTO `expencess`( `user_id`, `expencess_type`, `amount`, `date` , `reciptImg`) 
                VALUES ('$userID' , '$exType' , '$amount' , '$date' , 'none' )";
                $resultsqlInsertExpences = mysqli_query($conn , $sqlInsertExpences);
            
        
     
    }

        $_SESSION['TaskCreated'] = 1;
        header("Location: ../../AdminPanel/CreateExpencess.php");
        echo "Task Created Successfully";

    





}


?>