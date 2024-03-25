<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "inventory";

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
        $insert = "INSERT INTO $table(iid,eid,pid,productId,quantity,type) 
        VALUES ('".$iid."','".$eid."','".$pid."','".$productId."','".$quantity."','".$type."')";
        $query = mysqli_query($db,$insert);
        if($query){
            echo 'Success';
        } else {
            echo 'Failed';
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
        $sql = "UPDATE $table SET quantity = '$quantity' WHERE productid = '$productid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
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

    if('DELETE' == $action){
        $iid = $_POST['iid'];
        $sql = "DELETE FROM $table WHERE iid = '$iid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
