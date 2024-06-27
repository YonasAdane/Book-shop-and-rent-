<?php 
session_start();
if (!isset($_SESSION['driver_id'])) {
    header("Location: /LetsGO/auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetsGO Ticketing System</title>
    <?php include("./partials/imports.php")?>

</head>
<body x-data="{thisPath:window.location.pathname, isOpen: false}" class="bg-gray-100 font-family-karla flex">

<?php include("./partials/aside.php")?>
    
    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <?php include("./partials/header.php")?>
        <!-- Mobile Header & Nav -->
        <?php include("./partials/mobile-header.php")?>
    
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow ">
                
                <!-- Content -->

                <?php
                

                include("../database/connection.php");

                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['TicketID'], $_GET['UserID'], $_GET['Departure'], $_GET['Destination'], $_GET['ScheduleID'])) {
                    $ticketID = $_GET['TicketID'];
                    $userID = $_GET['UserID'];
                    $departure = $_GET['Departure'];
                    $destination = $_GET['Destination'];
                    $scheduleID = $_GET['ScheduleID'];
                    $currentDriverID = $_SESSION['driver_id']; 

                    // Prepare SQL statement to prevent SQL injection
                    $stmt = $conn->prepare("SELECT t.TicketID, t.ScheduleID, t.SeatNumber, t.UserID, t.BusID, t.DriverID, u.UserName, u.UserEmail, s.TravelingDate, s.StartingTime, d.DriverName, d.DriverID, b.BusType, b.LicensePlate, b.BusLevel 
                            FROM Ticket t
                            JOIN User u ON t.UserID = u.UserID
                            JOIN Schedule s ON t.ScheduleID = s.ScheduleID
                            JOIN Driver d ON t.DriverID = d.DriverID
                            JOIN Bus b ON t.BusID = b.BusID
                            WHERE t.TicketID = ? AND t.ScheduleID = ? AND t.UserID = ?");
                    $stmt->bind_param("iii", $ticketID, $scheduleID, $userID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $ticket = $result->fetch_assoc();
                        $isDriverCorrect = ($ticket['DriverID'] == $currentDriverID);
                        ?>
                        
                        <div class="container mx-auto p-8">
                            <div class="bg-white p-6 rounded-lg shadow-lg">
                                <h2 class="text-2xl font-bold text-center mb-4">Ticket Details</h2>
                                <div class="flex justify-center gap-8 items-center">
                                    <div class="">
                                        <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket['TicketID']); ?></p>
                                        <p><strong>User Name:</strong> <?php echo htmlspecialchars($ticket['UserName']); ?></p>
                                        <p><strong>Schedule ID:</strong> <?php echo htmlspecialchars($ticket['ScheduleID']); ?></p>
                                        <p><strong>Travel Date:</strong> <?php echo htmlspecialchars($ticket['TravelingDate']); ?></p>
                                        <p><strong>Starting Time:</strong> <?php echo htmlspecialchars($ticket['StartingTime']); ?></p>
                                        <p><strong>Seat Number:</strong> <?php echo htmlspecialchars($ticket['SeatNumber']); ?></p>
                                        <p><strong>Driver Name:</strong> <?php echo htmlspecialchars($ticket['DriverName']); ?></p>
                                        <p><strong>Bus Type:</strong> <?php echo htmlspecialchars($ticket['BusType']); ?></p>
                                        <p><strong>License Plate:</strong> <?php echo htmlspecialchars($ticket['LicensePlate']); ?></p>
                                        <p><strong>Bus Level:</strong> <?php echo htmlspecialchars($ticket['BusLevel']); ?></p>
                                    </div>
                                    <img src="https://avatar.iran.liara.run/username?username=<?php echo urlencode($ticket['UserName']); ?>" alt="Avatar">
                                </div>
                                <?php if ($isDriverCorrect): ?>
                                    <p class="text-green-500 text-center font-bold mt-4">Success: Driver is correct!</p>
                                <?php else: ?>
                                    <p class="text-red-500 text-center font-bold mt-4">Error: Incorrect Driver!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php
                    } else {
                        echo '<p class="text-red-500">Error: Invalid Ticket or Schedule.</p>';
                    }
                    $stmt->close();
                } else {
                    echo '<p class="text-red-500">Error: Missing required parameters.</p>';
                }

                $conn->close();
                ?>
            </main>
        </div>
    </div>
</body>