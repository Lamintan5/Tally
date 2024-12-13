<?php
    

    if('ADD' == $action){
        $prid = $_POST['prid'];
        $eid = $_POST['eid'];
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $volume = $_POST['volume'];
        $supplier = $_POST['supplier'];
        $buying = $_POST['buying'];
        $selling = $_POST['selling'];
        $type = $_POST['type'];

        $sql = "SELECT prid FROM $table WHERE BINARY prid = '".$prid."'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);

        if($count == 0){
            $insert = "INSERT INTO $table(prid,eid,pid,name,category,quantity,volume,supplier,buying,selling,type, checked) 
            VALUES ('".$prid."','".$eid."','".$pid."','".$name."','".$category."','".$quantity."','".$volume."','".$supplier."','".$buying."','".$selling."','".$type."','true')";
            $query = mysqli_query($db,$insert);
            if($query){
                echo 'Success';
            } else {
                echo 'Failed';
            }
        } else {
            echo 'Exists';
        }
    }

    if('GET_MY' == $action){
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

    if('GET' == $action){
        if ($db->connect_errno) {
            die("Failed to connect to MySQL: " . $db->connect_error);
        }
        $prid = $_POST['prid'];
        $query = "SELECT * FROM $table WHERE prid = '".$prid."'";
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
