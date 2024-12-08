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
