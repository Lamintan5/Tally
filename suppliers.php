<?php
    
    if('UPDATE' == $action){
        $sid = $_POST['sid'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $company = $_POST['company'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE sid = '$sid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "UPDATE $table SET name = '$name', category = '$category', company = '$company', phone = '$phone', email = '$email' WHERE sid = '$sid'";
            if ($conn->query($sql) === TRUE) { 
                echo "success";
            } else {
                echo "error";
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
                echo "error";
            }
        }
        
        $conn->close();
        return;
    }
?>
