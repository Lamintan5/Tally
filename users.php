<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "users";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

   

    if('UPDATE_PASS' == $action){
        $uid = $_POST['uid'];
        $password = md5($_POST['password']); 
       
        $sql = "UPDATE $table SET  password = '$password' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }


    if ('UPDATE_TOKEN' == $action) {
        $uid = $_POST['uid'];
        $token = $_POST['token'];
    
        // Check if the token is empty based on the uid
        $checkSql = "SELECT token FROM $table WHERE uid = '$uid'";
        $result = $conn->query($checkSql);
    
        if ($result->num_rows > 0) {
            // $row = $result->fetch_assoc();
            // if ($row['token']==="") {
            //     echo "Empty";
            // } else {
            //     // If the token is not empty, proceed with the update
            //     $updateSql = "UPDATE $table SET token = '$token' WHERE uid = '$uid'";
            //     if ($conn->query($updateSql) === TRUE) {
            //         echo "success";
            //     } else {
            //         echo "error";
            //     }
            // }
            $updateSql = "UPDATE $table SET token = '$token' WHERE uid = '$uid'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "success";
                } else {
                    echo "error";
                }
        } else {
            echo "Does Not Exist";
        }
    
        $conn->close();
        return;
    }
    

    if('DELETE' == $action){
        $uid = $_POST['uid'];
        $sql = "DELETE FROM $table WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }
    
?>
