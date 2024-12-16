<?php
   
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
