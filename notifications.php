<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "notifications";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('ADD' == $action){
        $nid = $_POST['nid'];
        $sid = $_POST['sid'];
        $rid = $_POST['rid'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $text = $_POST['text'];
        $seen = $_POST['seen'];
        $actions = $_POST['actions'];
        $type = $_POST['type'];

        $sql = "SELECT sid, rid, eid, pid FROM $table WHERE BINARY sid = '".$sid."' AND rid = '".$rid."' AND eid = '".$eid."' AND pid = '".$pid."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            echo 'Exists';
        } else {
            $insert = "INSERT INTO $table(nid,sid,rid,eid,pid,text,seen,actions,type) 
            VALUES ('".$nid."','".$sid."','".$rid."','".$eid."','".$pid."','".$text."','".$seen."','".$actions."','".$type."')";
            $query = mysqli_query($db,$insert);
            if($query){
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }         
    }

    if('GET' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $nid = $_POST['nid'];
        $query = "SELECT * FROM $table WHERE nid = '".$nid."'";
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
        $rid = $_POST['rid'];
        $query = "SELECT * FROM $table WHERE rid = '".$rid."'";
        $result = $db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if('GET_UNSEEN' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $rid = $_POST['rid'];
        $query = "SELECT * FROM $table WHERE rid = '".$rid."' AND seen = ''";
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

    if('UPDATE' == $action){
        $nid = $_POST['nid'];
        $text = $_POST['text'];
        $type = $_POST['type'];  
        $actions = $_POST['actions'];  
        $sql = "UPDATE $table SET text = '$text', type = '$type', actions = '$actions' WHERE nid = '$nid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('UPDATE_SEEN' == $action){
        $rid = $_POST['rid'];
        $seen = $_POST['seen'];
        $actions = $_POST['actions'];  
        $sql = "UPDATE $table SET seen = '$seen' WHERE rid = '$rid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }

    if('DELETE' == $action){
        $nid = $_POST['nid'];
        $sql = "DELETE FROM $table WHERE nid = '$nid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
