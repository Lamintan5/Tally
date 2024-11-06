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
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $admin = $_POST['admin'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $location = $_POST['location'];

        $sql = "SELECT eid FROM $table WHERE BINARY eid = '".$eid."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count > 0){
            echo 'Exists';
        } else {
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $imagePath = 'logos/' . $image;
                move_uploaded_file($tmp_name, $imagePath);
            } else {
                $image = $_POST['image']; 
            }
            $insert = "INSERT INTO $table(eid,pid,admin,title,category,location,image,checked) 
            VALUES ('".$eid."','".$pid."','".$admin."','".$title."','".$category."','".$location."','".$image."','true')";
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

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $imagePath = 'logos/' . $image;
            move_uploaded_file($tmp_name, $imagePath);
        } else {
            $image = $_POST['image']; 
        }
        $sql = "UPDATE $table SET pid = '$pid', title = '$title', category = '$category', image = '$image'";
    

        $sql .= " WHERE eid = '$eid'";
        if ($conn->query($sql) === TRUE) { 
            echo "success";
        } else {
            echo "error";
        }

        $conn->close();
        return;
    }

    if ('UPDATE_PID' == $action) {
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
    
        $tables = ['entity', 'inventory', 'products', 'purchases', 'sales', 'suppliers', 'payments']; 
    
        $success = true;
    
        foreach ($tables as $table) {
            $sql = "UPDATE $table SET pid = '$pid' WHERE eid = '$eid'";
            if ($conn->query($sql) !== TRUE) {
                $success = false;
                break;
            }
        }
    
        if ($success) {
            echo "success";
        } else {
            echo "failed";
        }
    
        $conn->close();
        return;
    }

    if ('UPDATE_ADMIN' == $action) {
        $eid = $_POST['eid'];
        $uid = $_POST['uid'];

        $tables = ['entity',  'payments']; 
    
        $sql = "SELECT `admin` FROM entity WHERE eid = '$eid'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $adminField = $row['admin'];
    
            if (empty($adminField)) {
                $newAdminField = $uid;
            } else {
                $uidsArray = explode(',', $adminField);
                if (!in_array($uid, $uidsArray)) {
                    $newAdminField = $adminField . ',' . $uid;
                } else {
                    $newAdminField = $adminField;
                }
            }

            foreach ($tables as $table) {
                $updateSql = "UPDATE $table SET `admin` = '$newAdminField' WHERE eid = '$eid'";
                if ($conn->query($updateSql) !== TRUE) {
                    echo "failed";
                    $conn->close();
                    return;
                }
            }
    
            
    
            echo "success";
        } else {
            echo "Does not exist";
        }
    
        $conn->close();
        return;
    }
    

    if ('REMOVE_ADMIN' == $action) {
        $eid = $_POST['eid'];
        $uid = $_POST['uid'];
    
        $tables = ['entity',  'payments']; 
    
        $sql = "SELECT `admin` FROM entity WHERE eid = '$eid'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $adminField = $row['admin'];
    
            if (!empty($adminField)) {
                $uidsArray = explode(',', $adminField);
                $uidsArray = array_filter($uidsArray, function($item) use ($uid) {
                    return $item != $uid;
                });
                $newAdminField = implode(',', $uidsArray);
            } else {
                $newAdminField = '';
            }

            foreach ($tables as $table) {
                $updateSql = "UPDATE $table SET `admin` = '$newAdminField' WHERE eid = '$eid'";
                if ($conn->query($updateSql) !== TRUE) {
                    echo "failed";
                    $conn->close();
                    return;
                }
            }
            echo "success";
        } else {
            echo "Does not exist";
        }
    
        $conn->close();
        return;
    }


    if('DELETE' == $action){
        $eid = $_POST['eid'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE eid = '$eid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE eid = '$eid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "error";
            }
        }

        $conn->close();
        return;
    }
?>
