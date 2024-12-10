<?php
   
    if('UPDATE' == $action){
        $did = $_POST['did'];
        $duties = $_POST['duties'];  
        $sql = "UPDATE $table SET  duties = '$duties' WHERE did = '$did'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('DELETE_EID' == $action){
        $eid = $_POST['eid'];
        $sql = "DELETE FROM $table WHERE eid = '$eid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('DELETE' == $action){
        $did = $_POST['did'];
        $sql = "DELETE FROM $table WHERE did = '$did'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
