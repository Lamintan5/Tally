<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "users";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if('REGISTER' == $action){
        $image = $_FILES['image']['name'];
        $uid = $_POST['uid'];
        $username = $_POST['username'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];   
        $password = md5($_POST['password']); 
        $type = $_POST['type'];
        $url = $_POST['url'];
        $status = $_POST['status'];
        $token = $_POST['token'];
        
        $sql = "SELECT email FROM $table WHERE BINARY email = '".$email."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);
    
        $sql1 = "SELECT username FROM $table WHERE username = '".$username."'";
        $result1 = mysqli_query($db,$sql1);
        $count1 = mysqli_num_rows($result1);
    
        if($count1 == 1){
            echo 'Exists';
        } else {
            if($count == 1) {
                echo 'Error';
            } else {
                if (!empty($image)) {
                    $imagePath = 'profile/' . $image;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    move_uploaded_file($tmp_name, $imagePath);
                }
                $insert = "INSERT INTO $table (uid,first,last,username,email,image,password,type,url,phone,status,token) VALUES ('".$uid."','".$first."','".$last."','".$username."','".$email."','".$image."','".$password."','".$type."','".$url."','".$phone."','".$status."','".$token."')";
                $query = mysqli_query($db,$insert);
                if($query){
                    echo 'Success';
                } else {
                    echo 'Failed';
                }
            }
        }
    }

    if('LOGIN' == $action){
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT *FROM $table WHERE BINARY  email = '".$email."' AND BINARY password = '".$password."'" ;
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);
        if($count == 1) {
            echo json_encode("Success");
        } else {
            echo json_encode("Error");
        }
    }
    
    if('GET' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $email = $_POST['email'];
        $query = "SELECT * FROM $table WHERE email = '".$email."'";
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
        $uid = $_POST['uid'];
        $query = "SELECT * FROM $table WHERE uid = '".$uid."'";
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
        $uid = $_POST['uid'];
        $username = $_POST['username'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];   
        $image = $_POST['image'];
        $password = md5($_POST['password']); 
        $type = $_POST['type'];

        $sql = "UPDATE $table SET username = '$username', first = '$first', last = '$last', email = '$email', phone = '$phone', image = '$image', password = '$password', type = '$type' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }

    if('UPDATE_TOKEN' == $action){
        $uid = $_POST['uid'];
        $token = $_POST['token']; 
       
        $sql = "UPDATE $table SET  token = '$token' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }

    if('DELETE' == $action){
        $uid = $_POST['uid'];
        $sql = "DELETE FROM $table WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }
    
?>
