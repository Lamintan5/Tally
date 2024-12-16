<?php
   

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

    if ('UPDATE_SEEN' == $action) {
        $nid = $_POST['nid'];
        $uid = $_POST['uid'];
    
        $sql = "SELECT `seen` FROM $table WHERE nid = '$nid'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $seenField = $row['seen'];
    
            if (empty($seenField)) {
                $newSeenField = $uid;
            } else {
                $uidsArray = explode(',', $seenField);
                if (!in_array($uid, $uidsArray)) {
                    $newSeenField = $seenField . ',' . $uid;
                } else {
                    $newSeenField = $seenField;
                }
            }

            $updateSql = "UPDATE $table SET `seen` = '$newSeenField' WHERE nid = '$nid'";
            if ($conn->query($updateSql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        } else {
            echo "Does not exist";
        }
    
        $conn->close();
        return;
    }
    
    if ('UPDATE_DELETE' == $action) {
        $nid = $_POST['nid'];
        $uid = $_POST['uid'];
    
        $sql = "SELECT `deleted` FROM $table WHERE nid = '$nid'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $deleteField = $row['deleted'];
    
            if (empty($deleteField)) {
                $newDeleteField = $uid;
            } else {
                $uidsArray = explode(',', $deleteField);
                if (!in_array($uid, $uidsArray)) {
                    $newDeleteField = $deleteField . ',' . $uid;
                } else {
                    $newDeleteField = $deleteField;
                }
            }

            $updateSql = "UPDATE $table SET `deleted` = '$newDeleteField' WHERE nid = '$nid'";
            if ($conn->query($updateSql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
            }
        } else {
            echo "Does not exist";
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
