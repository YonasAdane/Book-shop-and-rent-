<?php
session_start();
if (!isset($_SESSION['driver_id'])) {
    header("Location: /LetsGO/auth/login.php");
    exit();
}

include("../database/connection.php");

$driver_id = $_SESSION['driver_id'];
// $driver_id = 1;

// Fetch driver information
$sql = "SELECT * FROM Driver WHERE DriverID = $driver_id";
$driver_result = $conn->query($sql);
$driver = $driver_result->fetch_assoc();

// Fetch assigned buses
$sql = "SELECT * FROM Bus WHERE DriverID = $driver_id";
$buses_result = $conn->query($sql);

// Fetch schedule
$sql = "SELECT s.*, r.StartLocation, r.EndLocation FROM Schedule s
        JOIN Bus b ON s.BusID = b.BusID
        JOIN Route r ON b.RouteID = r.RouteID
        WHERE b.DriverID = $driver_id";
$schedule_result = $conn->query($sql);

$conn->close();
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
                        <h1 class="text-3xl text-black ">Driver Dashboard</h1>
                    </div>
                    <div class="container mx-auto p-8">
                    
                    <!-- Personal Information -->
                    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
                            <p><strong>Name:</strong> <?php echo $driver['DriverName']; ?></p>
                            <p><strong>Email:</strong> <?php echo $driver['DriverEmail']; ?></p>
                            <p><strong>Phone:</strong> <?php echo $driver['DriverPhone']; ?></p>
                            <p><strong>Address:</strong> <?php echo $driver['DriverAddress']; ?></p>
                            <!-- Option to update personal information could be added here -->
                        </div>

                        <!-- Assigned Buses -->
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-2xl font-bold mb-4">Assigned Buses</h2>
                            <?php if ($buses_result->num_rows > 0): ?>
                                <ul>
                                    <?php while ($bus = $buses_result->fetch_assoc()): ?>
                                        <li class="mb-2">
                                            <strong>Bus ID:</strong> <?php echo $bus['BusID']; ?><br>
                                            <strong>Type:</strong> <?php echo $bus['BusType']; ?><br>
                                            <strong>License Plate:</strong> <?php echo $bus['LicensePlate']; ?><br>
                                            <strong>Current City:</strong> <?php echo $bus['CurrentCity']; ?>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p>No buses assigned.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Schedule -->
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-2xl font-bold mb-4">Schedule</h2>
                            <?php if ($schedule_result->num_rows > 0): ?>
                                <ul>
                                    <?php while ($schedule = $schedule_result->fetch_assoc()): ?>
                                        <li class="mb-2 border-2 p-4 rounded-md">
                                            <strong>Date:</strong> <?php echo $schedule['TravelingDate']; ?><br>
                                            <strong>Start Time:</strong> <?php echo $schedule['StartingTime']; ?><br>
                                            <strong>Start Location:</strong> <?php echo $schedule['StartLocation']; ?><br>
                                            <strong>End Location:</strong> <?php echo $schedule['EndLocation']; ?><br>
                                            <strong>Status:</strong> <?php echo $schedule['TravelStatus']; ?>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p>No schedule available.</p>
                            <?php endif; ?>
                        </div>
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








