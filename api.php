<?php
header('Content-Type: application/json');


$servername = "localhost:4306";
$username = "root"; 
$password = ""; 
$dbname = "filters_det"; 

$conn = new mysqli($servername, $username, $password, $dbname);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


$field = isset($_GET['field']) ? $_GET['field'] : '';

if ($field) {
    
    $allowed_fields = ['oil_filters', 'diesel_filters', 'water_filters', 'air_filters', 'oil', 'coolant', 'avr', 'belts', 'aluminium_cables'];
    
    if (!in_array($field, $allowed_fields)) {
        echo json_encode(["error" => "Invalid field name"]);
        exit;
    }

   
    $sql = "SELECT $field FROM filters_details";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while($row = $result->fetch_assoc()) {
            if ($row[$field] !== null) {
                $data[] = $row[$field];
            }
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(["error" => "No field specified"]);
}

$conn->close();
?>