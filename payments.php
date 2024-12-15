<?php
    

    if('DELETE_SALEID' == $action){
        $saleid = $_POST['saleid'];
        $sql = "DELETE FROM $table WHERE saleid = '$saleid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('DELETE_PRCHID' == $action){
        $purchaseid = $_POST['purchaseid'];
        $sql = "DELETE FROM $table WHERE purchaseid = '$purchaseid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
    

    if('DELETE' == $action){
        $prid = $_POST['prid'];
        $sql = "DELETE FROM $table WHERE prid = '$prid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
