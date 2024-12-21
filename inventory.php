<?php
    
    if('UPDATE_BY_PRODUCTID' == $action){
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE $table SET quantity = '$quantity' WHERE productid = '$productid'";
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
        $iid = $_POST['iid'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE iid = '$iid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE iid = '$iid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        }
        
        $conn->close();
        return;
    }
?>
