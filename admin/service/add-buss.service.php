<?php
include("../../database/connection.php");

if (isset($_POST["bus_type"])) {
    $BusCategoryID = $_POST['bus_type'];

    // Using prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT BusLevel, BusSeatNumbers, BusPicture FROM BusCategory WHERE BusCategoryID = ?");
    $stmt->bind_param("i", $BusCategoryID);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row) {
        $response = array(
            "BusLevel" => $row["BusLevel"],
            "BusSeatNumbers" => $row["BusSeatNumbers"],
            "BusPicture" => $row["BusPicture"]
        );
    } else {
        $response = array(
            "error" => "No data found for the provided BusCategoryID."
        );
    }

    // Send the response back to the JavaScript
    echo json_encode($response);

    // Closing the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
