<?php
$servername = "localhost"; // Change this to your MySQL server address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "draw_data"; // Change this to your MySQL database name

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["data"])) {
    $data = json_decode($_POST["data"], true);

    if (!empty($data) && is_array($data)) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO map (direction, distance) VALUES (?, ?)");

        foreach ($data as $movement) {
            $direction = $movement["direction"];
            $distance = $movement["distance"];
            $stmt->bind_param("si", $direction, $distance);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        echo "Data saved successfully.";
    } else {
        echo "No data received.";
    }
}
?>
