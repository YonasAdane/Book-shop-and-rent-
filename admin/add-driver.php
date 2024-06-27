<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /NewStytem/auth/login.php');
    exit();
}
include '../database/connection.php';
$status=null;
$message="";

if(isset($_POST['AddDriver'])){
    $DriverName=$_POST['DriverName'];
    $DriverEmail=$_POST['DriverEmail'];
    $DriverPhone=$_POST['DriverPhone'];
    $DriverAddress=$_POST['DriverAddress'];
    $DriverPassword=$_POST['DriverPassword'];
    $DriverPassword=md5($DriverPassword);

    $checkEmail="SELECT * FROM driver WHERE DriverEmail='$DriverEmail'";
    $result=$conn->query($checkEmail);
    if($result->num_rows>0){
        $DriverEmail="Email Address Already Exists!";
        $status="red";
    }
    else{
        $insertQuery="INSERT INTO driver(DriverName,DriverEmail,DriverPhone,DriverAddress,DriverPassword) 
        VALUES ('$DriverName','$DriverEmail','$DriverPhone','$DriverAddress','$DriverPassword') ";
        if($conn->query($insertQuery)==TRUE){
            $message="Succesfully Registered";
            $status="green";
        }else{
            $message="Error Unable to Register";
            $status="red";

        }
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
                    <div class='p-2 border-b '>
                        <h1 class="text-3xl text-black ">Add Driver</h1>
                        <!-- <h1 class="text-3xl font-bold mt-2"></h1> -->
                        <!-- <h2 class='text-xl font-semibold' >Schedule Management</h2> -->
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
                            <form action="./add-driver.php" method="POST">
                                <div class="mb-1">
                                    <label for="DriverName" class="block text-gray-700 font-bold mb-2">Driver Name</label>
                                    <input type="text" id="DriverName" name="DriverName" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-1">
                                    <label for="DriverEmail" class="block text-gray-700 font-bold mb-2">Driver Email</label>
                                    <input type="email" id="DriverEmail" name="DriverEmail" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-1">
                                    <label for="DriverPhone" class="block text-gray-700 font-bold mb-2">Driver Phone</label>
                                    <input type="text" id="DriverPhone" name="DriverPhone" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-1">
                                    <label for="DriverAddress" class="block text-gray-700 font-bold mb-2">Driver Address</label>
                                    <input type="text" id="DriverAddress" name="DriverAddress" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="mb-1">
                                    <label for="DriverPassword" class="block text-gray-700 font-bold mb-2">Driver Password</label>
                                    <input type="password" id="DriverPassword" name="DriverPassword" class="p-1 w-full border bg-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" name="AddDriver" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded">Add Driver</button>
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

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>