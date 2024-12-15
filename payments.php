<?php
    

    if('UPDATE_PURCHASE_AMOUNT' == $action){
        $purchaseid = $_POST['purchaseid'];
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        $items = $_POST['items'];
        $sql = "UPDATE $table SET amount = '$amount', items = '$items', type = '$type' WHERE purchaseid = '$purchaseid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_PURCHASE_PAID' == $action){
        $purchaseid = $_POST['purchaseid'];
        $paid = $_POST['paid'];
        $type = $_POST['type'];
        $method = $_POST['method'];
        $sql = "UPDATE $table SET paid = '$paid', type = '$type', method = '$method' WHERE purchaseid = '$purchaseid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_SALE_AMOUNT' == $action){
        $saleid = $_POST['saleid'];
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        $items = $_POST['items'];
        $sql = "UPDATE $table SET amount = '$amount', items = '$items', type = '$type' WHERE saleid = '$saleid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_SALE_PAID' == $action){
        $saleid = $_POST['saleid'];
        $paid = $_POST['paid'];
        $type = $_POST['type'];
        $method = $_POST['method'];
        $sql = "UPDATE $table SET paid = '$paid', type = '$type', method = '$method' WHERE saleid = '$saleid'";
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
