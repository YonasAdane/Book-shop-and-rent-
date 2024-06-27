<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
include '../../database/connection.php';

$status = null;
$message = "";
if(isset($_POST['DeleteDriver'])){
    $condition1 = TRUE;
    $condition2 = TRUE;
    $condition3 = TRUE;
    $DriverID = $_POST['DriverID'];
    $sqlUpdateBus = "UPDATE Bus SET DriverID = NULL WHERE DriverID = $DriverID";
    if ($conn->query($sqlUpdateBus) !== TRUE) {
        $condition1 = FALSE;
        throw new Exception("Error updating buses: " . $conn->error);
    }
    $sqlUpdateBus = "UPDATE ticket SET DriverID = NULL WHERE DriverID = $DriverID";
    if ($conn->query($sqlUpdateBus) !== TRUE) {
        $condition2 = FALSE;
        throw new Exception("Error updating buses: " . $conn->error);
    }
    $sqlDeleteDriver = "DELETE FROM Driver WHERE DriverID = $DriverID";
    if ($conn->query($sqlDeleteDriver) !== TRUE) {
        $condition3 = FALSE;
        throw new Exception("Error deleting driver: " . $conn->error);
    }
    if($condition1 && $condition2 && $condition3){
        header("Location: /LetsGO/admin/all-drivers.php");
        exit();
    }
}

if (isset($_GET['driver'])) {
    $DriverID = $_GET['driver'];
    $sql = "SELECT * FROM driverbusinfo WHERE DriverID='$DriverID'";
    $run = mysqli_query($conn, $sql) or die("Can't Execute Query...");

    if ($run->num_rows == 0) { 
        header("Location: /LetsGO/admin/admin-drivers.php");
        exit(); 
    }
} else {
    header("Location: /LetsGO/admin/admin-drivers.php");
    exit(); 
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
                    <div class='p-2 border-b '>
                    </div>
                    <?php if(!$status==null){?>
                    <div class="border-2 rounded-lg mx-auto border-<?php echo $status?>-500 w-3/5 text-center p-3 bg-<?php echo $status?>-300  top-0 ">
                        <h2 class=""><?php echo $message?></h2>
                    </div>
                    <?php }?>
                    <!-- Main Content -->
                    <main class="container mx-auto p-2">
                        <!-- Add Driver Form -->
                        <div class="bg-white p-8 rounded shadow-xl border max-w-lg mx-auto">
                            <div class="bg-white shadow rounded-lg p-6">
                                <h2 class="text-2xl font-semibold mb-4">Driver Details</h2>
                                <?php while ($row = mysqli_fetch_assoc($run)) { ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Driver Name</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['DriverName']); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['DriverEmail']); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['DriverAddress']); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['DriverPhone']); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">License Number</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['LicensePlate']??"doesn't have a bus"); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Bus Type</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['BusType']??"doesn't have a bus"); ?></p>
                                    </div>
                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Bus Level</label>
                                        <p class="mt-1 text-gray-900 font-semibold text-xl"><?php echo htmlspecialchars($row['BusLevel']??"doesn't have a bus"); ?></p>
                                    </div>
                                </div>
                                <?php } ?>
                                <form action="./driver-detail.php" method="POST" class="mt-6">
                                    <input type="hidden" name="DriverID" value="<?php echo htmlspecialchars($DriverID); ?>">
                                    <!-- <button class=" hover:bg-blue-700 px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">Edit Details</button> -->
                                    <button class="bg-red-600 hover:bg-red-700 px-4 py-1 text-white font-light tracking-wider rounded" name="DeleteDriver">Delete Driver</button>
                                </form>
                            </div>
                        </div>
                    </main>
                </section>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
    </script>
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>