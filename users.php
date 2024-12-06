<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tally";
    $table = "users";

    $action = $_POST['action'];
    $db = mysqli_connect('localhost','root','','tally');
    $conn = new mysqli($servername, $username, $password, $dbname);

   

    if('REGISTER' == $action){

        $uid = $_POST['uid'];
        $username = $_POST['username'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];   
        $password = md5($_POST['password']); 
        $status = $_POST['status'];
        $country = $_POST['country'];
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
                if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                    $image = $_FILES['image']['name'];
                    $imagePath = 'profile/' . $image;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    move_uploaded_file($tmp_name, $imagePath);
                } else {
                    $image = $_POST['image']; 
                }
                $insert = "INSERT INTO $table (uid,first,last,username,email,image,password,phone,status,country,token) 
                VALUES ('".$uid."','".$first."','".$last."','".$username."','".$email."','".$image."','".$password."','".$phone."','".$status."','".$country."','".$token."')";
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

    if('LOGIN_EMAIL' == $action){
        $email = $_POST['email'];
        $sql = "SELECT *FROM $table WHERE BINARY  email = '".$email."'" ;
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

    if('UPDATE_PROFILE' == $action){
        $image = $_FILES['image']['name'];
        $uid = $_POST['uid'];
        $username = $_POST['username'];
        $first = $_POST['first'];
        $last = $_POST['last'];

        $sqlCheckUsername = "SELECT username FROM $table WHERE uid = '$uid'";
        $resultCheckUsername = mysqli_query($db, $sqlCheckUsername);
        $row = mysqli_fetch_assoc($resultCheckUsername);
        
        if ($row['username'] !== $username) {
            $sqlCheckExistence = "SELECT username FROM $table WHERE username = '$username'";
            $resultCheckExistence = mysqli_query($db, $sqlCheckExistence);
            $count = mysqli_num_rows($resultCheckExistence);

            if ($count > 0) {
                echo 'UsernameExists';
                return;
            }
        }

        if($count > 0) {
            echo 'Exists';
        } else { 
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $imagePath = 'profile/' . $image;
                $tmp_name = $_FILES['image']['tmp_name'];
                move_uploaded_file($tmp_name, $imagePath);
            } else {
                $image = $_POST['image']; 
            }
            $sql = "UPDATE $table SET username = '$username', first = '$first', last = '$last'";
            if (!empty($imagePath)) {
                $sql .= ", image = '$image'";
            }
    
            $sql .= " WHERE uid = '$uid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success, ${count}";
            } else {
                echo "error";
            }
        }

        $conn->close();
        return;
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

    if('UPDATE_PHONE' == $action){
        $uid = $_POST['uid'];
        $phone = $_POST['phone'];   

        $sql = "UPDATE $table SET phone = '$phone' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }

    if('UPDATE_EMAIL' == $action){
        $uid = $_POST['uid'];
        $email = $_POST['email'];   

        $sql = "SELECT email FROM $table WHERE BINARY email = '".$email."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count >= 1) {
            echo 'Error';
        } else {
            $sql = "UPDATE $table SET email = '$email' WHERE uid = '$uid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "error";
            }
        }
        $conn->close();
        return;
    }

    if('UPDATE_PASS' == $action){
        $uid = $_POST['uid'];
        $password = md5($_POST['password']); 
       
        $sql = "UPDATE $table SET  password = '$password' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }
        $conn->close();
        return;
    }


    if ('UPDATE_TOKEN' == $action) {
        $uid = $_POST['uid'];
        $token = $_POST['token'];
    
        // Check if the token is empty based on the uid
        $checkSql = "SELECT token FROM $table WHERE uid = '$uid'";
        $result = $conn->query($checkSql);
    
        if ($result->num_rows > 0) {
            // $row = $result->fetch_assoc();
            // if ($row['token']==="") {
            //     echo "Empty";
            // } else {
            //     // If the token is not empty, proceed with the update
            //     $updateSql = "UPDATE $table SET token = '$token' WHERE uid = '$uid'";
            //     if ($conn->query($updateSql) === TRUE) {
            //         echo "success";
            //     } else {
            //         echo "error";
            //     }
            // }
            $updateSql = "UPDATE $table SET token = '$token' WHERE uid = '$uid'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "success";
                } else {
                    echo "error";
                }
        } else {
            echo "Does Not Exist";
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
