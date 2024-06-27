<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
include("../database/connection.php");

// Assuming admin is already authenticated
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$message = "";

// Handle form submission for adding or editing schedules
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busID = $_POST['bus_id'];
    $scheduleID = $_POST['schedule_id'] ?? null;
    $travelingDate = $_POST['traveling_date'];
    $startingTime = $_POST['starting_time'];
    $travelStatus = $_POST['travel_status'];

    if ($scheduleID) {
        // Update existing schedule
        $sql = "UPDATE Schedule SET TravelingDate='$travelingDate', StartingTime='$startingTime', TravelStatus='$travelStatus' WHERE ScheduleID=$scheduleID";
        if ($conn->query($sql) === TRUE) {
            $message = "Schedule updated successfully.";
        } else {
            $message = "Error updating schedule: " . $conn->error;
        }
    } else {
        // Add new schedule
        $sql = "INSERT INTO Schedule (BusID, TravelingDate, StartingTime, TravelStatus) VALUES ($busID, '$travelingDate', '$startingTime', '$travelStatus')";
        if ($conn->query($sql) === TRUE) {
            $message = "Schedule added successfully.";
        } else {
            $message = "Error adding schedule: " . $conn->error;
        }
    }
}

// Handle deletion of schedules
if (isset($_GET['delete_schedule_id'])) {
    $scheduleID = $_GET['delete_schedule_id'];
    $sql = "DELETE FROM Schedule WHERE ScheduleID=$scheduleID";
    if ($conn->query($sql) === TRUE) {
        $message = "Schedule deleted successfully.";
    } else {
        $message = "Error deleting schedule: " . $conn->error;
    }
}

// Fetch schedules for a specific bus
$busID = $_GET['bus_id'] ?? null;
// $busID=11;
$schedules = [];
if ($busID) {
    $sql = "SELECT * FROM Schedule WHERE BusID=$busID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
    }
}

// Fetch bus details for display purposes
$busQuery = "SELECT * FROM Bus WHERE BusID=$busID";
$busResult = $conn->query($busQuery);
$busData = $busResult->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <?php include("./partials/imports.php")?>

</head>
<body x-data="{thisPath:window.location.pathname , isOpen: false}" class="bg-gray-100 font-family-karla flex">

<?php include("./partials/aside.php")?>
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <?php include("./partials/header.php")?>
        <!-- Mobile Header & Nav -->
        <?php include("./partials/mobile-header.php")?>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow ">
                <!-- Content  -->
                
                <section class='w-full border rounded-lg shadow-lg'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">Manage Schedules for Bus: <?php echo $busData['BusType']; ?> (License Plate: <?php echo $busData['LicensePlate']; ?>)</h1>
                    </div>
                    <!-- Main Content -->
                    

                    <div class="container mx-auto p-8">
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-2xl font-bold mb-4">Add / Edit Schedule</h2>
                            <form action="" method="POST">
                                <input type="hidden" name="bus_id" value="<?php echo $busID; ?>">
                                <input type="hidden" name="schedule_id" id="schedule_id" value="">
                                <div class="mb-4">
                                    <label for="traveling_date" class="block text-gray-700">Traveling Date:</label>
                                    <input type="date" id="traveling_date" name="traveling_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="starting_time" class="block text-gray-700">Starting Time:</label>
                                    <input type="time" id="starting_time" name="starting_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="travel_status" class="block text-gray-700">Travel Status:</label>
                                    <select id="travel_status" name="travel_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="pending">Pending</option>
                                        <option value="done">Done</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                                <input type="submit" value="Save Schedule" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">
                            </form>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-2xl font-bold mb-4">Existing Schedules</h2>
                            <?php if (count($schedules) > 0): ?>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b">Schedule ID</th>
                                                <th class="py-2 px-4 border-b">Traveling Date</th>
                                                <th class="py-2 px-4 border-b">Starting Time</th>
                                                <th class="py-2 px-4 border-b">Travel Status</th>
                                                <th class="py-2 px-4 border-b">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($schedules as $schedule): ?>
                                                <tr>
                                                    <td class="py-2 px-4 border-b"><?php echo $schedule['ScheduleID']; ?></td>
                                                    <td class="py-2 px-4 border-b"><?php echo $schedule['TravelingDate']; ?></td>
                                                    <td class="py-2 px-4 border-b"><?php echo $schedule['StartingTime']; ?></td>
                                                    <td class="py-2 px-4 border-b"><?php echo $schedule['TravelStatus']; ?></td>
                                                    <td class="py-2 px-4 border-b">
                                                        <button onclick="editSchedule(<?php echo htmlspecialchars(json_encode($schedule)); ?>)" class="px-4 py-1 text-white font-light tracking-wider bg-yellow-400 rounded">Edit</button>
                                                        <a href="?bus_id=<?php echo $busID; ?>&delete_schedule_id=<?php echo $schedule['ScheduleID']; ?>" class="px-4 py-1 text-white font-light tracking-wider bg-red-400 rounded">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-red-500">No schedules found for this bus.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </section>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
        function editSchedule(schedule) {
        document.getElementById('schedule_id').value = schedule.ScheduleID;
        document.getElementById('traveling_date').value = schedule.TravelingDate;
        document.getElementById('starting_time').value = schedule.StartingTime;
        document.getElementById('travel_status').value = schedule.TravelStatus;
    }
    </script>
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>