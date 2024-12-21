<?php
    
    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('ADD' == $action){
        $iid = $_POST['iid'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $type = $_POST['type'];

        $sql = "SELECT productId FROM $table WHERE  productId = '".$productId."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            echo 'Exists';
        }else {
            $insert = "INSERT INTO $table(iid,eid,pid,productId,quantity,type,checked) 
            VALUES ('".$iid."','".$eid."','".$pid."','".$productId."','".$quantity."','".$type."','true')";
            $query = mysqli_query($db,$insert);
            if($query){
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }
    }

    if('GET_MY' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $pid = $_POST['pid'];
        $query = "SELECT * FROM $table WHERE FIND_IN_SET('" . $pid . "', pid)";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $iid = $_POST['iid'];
        $query = "SELECT * FROM $table WHERE iid = '".$iid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_BY_PRODUCT' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $productid = $_POST['productid'];
        $query = "SELECT * FROM $table WHERE productid = '".$productid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
    
    if('GET_CURRENT' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $eid = $_POST['eid'];
        $query = "SELECT * FROM $table WHERE eid = '".$eid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_PURCHASE' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $eid = $_POST['eid'];
        $query = "SELECT * FROM $table WHERE eid = '".$eid."' AND type = 'PURCHASE'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_ALL' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $query = "SELECT * FROM $table";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

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
