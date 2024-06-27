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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        // Create a new route
        $startLocation = $_POST['start_location'];
        $endLocation = $_POST['end_location'];
        $distance = $_POST['distance'];

        $sql = "INSERT INTO Route (StartLocation, EndLocation, Distance) VALUES ('$startLocation', '$endLocation', $distance)";
        if ($conn->query($sql) === TRUE) {
            echo "New route created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Update an existing route
        $routeID = $_POST['route_id'];
        $startLocation = $_POST['start_location'];
        $endLocation = $_POST['end_location'];
        $distance = $_POST['distance'];

        $sql = "UPDATE Route SET StartLocation='$startLocation', EndLocation='$endLocation', Distance=$distance WHERE RouteID=$routeID";
        if ($conn->query($sql) === TRUE) {
            echo "Route updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Delete an existing route
        $routeID = $_POST['route_id'];

        $sql = "DELETE FROM Route WHERE RouteID=$routeID";
        if ($conn->query($sql) === TRUE) {
            echo "Route deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch all routes for display
$sql = "SELECT RouteID, StartLocation, EndLocation, Distance FROM Route";
$result = $conn->query($sql);

$routes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $routes[] = $row;
    }
} else {
    echo "No routes found.";
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
                
                <section class='w-full border rounded-lg shadow-lg'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">Route Management</h1>
                    </div>
                    

                    <div class="container mx-auto p-8">

                        <!-- Create Route Form -->
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-xl font-bold mb-4">Create New Route</h2>
                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label for="start_location" class="block text-gray-700">Start Location</label>
                                    <input type="text" name="start_location" id="start_location" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_location" class="block text-gray-700">End Location</label>
                                    <input type="text" name="end_location" id="end_location" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="distance" class="block text-gray-700">Distance (km)</label>
                                    <input type="number" name="distance" id="distance" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <button type="submit" name="create" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">Create Route</button>
                            </form>
                        </div>

                        <!-- Update Route Form -->
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-xl font-bold mb-4">Update Route</h2>
                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label for="route_id" class="block text-gray-700">Route ID</label>
                                    <input type="number" name="route_id" id="route_id" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="start_location" class="block text-gray-700">Start Location</label>
                                    <input type="text" name="start_location" id="start_location" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_location" class="block text-gray-700">End Location</label>
                                    <input type="text" name="end_location" id="end_location" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="distance" class="block text-gray-700">Distance (km)</label>
                                    <input type="number" name="distance" id="distance" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                            <button type="submit" name="update" class="bg-yellow-500 px-4 py-1 text-white font-light tracking-wider rounded">Update Route</button>
                            </form>
                        </div>

                        <!-- Delete Route Form -->
                        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                            <h2 class="text-xl font-bold mb-4">Delete Route</h2>
                            <form method="POST" action="">
                                <div class="mb-4">
                                    <label for="route_id" class="block text-gray-700">Route ID</label>
                                    <input type="number" name="route_id" id="route_id" class="border border-gray-300 rounded p-2 w-full" required>
                                </div>
                                <button type="submit" name="delete" class="bg-red-500 px-4 py-1 text-white font-light tracking-wider rounded">Delete Route</button>
                            </form>
                        </div>

                        <!-- Display All Routes -->
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-xl font-bold mb-4">All Routes</h2>
                            <?php if (!empty($routes)): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php foreach ($routes as $route): ?>
                                        <div class="bg-white p-6 rounded-lg shadow-lg">
                                            <h2 class="text-xl font-bold mb-2">Route ID: <?php echo $route['RouteID']; ?></h2>
                                            <p><strong>Start Location:</strong> <?php echo $route['StartLocation']; ?></p>
                                            <p><strong>End Location:</strong> <?php echo $route['EndLocation']; ?></p>
                                            <p><strong>Distance:</strong> <?php echo $route['Distance']; ?> km</p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center">No routes found.</p>
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







