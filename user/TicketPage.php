<?php 
session_start();
include("../database/connection.php");

// $userID = $_SESSION['user_id'];
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

<div class="container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Ticket Page</h1>

    <?php
    include("../database/connection.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seat_number'])) {
        $scheduleID = $_POST['schedule_id'];
        $busID = $_POST['bus_id']; 
        $price = $_POST['price'];  
        $seatNumber = $_POST['seat_number']; 
        $userID = $_SESSION["user_id"]; 
        $paymentMethod = $_POST['payment_method'];
        
    $sql = "INSERT INTO Ticket (DepartureCity, DestinationCity, DepartureDateTime, ArrivalDateTime, Price, SeatNumber, UserID, BusID, DriverID, ScheduleID)
        SELECT r.StartLocation, r.EndLocation, s.TravelingDate, DATE_ADD(s.TravelingDate, INTERVAL 1 DAY), $price, $seatNumber, $userID, $busID, b.DriverID, $scheduleID
        FROM Schedule s
        JOIN Bus b ON s.BusID = b.BusID
        JOIN Route r ON b.RouteID = r.RouteID
        WHERE s.ScheduleID = $scheduleID";


        if ($conn->query($sql) === TRUE) {
            $ticketID = $conn->insert_id;

            // Insert payment
            $sql = "INSERT INTO Payment (UserID, TicketID, PaymentMethod, Price, Status)
                    VALUES ($userID, $ticketID, '$paymentMethod', $price, 'Completed')";
            $conn->query($sql);
                ?>
            <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col-reverse md:flex-row md:justify-between align-middle">  
                <div class="flex flex-col ">
                    <h2 class="text-2xl font-bold p-6 mb-4">Your Ticket</h2>
                    <!-- <p class="mb-2"><strong>Ticket ID:</strong> <?php //echo $ticketID ?></p> -->
                    <?php 
                    $query=mysqli_query($conn,"SELECT * from UserTicketView where UserID=$userID and TicketID= $ticketID ;");
                    while($run=mysqli_fetch_array($query)){?>

                    <p> <?php echo "<strong>TicketID:</strong> ". $run["TicketID"]?> </p>
                    <p> <?php echo "<strong>DepartureCity:</strong>  ". $run["DepartureCity"];?> </p>
                    <p> <?php echo "<strong>DestinationCity:</strong>  ". $run["DestinationCity"];?> </p>
                    <p> <?php echo "<strong>DepartureDateTime:</strong>  ". $run["DepartureDateTime"];?> </p>
                    <p> <?php echo "<strong>ArrivalDateTime:</strong>  ". $run["ArrivalDateTime"];?> </p>
                    <p> <?php echo "<strong>Price:</strong>  ". $run["Price"];?> </p>
                    <p> <?php echo "<strong>SeatNumber:</strong>  ". $run["SeatNumber"];?> </p>
                    <p> <?php echo "<strong>UserName:</strong> ". $run["UserName"];?> </p>
                    <p> <?php echo "<strong>UserEmail:</strong> ". $run["UserEmail"];?> </p>
                    <p> <?php echo "<strong>UserPhone:</strong> ". $run["UserPhone"];?> </p>
                    <p> <?php echo "<strong>BusLevel:</strong> ". $run["BusLevel"];?> </p>
                    <p> <?php echo "<strong>BusType:</strong> ". $run["BusType"];?> </p>
                    <p> <?php echo "<strong>LicensePlate:</strong> ". $run["LicensePlate"];?> </p>
                    <p> <?php echo "<strong>DriverName:</strong> ". $run["DriverName"];?> </p>
                    <p> <?php echo "<strong>DriverEmail:</strong> ". $run["DriverEmail"];?> </p>
                <?php }?>

                </div>
                <div id="qrCodeContainer"></div>
            </div>
            <h1 class="text-3xl font-semibold border-yellow-400 border-2 p-4 rounded-md shadow-md mx-auto mt-2">Take Screenshoot of this page</h1>
            <?php 
        } else {
            echo '<p class="text-red-500">Error: ' . $conn->error . '</p>';
        }
    } 

$sql = "SELECT 
            t.TicketID, 
            t.DepartureCity, 
            t.DestinationCity, 
            t.DepartureDateTime, 
            t.ArrivalDateTime,
            u.UserName,
            u.UserEmail 
        FROM Ticket t
        JOIN User u ON t.UserID = u.UserID
        WHERE t.TicketID = $ticketID AND t.UserID = $userID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $ticket = $result->fetch_assoc();
    $departure = $ticket['DepartureCity'];
    $destination = $ticket['DestinationCity'];
    $departureDateTime = $ticket['DepartureDateTime'];
    $date = date('Y-m-d', strtotime($departureDateTime));
    $time = date('H:i', strtotime($departureDateTime));

    $TicketLink = "TicketID={$ticket['TicketID']}&UserID={$userID}&Departure={$departure}&Destination={$destination}&ScheduleID={$scheduleID}";
} else {
    echo "No ticket found.";
    exit();
}
    $conn->close();
    ?>
</div>
<script>
    window.onload = function() {
        console.log("<?php echo $TicketLink?>" );
        generateQRCode("<?php echo $TicketLink?>" );
    
}
    function generateQRCode(qrInput) {
    const qrCodeContainer = document.getElementById('qrCodeContainer');

    if (qrInput.trim() !== '') {
        qrCodeContainer.innerHTML = '';

        const canvas = document.createElement('canvas');
        qrCodeContainer.appendChild(canvas);

        // Generate the QR code using the QRious library
        const qrious = new QRious({
            element: canvas,
            value: qrInput,
            size: 300
        });
    } else {
        qrCodeContainer.innerHTML = 'Please enter text or a URL.';
    }
}

// Include the QRious library
const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js';
document.body.appendChild(script);
</script>
</body>
</html>
