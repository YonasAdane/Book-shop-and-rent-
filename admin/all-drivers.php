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

// $run=0;
if (isset($_POST['Search'])) {
	$by=$_POST['by'];
	$value=$_POST['value'];
    $search=TRUE;
    $sql = "SELECT * FROM DriverBusInfo WHERE " . $by . " LIKE '%$value%'";
}else{
    $sql = "SELECT * FROM DriverBusInfo";

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
                
                <section class='w-full border rounded-lg shadow-lg px-2'>
                    <div class='p-4 border-b '>
                        <h1 class="text-3xl text-black ">All Drivers</h1>
                    </div>
                    <?php if(!$status==null){?>
                    <div class="border-2 rounded-lg mx-auto border-<?php echo $status?>-500 w-3/5 text-center p-3 bg-<?php echo $status?>-300  top-0 ">
                        <h2 class=""><?php echo $message?></h2>
                    </div>
                    <?php }?>
                    <div class="flex flex-end w-full pr-8">
                            <form action="./all-drivers.php" method="POST" class="w-fit border-black block  ml-auto">
                                <input type="text" name="value" placeholder="Search by name or email" class="ml-4 p-1 border-gray-300 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-300">
                                <select name="by" class="p-2">
                                    <option value="DriverName">Driver Name</option>
                                    <option value="DriverEmail">Driver Email</option>
                                    <option value="DriverPhone">Driver Phone</option>
                                    <option value="DriverAddress">Driver Address</option>
                                </select>
                                <input type="submit" value="Search" name="Search" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" />
                            </form>
                        </div>
                    <!-- Main Content -->
                    <table class="min-w-full bg-white mt-2 overflow-x-auto">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class=" text-left py-3 px-2 uppercase font-semibold text-sm">Driver Name</th>
                                    <th class=" text-left py-3 px-2 uppercase font-semibold text-sm">Email</th>
                                    <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Address</th>
                                    <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Phone</th>
                                    <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Licence Plate</th>
                                    <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Bus Type</th>
                                    <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Bus Level</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php 
                                    $run=mysqli_query($conn,$sql) or die("Can't Execute Query...");
                                    while ($row=mysqli_fetch_assoc($run)) { 
                                    ?>
                                    <tr>
                                        <td class="text-left py-3 px-2"><a class="hover:text-blue-500" href="/LetsGO/admin/driver-detail.php?driver= <?php echo $row['DriverID']?> "><?php echo $row['DriverName']?></a></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["DriverEmail"]?></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["DriverAddress"]?></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["DriverPhone"]?></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["LicensePlate"]?></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["BusType"]?></td>
                                        <td class=" text-left py-3 px-2"><?php echo  $row["BusLevel"]?></td>
                                    </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table>
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