<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "sales";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   

    if('GET_BY_ADMIN' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $pid = $_POST['pid'];  
        $query = "SELECT * FROM $table WHERE FIND_IN_SET('" . $pid . "', pid) = 1 AND amount = paid";
        $result = $db->query($query);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_REC_BY_ADMIN' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $pid = $_POST['pid'];  
        $query = "SELECT * FROM $table WHERE FIND_IN_SET('" . $pid . "', pid) = 1 AND amount != paid";
        $result = $db->query($query);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_COMPLETE' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $eid = $_POST['eid'];
        $query = "SELECT * FROM $table WHERE eid = '".$eid."' AND amount = paid";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }   

    if('GET_RECEIVABLE' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $eid = $_POST['eid'];
        $query = "SELECT * FROM $table WHERE eid = '".$eid."' AND amount != paid";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_ONE' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $prcid = $_POST['prcid'];
        $query = "SELECT * FROM $table WHERE prcid = '".$prcid."'";
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

    if('UPDATE_PAID' == $action){
        $saleid = $_POST['saleid'];
        $paid = $_POST['paid'];
        $sql = "UPDATE $table SET  paid = '$paid' WHERE saleid = '$saleid'";
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
        $sql = "UPDATE $table SET  amount = '$amount' WHERE saleid = '$saleid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_ONE_QUANTITY' == $action){
        $sid = $_POST['sid'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE $table SET  quantity = '$quantity' WHERE sid = '$sid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_SPRICE' == $action){
        $sid = $_POST['sid'];
        $sprice = $_POST['sprice'];
        $sql = "UPDATE $table SET  sprice = '$sprice' WHERE sid = '$sid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }



    if('UPDATE_AMOUNT' == $action){
        $saleid = $_POST['saleid'];
        $customer = $_POST['customer'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];
        $paid = $_POST['paid'];
        $method = $_POST['method'];
        $due = $_POST['due'];
        $date = $_POST['date'];
        
        $sql = "UPDATE $table SET customer = '$customer', phone = '$phone', amount = '$amount', paid = '$paid', method = '$method', due = '$due', date = '$date' WHERE saleid = '$saleid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE' == $action){
        $sid = $_POST['sid'];
        $customer = $_POST['customer'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];
        $paid = $_POST['paid'];
        $method = $_POST['method'];
        $due = $_POST['due'];
        $date = $_POST['date'];
        $quantity = $_POST['quantity'];
        $bprice = $_POST['bprice'];
        $sprice = $_POST['sprice'];
    
        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE sid = '$sid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "UPDATE $table SET customer = '$customer', phone = '$phone', amount = '$amount', paid = '$paid', quantity = '$quantity', bprice = '$bprice', sprice = '$sprice', method = '$method', due = '$due', date = '$date' WHERE sid = '$sid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "failed";
            }
        }
        $conn->close();
        return;
    }


    if('UPDATE_QUANTITY' == $action){
        $saleid = $_POST['saleid'];
        $productid = $_POST['productid'];
        $quantity = $_POST['quantity'];
        $amount = $_POST['amount'];
        $sql = "UPDATE $table SET quantity = '$quantity', amount = '$amount'  WHERE saleid = '$saleid' AND productid = '$productid' ";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
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

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE saleid = '$saleid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE saleid = '$saleid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        }

        $conn->close();
        return;
    }

    if('DELETE_SID' == $action){
        $sid = $_POST['sid'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE sid = '$sid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE sid = '$sid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        }

        $conn->close();
        return;
    }

    if('DELETE' == $action){
        $saleid = $_POST['saleid'];
        $productid = $_POST['productid'];
        $sql = "DELETE FROM $table WHERE saleid = '$saleid' AND productid = '$productid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
