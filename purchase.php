<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "purchases";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('ADD' == $action){
        $purchaseid = $_POST['purchaseid'];
        $productid = $_POST['productid'];
        $prcid = $_POST['prcid'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $purchaser = $_POST['purchaser'];
        $bprice = $_POST['bprice'];
        $amount = $_POST['amount'];
        $paid = $_POST['paid'];
        $quantity = $_POST['quantity'];
        $type = $_POST['type'];
        $date = $_POST['date'];
        $due = $_POST['due'];

        $sql = "SELECT prcid FROM $table WHERE  prcid = '".$prcid."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            echo 'Exists';
        }else {
            $insert = "INSERT INTO $table(purchaseid,productid,prcid,eid,pid,purchaser,bprice,amount,paid,quantity,type,date,due,checked) 
            VALUES ('".$purchaseid."','".$productid."','".$prcid."','".$eid."','".$pid."','".$purchaser."','".$bprice."','".$amount."','".$paid."','".$quantity."','".$type."','".$date."','".$due."','true')";
            $query = mysqli_query($db,$insert);
            if($query){
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }
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


    if('GET_BY_PURCHASEID' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $purchaseid = $_POST['purchaseid'];
        $query = "SELECT * FROM $table WHERE purchaseid = '".$purchaseid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_PRODUCTID' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $purchaseid = $_POST['purchaseid'];
        $productid = $_POST['productid'];
        $query = "SELECT * FROM $table WHERE purchaseid = '".$purchaseid."' AND productid = '".$productid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

   
    if('DELETE_PRCID' == $action){
        $prcid = $_POST['prcid'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE prcid = '$prcid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE prcid = '$prcid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
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
        $purchaseid = $_POST['purchaseid'];
        $productid = $_POST['productid'];
        $sql = "DELETE FROM $table WHERE purchaseid = '$purchaseid' AND productid = '$productid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
