<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /LetsGO/auth/login.php");
    exit();
}
include("../database/connection.php");

$sql = "UPDATE Schedule SET TravelStatus = 'done' WHERE TravelStatus = 'pending' AND CONCAT(TravelingDate, ' ', StartingTime) < NOW()";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error updating records: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Book Your Bus</h1>

    <?php

    if(isset($_GET['bus_id'])) {
        $selectedBusID = $_GET['bus_id'];
        $sql = "SELECT * FROM Schedule WHERE TravelStatus='pending' AND BusID = $selectedBusID";
        $scheduleResult = $conn->query($sql);

        if($scheduleResult->num_rows > 0) {    ?>
            <h2 class="text-xl font-bold mb-4">Select Travel Date and Time</h2>
            <form method="GET" action="BookBus.php" class="mb-6">  
                <input type="hidden" name="bus_id" value="<?php echo $selectedBusID ?>" >
                <div class="mb-4">
                    <label for="schedule" class="block text-gray-700">Available Schedules:</label>
                    <select name="schedule_id" id="schedule" class="w-full p-2 border border-gray-300 rounded mt-2">
                <?php   while ($row = $scheduleResult->fetch_assoc()) {  
                        echo '<option value="' . $row['ScheduleID'] . '">' . $row['TravelingDate'] . ' - ' . $row['StartingTime'] . '</option>';
                        } ?> 
                    </select>
                    <div>
                        <?php 
                        // Fetch price factor for the bus category
                        $sql2 = "SELECT bc.priceFactor FROM Bus b JOIN BusCategory bc ON b.BusCategoryID = bc.BusCategoryID WHERE b.BusID = $selectedBusID";                            $result = $conn->query($sql2);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $priceFactor = $row['priceFactor'];
                            }

                            // Calculate price (simplified, based on distance and price factor)
                            $sql = "SELECT r.Distance FROM Bus b JOIN Route r ON b.RouteID = r.RouteID WHERE b.BusID = $selectedBusID";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $distance = $row['Distance'];
                            }
                            $price = $distance * $priceFactor;
                        ?>
                        <h1 class="font-semibold text-2xl">Price: <?php echo $price ?>ETB </h1>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Next</button>
            </form>
        <?php  } else {
            echo '<p class="text-red-500">No schedule available for this bus.</p>';
        }
    }

    if (isset($_GET['schedule_id'])) {
        $selectedScheduleID = $_GET['schedule_id'];

        // Fetch selected bus ID
        $busQuery = "SELECT BusID FROM Schedule WHERE ScheduleID = $selectedScheduleID";
        $busResult = $conn->query($busQuery);
        $busRow = $busResult->fetch_assoc();
        $selectedBusID = $busRow['BusID'];
        
        $busSeat = "SELECT SeatNumbers FROM bus WHERE BusID = $selectedBusID";
        $busResult = $conn->query($busSeat);
        $busRow = $busResult->fetch_assoc();
        $totalSeats = $busRow['SeatNumbers'];

        // Fetch available seats for the selected schedule
        // $sql = "SELECT SeatNumber FROM Ticket WHERE BusID = $selectedBusID AND DepartureDateTime = (SELECT CONCAT(TravelingDate, ' ', StartingTime) FROM Schedule WHERE ScheduleID = $selectedScheduleID)";
        $sql = "SELECT SeatNumber FROM Ticket WHERE BusID =$selectedBusID AND ScheduleID =$selectedScheduleID ;";
        $seatResult = $conn->query($sql);

        $occupiedSeats = [];
        if ($seatResult->num_rows > 0) {
            while ($row = $seatResult->fetch_assoc()) {
                $occupiedSeats[] = $row['SeatNumber'];
            }
        }

        echo '<div class="w-fit  mx-auto">';
        echo '<h2 class="text-xl font-bold mb-4">Select Seat</h2>';
        echo '<form method="POST" action="TicketPage.php">';
        echo '<input type="hidden" name="schedule_id" value="' . $selectedScheduleID . '">';
        echo '<input type="hidden" name="bus_id" value="' . $selectedBusID . '">';
        echo '<div class="flex flex-wrap  mx-auto w-fit border justify-right gap-4 mb-4">';

        for ($i = 1; $i <=$totalSeats; $i++) {
            if (in_array($i, $occupiedSeats)) {
                echo '<div class="p-4 bg-red-500 w-32 text-white rounded">Seat ' . $i . '<br>Occupied</div>';
            } else {
                echo '<div class="p-4 bg-green-500 w-32 text-white rounded"><label><input type="radio" name="seat_number" value="' . $i . '" required> Seat ' . $i . '<br>Available</label></div>';
            }
        }  ?>

        </div>
        <input type="hidden" name="price" value=" <?php echo $price ?> ">
        <input type="hidden" name="bus_id" value=" <?php echo $selectedBusID ?> ">
        <label for="payment_method">Payment Method</label>
        <select class="px-6 bg-blue-300 py-2" name="payment_method" id="payment_method">
            <option value="Telebirr">Telebirr</option>
            <option value="CBE">CBE</option>
            <option value="Abisinia">Abisinia</option>
            <option value="Awash">Awash</option>
            <option value="Coop">Coop</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Confirm Seat</button>
        </form>
        
    <?php 
        echo '</div>';
    }

    $conn->close();
    ?>

</div>

</body>
</html>
