<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "payments";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('ADD' == $action){
        $payid = $_POST['payid'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $payerid = $_POST['payerid'];
        $admin = $_POST['admin'];
        $saleid = $_POST['saleid'];
        $purchaseid = $_POST['purchaseid'];
        $items = $_POST['items'];
        $amount = $_POST['amount'];
        $paid= $_POST['paid'];
        $type = $_POST['type'];
        $method = $_POST['method'];
        $time = $_POST['time'];
        $insert = "INSERT INTO $table(payid,eid,pid,payerid,admin,saleid,purchaseid,items,amount,paid,type,method,checked,time) 
        VALUES ('".$payid."','".$eid."','".$pid."','".$payerid."','".$admin."','".$saleid."','".$purchaseid."','".$items."','".$amount."','".$paid."','".$type."','".$method."','true','".$time."')";
        $query = mysqli_query($db,$insert);
        if($query){
            echo 'Success';
        } else {
            echo 'Failed';
        }
    }

    if('GET' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $prid = $_POST['prid'];
        $query = "SELECT * FROM $table WHERE prid = '".$prid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }


    if('GET_BY_ENTITY' == $action){
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

    if ('GET_CURRENT' == $action) {
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $pid = $db->real_escape_string($_POST['pid']); 
        $stmt = $db->prepare("SELECT * FROM $table WHERE FIND_IN_SET(?, pid)");
        $stmt->bind_param("s", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        $stmt->close();
    
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

    if('REMOVE_USER' == $action){
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $sql = "UPDATE $table SET pid = '$pid' WHERE eid = '$eid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE' == $action){
        $prid = $_POST['prid'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $volume = $_POST['volume'];
        $type = $_POST['type'];
        $supplier = $_POST['supplier'];
        $buying = $_POST['buying'];
        $selling = $_POST['selling'];
    
        $sql = "UPDATE $table SET name = '$name', category = '$category', quantity = '$quantity', volume = '$volume',  type = '$type', supplier = '$supplier', buying = '$buying', selling = '$selling' WHERE prid = '$prid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

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
