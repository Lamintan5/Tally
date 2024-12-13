<?php
    
    if('GET_CURRENT' == $action){
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

    if ('UPDATE' == $action) {
        $prid = $_POST['prid'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $volume = $_POST['volume'];
        $type = $_POST['type'];
        $supplier = $_POST['supplier'];
        $buying = $_POST['buying'];
        $selling = $_POST['selling'];
    
        
        $checkSql = "SELECT COUNT(*) as count FROM $table WHERE prid = '$prid'";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();
    
        if ($row['count'] == 0) {
            echo "Does not exist";
        } else {
            $sql = "UPDATE $table SET name = '$name', category = '$category', quantity = '$quantity', volume = '$volume', type = '$type', supplier = '$supplier', buying = '$buying', selling = '$selling' WHERE prid = '$prid'";
            if ($conn->query($sql) === TRUE) {
                echo "success";
            } else {
                echo "failed";
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
        $prid = $_POST['prid'];
        $sql = "DELETE FROM $table WHERE prid = '$prid'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed";
        }
        $conn->close();
        return;
    }
?>
