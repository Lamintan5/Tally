<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "entity";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('ADD' == $action){
        $image = $_FILES['image']['name'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $title = $_POST['title'];
        $category = $_POST['category'];

        $sql = "SELECT eid FROM $table WHERE BINARY eid = '".$eid."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count > 0){
            echo 'Exists';
        } else {
            if (!empty($image)) { 
                $imagePath = 'logos/' . $image;
                $tmp_name = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp_name, $imagePath);
            }
            $insert = "INSERT INTO $table(eid,pid,title,category,image,checked) VALUES ('".$eid."','".$pid."','".$title."','".$category."','".$image."','true')";
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
        $eid = $_POST['eid'];
        $query = "SELECT * FROM $table WHERE eid = '".$eid."'";
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
        $pid = $_POST['pid'];  
        $query = "SELECT * FROM $table WHERE FIND_IN_SET('" . $pid . "', pid)";
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
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $sql = "UPDATE $table SET pid = '$pid', title = '$title', category = '$category' WHERE eid = '$eid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }

    if('DELETE' == $action){
        $eid = $_POST['eid'];
        $sql = "DELETE FROM $table WHERE eid = '$eid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }
?>
