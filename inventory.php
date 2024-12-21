<?php
    
    if('UPDATE' == $action){
        $iid = $_POST['iid'];
        $quantity = $_POST['quantity'];
        $type = $_POST['type'];
        $sql = "UPDATE $table SET quantity = '$quantity', type = '$type' WHERE iid = '$iid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_QUANTITY' == $action){
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        
        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE productid = '$productid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "UPDATE $table SET quantity = '$quantity' WHERE productid = '$productid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "failed";
            }
        }
        
        $conn->close();
        return;
    }

    if ('UPDATE_SUB_QNTY' == $action) {
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        
        $checkSql = "SELECT quantity FROM $table WHERE productid = '$productid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();
    
        if ($result->num_rows == 0) {
            echo "Does not exist";
        } else {
            $currentQuantity = $row['quantity'];
            $newQuantity = $currentQuantity - $quantity;

            if ($newQuantity < 0) {
                $newQuantity = 0;
            }
            
            $sql = "UPDATE $table SET quantity = '$newQuantity' WHERE productid = '$productid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "failed";
            }
        }
        
        $conn->close();
        return;
    }

    if ('UPDATE_ADD_QNTY' == $action) {
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        
        $checkSql = "SELECT quantity FROM $table WHERE productid = '$productid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();
    
        if ($result->num_rows == 0) {
            echo "Does not exist";
        } else {
            $currentQuantity = $row['quantity'];
            $newQuantity = $currentQuantity + $quantity;
            
            // Update the quantity with the new value
            $sql = "UPDATE $table SET quantity = '$newQuantity' WHERE productid = '$productid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "failed";
            }
        }
        
        $conn->close();
        return;
    }    
    
    if ('UPDATE_DIFF_QNTY' == $action) {
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        
        $checkSql = "SELECT quantity FROM $table WHERE productid = '$productid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();
    
        if ($result->num_rows == 0) {
            echo "Does not exist";
        } else {
            $currentQuantity = $row['quantity'];
            $newQuantity = $currentQuantity + $quantity;

            if ($newQuantity < 0) {
                $newQuantity = 0;
            }
            
            $sql = "UPDATE $table SET quantity = '$newQuantity' WHERE productid = '$productid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "failed";
            }
        }
        $conn->close();
        return;
    }

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
