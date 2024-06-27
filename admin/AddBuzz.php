<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
include '../database/connection.php';
$status = null;
$message = "";

if (isset($_POST['addBus'])) {
    $bus_level = $_POST['bus_level'];
    $bus_type = $_POST['bus_type'];
    $license_plate = $_POST['license_plate'];
    $current_city = $_POST['current_city'];
    $driver_id = $_POST['driver_id'];
    $seat_numbers = $_POST['seat_numbers'];
    $route_id = $_POST['route_id'];
    $bus_category_id = $_POST['bus_type']; 

    $sql = "INSERT INTO Bus (BusLevel, BusType, LicensePlate, CurrentCity, DriverID, SeatNumbers, RouteID, BusCategoryID) 
            VALUES ('$bus_level', '$bus_type', '$license_plate', '$current_city', $driver_id, $seat_numbers, $route_id, $bus_category_id)";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Successfully Added";
        $status = "green";
    } else {
        $message = "Error: " . $conn->error;
        $status = "red";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <?php include("./partials/imports.php")?>

</head>
<body x-data="{thisPath:window.location.pathname, isOpen: false}" class="bg-gray-100 font-family-karla flex">
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
                        <h1 class="text-3xl text-black ">Add Bus</h1>
                        <!-- <h1 class="text-3xl font-bold mt-2"></h1> -->
                        <!-- <h2 class='text-xl font-semibold' >Schedule Management</h2> -->
                    </div>
                    <?php if(!$status==null){?>
                    <div class="border-2 rounded-lg mx-auto border-<?php echo $status?>-500 w-3/5 text-center p-3 bg-<?php echo $status?>-300  top-0 ">
                        <h2 class=""><?php echo $message?></h2>
                    </div>
                    <?php }?>
                    <!-- Main Content -->
                    <main class="container mx-auto p-4">
                        <!-- Add Driver Form -->
                        <div class="bg-white p-8 rounded shadow-xl border max-w-lg mx-auto">
                            <form action="addBuzz.php" class="grid grid-cols-2 gap-4"  method="post">
                                <label for="bus_type">Bus category:</label>
                                <!-- <input type="text" id="bus_type" name="bus_type" required><br><br> -->
                                <select id="bus_type" name="bus_type" required>

                                <?php  $sql = "SELECT BusCategoryID, BusName FROM BusCategory";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["BusCategoryID"] . "'>" . $row["BusName"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No available bus categories</option>";
                                    }

                                ?>
                                </select>
                                <label for="bus_level">Bus Level:</label>
                                <input class="border focus:outline-none" readonly type="text" id="bus_level" name="bus_level" required>

                                <label for="seat_numbers">Seat Numbers:</label>
                                <input readonly type="number" id="seat_numbers" name="seat_numbers" class="border focus:outline-none" required>

                                <label for="license_plate">License Plate:</label>
                                <input class="border" type="text" id="license_plate" name="license_plate" required>

                                <label for="current_city">Current City:</label>
                                <input class="border" type="text" id="current_city" name="current_city" required>

                                <label for="driver_id">Select Driver:</label>
                                <select id="driver_id" name="driver_id" required>
                                    <?php $sql = "SELECT d.DriverID, d.DriverName FROM Driver d
                                        LEFT JOIN Bus b ON d.DriverID = b.DriverID
                                        WHERE b.DriverID IS NULL;";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["DriverID"] . "'>" . $row["DriverName"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No available drivers</option>";
                                    }
                                    ?>
                                </select>
                                
                                <label for="route_id">Select Route:</label>
                                <select id="route_id" name="route_id" required>
                                <?php
                                $sql = "SELECT RouteID, CONCAT(StartLocation, ' - ', EndLocation) AS Route FROM Route";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["RouteID"] . "'>" . $row["Route"] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No available routes</option>";
                                }
                                $conn->close();
                                ?>
                                </select>
                                <br>
                                </br>
                                <input class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" value="Add" type="submit" name="addBus">
                            </form>
                        </div>
                    </main>
                </section>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>
    <script src="./service/add-buss.js"></script>
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>