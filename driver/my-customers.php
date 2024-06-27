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

                
                <section class='w-full border rounded-lg shadow-lg'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">My Customers</h1>
                    </div>
                    <div class="container mx-auto p-8">
                    <?php
                        include("../database/connection.php");

                        $driverID = $_SESSION['driver_id']; 

                        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['schedule_id'])) {
                            $scheduleID = $_GET['schedule_id'];

                            // Fetch users who bought tickets for the selected schedule
                            $sql = "SELECT t.TicketID, u.UserName, u.UserEmail, u.UserPhone, t.SeatNumber, s.TravelingDate, s.StartingTime, b.BusType, b.LicensePlate
                                    FROM Ticket t
                                    JOIN User u ON t.UserID = u.UserID
                                    JOIN Schedule s ON t.ScheduleID = s.ScheduleID
                                    JOIN Bus b ON t.BusID = b.BusID
                                    WHERE t.ScheduleID = $scheduleID AND t.DriverID = $driverID";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">';
                                
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="bg-white p-6 rounded-lg shadow-lg">';
                                    echo '<h2 class="text-xl font-bold mb-4">User Details</h2>';
                                    echo '<p><strong>Ticket ID:</strong> ' . $row['TicketID'] . '</p>';
                                    echo '<p><strong>User Name:</strong> ' . $row['UserName'] . '</p>';
                                    echo '<p><strong>User Email:</strong> ' . $row['UserEmail'] . '</p>';
                                    echo '<p><strong>User Phone:</strong> ' . $row['UserPhone'] . '</p>';
                                    echo '<p><strong>Seat Number:</strong> ' . $row['SeatNumber'] . '</p>';
                                    echo '<p><strong>Travel Date:</strong> ' . $row['TravelingDate'] . '</p>';
                                    echo '<p><strong>Starting Time:</strong> ' . $row['StartingTime'] . '</p>';
                                    echo '<p><strong>Bus Type:</strong> ' . $row['BusType'] . '</p>';
                                    echo '<p><strong>License Plate:</strong> ' . $row['LicensePlate'] . '</p>';
                                    echo '</div>';
                                }

                                echo '</div>';
                            } else {
                                echo '<p class="text-red-500">No users found for this schedule.</p>';
                            }
                        } else {
                            // Fetch schedules for the logged-in driver
                            $sql = "SELECT ScheduleID, TravelingDate, StartingTime FROM Schedule WHERE BusID IN (SELECT BusID FROM Bus WHERE DriverID = $driverID)";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo '<form action="" method="GET" class="bg-white p-6 rounded-lg shadow-lg">';
                                echo '<div class="mb-4">';
                                echo '<label for="schedule" class="block text-gray-700 text-sm font-bold mb-2">Select Schedule:</label>';
                                echo '<select name="schedule_id" id="schedule" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                                
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['ScheduleID'] . '">' . $row['TravelingDate'] . ' - ' . $row['StartingTime'] . '</option>';
                                }

                                echo '</select>';
                                echo '</div>';
                                echo '<input type="submit" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" value="View Users">';
                                echo '</form>';
                            } else {
                                echo '<p class="text-red-500">No schedules found.</p>';
                            }
                        }

                        $conn->close();
                        ?>
                    </div>



                </section>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>








