<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LifeThread";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "call sign_up_patient('Brian2 Smith', 'b2smith', '1','123 Main st');";
$result = $conn->query($sql);
print_r ($result);
$sql = "SELECT * FROM User;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["Name"]. " - Address: " . $row["Address"]. " - UserID - " . $row["UserID"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
