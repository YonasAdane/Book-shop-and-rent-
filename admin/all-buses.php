<?php
// Include the database connection
include("../database/connection.php");
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch bus information
$sql = "
SELECT 
    Bus.BusID,
    Bus.BusLevel,
    Bus.BusType,
    Bus.LicensePlate,
    Bus.CurrentCity,
    Driver.DriverName,
    Route.StartLocation,
    Route.EndLocation,
    BusCategory.BusName,
    BusCategory.BusSeatNumbers,
    BusCategory.BusCategory
FROM 
    Bus
JOIN 
    Driver ON Bus.DriverID = Driver.DriverID
JOIN 
    Route ON Bus.RouteID = Route.RouteID
JOIN 
    BusCategory ON Bus.BusCategoryID = BusCategory.BusCategoryID";

$result = $conn->query($sql);

// Check if there are any results
$buses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buses[] = $row;
    }
} else {
    echo "No buses found.";
}

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
                    <main class="container mx-auto mt-4">                        
                        <div class="bg-white p-6 rounded shadow-lg">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">BusLevel</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">BusType</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">LicensePlate</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">CurrentCity</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">DriverName</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Location</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">SeatNumbers</th>
                                        

                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                
                                        <?php if (!empty($buses)): ?>
                                                <?php foreach ($buses as $bus): ?> 
                                    
                                    
                                        <tr class="bg-gray-50 group hover:bg-slate-200" id="<?php echo $row['BusCategoryID']?>">
                                            <td class="text-left py-3 px-4"><a href="<?php echo "/LetsGO/admin/bus-schedule.php?bus_id=".$bus['BusID'];?>"><?php echo $bus['BusLevel']; ?></a></td>
                                            <td class="text-left py-3 px-4"><?php echo $bus['BusType']; ?></td>
                                            <td class="text-left py-3 px-4"><?php echo $bus['LicensePlate']; ?></td>
                                            <td class="text-left py-3 px-4"><?php echo $bus['CurrentCity']; ?></td>
                                            <td class="text-left py-3 px-42"><?php echo $bus['DriverName']; ?></td>
                                            <td class="text-left py-3 px-42"><?php echo $bus['StartLocation']."-". $bus['EndLocation']; ?></td>
                                            <td class="text-left py-3 px-42"><?php echo $bus['BusSeatNumbers'] ?></td>
                                        </tr>
                                    
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-center">No buses found.</p>
                                    <?php endif; ?>
                                </tbody>
                            </table>


                        </div>
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

