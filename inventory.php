<?php
    
    if('DELETE' == $action){
        $iid = $_POST['iid'];

        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE iid = '$iid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "DELETE FROM $table WHERE iid = '$iid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        }
        
        $conn->close();
        return;
    }
?>
