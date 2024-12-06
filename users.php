<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "users";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    

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
