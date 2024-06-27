<!-- ,create, update -->
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

// SQL query to fetch route information
$sql = "SELECT RouteID, StartLocation, EndLocation, Distance FROM Route";
$result = $conn->query($sql);

// Check if there are any results
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
                        <h1 class="text-3xl text-black ">All Routes</h1>
                    </div>
                    <!-- Main Content -->
                    <main class="container mx-auto mt-4">                        
                        <div class="bg-white p-6 rounded shadow-lg">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Start Location</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">End Location</th>
                                        <th class=" text-left py-3 px-4 uppercase font-semibold text-sm">Distance</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                <?php if (!empty($routes)): ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <?php foreach ($routes as $route): ?>
                                        <tr class="bg-gray-50 group hover:bg-slate-200" id="<?php echo $route['RouteID']; ?>">
                                            <td class="text-left py-3 px-4"><?php echo $route['StartLocation']; ?></td>
                                            <td class="text-left py-3 px-4"><?php echo $route['EndLocation']; ?></td>
                                            <td class="text-left py-3 px-4"><?php echo $route['Distance']; ?> km</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-center">No routes found.</p>
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


