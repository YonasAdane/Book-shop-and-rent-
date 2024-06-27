<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
include '../database/connection.php';
$status = null;
$message = "";

if (isset($_POST['AddBusCategory'])) {
    $BusName = $_POST['BusName'];
    $BusSeatNumbers = $_POST['BusSeatNumbers'];
    $BusPicture = $_POST['BusPicture'];
    $BusLevel = $_POST['BusLevel'];
    $priceFactor = $_POST['priceFactor'];

    // Check if BusName already exists
    $checkBusCategory = $conn->prepare("SELECT * FROM BusCategory WHERE BusName = ?");
    $checkBusCategory->bind_param("s", $BusName);
    $checkBusCategory->execute();
    $result = $checkBusCategory->get_result();

    if ($result->num_rows > 0) {
        $message = "Bus Name Already Exists!";
        $status = "red";
    } else {
        // Insert new BusCategory
        $insertQuery = $conn->prepare("INSERT INTO BusCategory (BusName, BusSeatNumbers, BusLevel, BusPicture, priceFactor) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("sissd", $BusName, $BusSeatNumbers, $BusLevel, $BusPicture, $priceFactor);
        
        if ($insertQuery->execute()) {
            $message = "Successfully Added";
            $status = "green";
        } else {
            $message = "Error Unable to Add";
            $status = "red";
        }

        $insertQuery->close();
    }

    $checkBusCategory->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./partials/imports.php")?>
    <title>Admin page</title>
</head>
<body x-data="{thisPath:window.location.pathname, isOpen: false}" class="bg-gray-100 font-family-karla flex">
    <?php include("./partials/aside.php")?>
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <?php include("./partials/header.php")?>
        <!-- Mobile Header & Nav -->
        <?php include("./partials/mobile-header.php")?>
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full">
                <!-- Content  -->
                <section class='w-full border rounded-lg shadow-lg'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">Add Bus Type</h1>
                    </div>
                    <?php if(!$status==null){?>
                    <div class="border-2 rounded-lg mx-auto border-<?php echo $status?>-500 w-3/5 text-center p-3 bg-<?php echo $status?>-300  top-0 ">
                        <h2 class=""><?php echo $message?></h2>
                    </div>
                    <?php }?>
                    <!-- Main Content -->
                    <main class="container mx-auto p-4">
                        <div class="bg-white p-4 rounded shadow-xl border max-w-lg mx-auto">
                            <form action="./add-buzzType.php" method="POST">
                                <div class="mb-4">
                                    <label for="BusName" class="block text-gray-700 font-bold mb-2">Bus Name</label>
                                    <input type="text" id="BusName" name="BusName" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="BusSeatNumbers" class="block text-gray-700 font-bold mb-2">Bus Seat Numbers</label>
                                    <input type="number" id="BusSeatNumbers" name="BusSeatNumbers" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="BusLevel" class="block text-gray-700 font-bold mb-2">Bus Level</label>
                                    <input type="text" id="BusLevel" name="BusLevel" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="BusPicture" class="block text-gray-700 font-bold mb-2">Bus Picture URL</label>
                                    <input type="text" id="BusPicture" name="BusPicture" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="priceFactor" class="block text-gray-700 font-bold mb-2">Price Factor</label>
                                    <input type="number" step="0.00001" id="priceFactor" name="priceFactor" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" name="AddBusCategory" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">Add Bus Categoury</button>
                                </div>
                            </form>
                        </div>
                    </main>
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