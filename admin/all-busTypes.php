<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /LetsGO/auth/login.php');
    exit();
}
include '../database/connection.php';

$status=null;
$search=FALSE;
$message="";
$sql = "SELECT * FROM BusCategory ";
$run=mysqli_query($conn,$sql) or die("Can't Execute Query...");
$sqlu="";
if (isset($_POST['UpdateBusCategory'])) {
    $busCategoryID = intval($_POST['BusCategoryID']);
    $busName = $conn->real_escape_string($_POST['BusName']);
    $busSeatNumbers = intval($_POST['BusSeatNumbers']);
    $priceFactor = $conn->real_escape_string($_POST['priceFactor']);
    $busLevel = $conn->real_escape_string($_POST['BusLevel']);
    $sqlu = "UPDATE BusCategory SET BusName='$busName', BusSeatNumbers=$busSeatNumbers, priceFactor='$priceFactor', BusLevel='$busLevel' WHERE BusCategoryID=$busCategoryID";
    if ($conn->query($sqlu) === TRUE) {
        echo "<p class='text-green-500 text-center'>Bus category updated successfully</p>";
    } else {
        echo "<p class='text-red-500 text-center'>Error updating bus category: " . $conn->error . "</p>";
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
<body x-data="{thisPath:window.location.pathname ,isOpen: false}" class="bg-gray-100 font-family-karla flex">

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
                        <h1 class="text-3xl text-black ">All Bus Types</h1>
                    </div>
                    <?php if(!$status==null){?>
                    <div class="border-2 rounded-lg mx-auto border-<?php echo $status?>-500 w-3/5 text-center p-3 bg-<?php echo $status?>-300  top-0 ">
                        <h2 class=""><?php echo $message?></h2>
                    </div>
                    <?php }?>
                         
                    <!-- Main Content -->
                    <main class="container mx-auto mt-4">
                        <!-- Popover -->
                        <!-- <div> -->
                            <nav id="edit"  class="hidden shadow-2xl fixed top-1/2 right-1/2 min-w-56 translate-x-1/2 -translate-y-1/2 w-fit bg-white p-8 rounded  border   backdrop:bg-black/90" popover >
                                <h1 class="font-semibold text-center text-2xl">Edit Bus Types</h1>
                                <form id="edit-form" action="./all-busTypes.php" method="POST">
                                    <input type="hidden" id="BusCategoryID" name="BusCategoryID">
                                    <div class="mb-1">
                                        <label for="BusName" class="block text-gray-700 font-bold mb-2">Bus Name</label>
                                        <input type="text" id="BusName" name="BusName" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div class="mb-1">
                                        <label for="BusSeatNumbers" class="block text-gray-700 font-bold mb-2">Bus Seat Numbers</label>
                                        <input type="number" id="BusSeatNumbers" name="BusSeatNumbers" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div class="mb-1">
                                        <label for="BusPicture" class="block text-gray-700 font-bold mb-2">Bus Picture</label>
                                        <input type="text" id="BusPicture" name="BusPicture" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div class="mb-1">
                                        <label for="BusLevel" class="block text-gray-700 font-bold mb-2">Bus Level</label>
                                        <input type="text" id="BusLevel" name="BusLevel" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div class="mb-1">
                                        <label for="priceFactor" class="block text-gray-700 font-bold mb-2">Price per Km</label>
                                        <input type="text" id="priceFactor" name="priceFactor" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div class="flex gap-1 justify-center">
                                        <button type="submit" name="UpdateBusCategory" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">Add Bus Categoury</button>
                                    </div>
                                </form>
                                <button class="bg-red-600 rounded-tr px-2 absolute top-0 right-0 " onclick="closePopover()"><i class="text-white fa-solid fa-xmark"></i></button>
                            </nav>
                        <!-- </div> -->
                        <div class="bg-white p-6 rounded shadow-lg">
                            
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Bus Name</th>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Bus Seat Numbers</th>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Bus Picture</th>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Price/Km</th>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Bus Level</th>
                                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>

                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                <?php 
                                        while ($row=mysqli_fetch_assoc($run)) { 
                                    ?>
                                    <tr class="bg-gray-50 group hover:bg-slate-200" id="<?php echo $row['BusCategoryID']?>">
                                        <td class="text-left py-3 px-4"><?php echo $row['BusName']?></td>
                                        <td class="text-left py-3 px-42"><?php echo $row['BusSeatNumbers'] ?></td>
                                        <td class="text-left py-3 px-42"><img class="h-8" src="<?php echo $row['BusPicture']??"../assets/default-cartoon-bus.jpg"; ?>" height="7px" alt=""></td>
                                        <td class="text-left py-3 px-42"><?php echo $row['priceFactor'] ?></td>
                                        <td class="text-left py-3 px-42"><?php echo $row['BusLevel'] ?></td>
                                        <td class="text-left py-3 px-42"><button onclick="busTypeEditor(this)" class="bg-red-500 rounded border-7 p-0.5 " ><i   class="text-white px-1 fa-regular fa-pen-to-square"></i></button></td>
                                    </tr>

                                        <?php }?>
                                </tbody>
                            </table>

                        </div>
                    </main>
                </section>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
            </footer>
        </div>
        
    </div>
    <!-- <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
    </script> -->
    <script src="./BusTypeEditor.js"></script>
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>