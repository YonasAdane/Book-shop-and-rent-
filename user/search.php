<?php 
session_start();
include("../database/connection.php");
echo "<script>
var dat=new Date();
console.log('succcess',dat);
</script>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <header class="text-gray-800 bg-white shadow-xl">
        <nav class="container mx-auto p-4 md:flex justify-between items-center hidden">
            <div class="text-xl font-semibold">LetsGO Ticketing System</div>
            <ul class="flex space-x-6">
                <li><a href="/LetsGO/user/index.php" class="hover:text-gray-300">Home</a></li>
                <li><a href="/LetsGO/user/search.php" class="hover:text-gray-300">Book Tickets</a></li>
                <li><a href="/LetsGO/user/profile.php" class="hover:text-gray-300">Profile</a></li>
                <li><a href="#" class="hover:text-gray-300">Support</a></li>
                <li ><a href="/LetsGO/auth/login.php" class="p-2 bg-blue-600 text-white rounded-lg hover:text-gray-300">Login</a></li>
            </ul>
        </nav>
        <section class="w-full h-[80vh] md:p-8 bg-cover bg-center" style="background-image: url('../sandro-antonietti-JHMlN41jM0M-unsplash.jpg');">
            <form action="./search.php" method="POST" class="bg-gray-50/70 w-full flex flex-col justify-center gap-4 relative rounded-xl p-8 pb-10 mt-0 sm:mt-10">
                <h1 class="text-center text-3xl font-body text-white font-semibold">PICK A BUS</h1>
                <div class="w-full flex justify-between bg-slate-100 border rounded-xl items-center">
                    <label for="from" class="bg-white rounded-tl-xl  rounded-bl-xl border flex flex-grow flex-col p-4">
                        <span class="text-gray-500">From</span>
                        <input class="text-3xl placeholder:text-black w-full" id="from" placeholder="Addis Ababa" placeholder="Addis Ababa" name="StartLocation" type="text">
                        <p class="hidden sm:block">Ethiopia</p>
                    </label>
                    <label for="to" class="bg-white rounded-tr-xl rounded-br-xl border cursor:pointer flex-grow flex flex-col p-4">
                        <span class="text-gray-500">To</span>
                        <input class="text-3xl placeholder:text-black w-full" id="to" value="Adama" placeholder="Addis Ababa" type="text">
                        <p class="hidden sm:block">Ethiopia</p>
                    </label>
                    <!-- <label for="date" class="bg-white rounded-tr-xl rounded-br-xl border relative block p-2 py-6">
                        <span class="text-gray-500 text-sm sm:text-[1rem]">Travel <span class="hidden sm:inline">Date</span></span>
                        <input class="sm:mt-1 sm:p-2 block w-full border-gray-300 rounded-md" id="date" type="date" >
                    </label> -->
                </div>
                <input type="submit" name="SearchBus" value="SEARCH " class="bg-green-400 font-bold from-blue-500 px-8 p-2 w-fit block rounded-3xl absolute -bottom-1 right-1/2 translate-x-1/2 text-xl">
            </form>
        </section>
            <div class=" bg-white md:w-4/5 mx-auto flex flex-col justify-center gap-4 relative -mt-0 rounded-xl sm:p-8  pb-10 ">
                <h1 class="ml-8 text-3xl font-extrabold">Buses</h1>
                <div>
                    <div class="grid md:grid-cols-2 gap-5  p-2 relative">
                        <?php 
                            $sql="SELECT * FROM BDCRouteView;";
                        if(isset($_POST['SearchBus'])){
                                $Slocation=$_POST["StartLocation"];
                                $sql = "SELECT * FROM BDCRouteView WHERE StartLocation LIKE '%$Slocation%' OR EndLocation LIKE '%$Slocation%'";                               
                        }
                            $run=mysqli_query($conn,$sql) or die("Can't Execute Query...");
                        while ($row=mysqli_fetch_assoc($run)) { ?>
                            <div class='bg-white shadow-md rounded-lg   border flex '> 
                                <img class="border rounded-md object-cover aspect-square border-slate-500" src="<?php echo  $row['BusPicture']??"../assets/default-cartoon-bus.jpg"; ?>" width="100px" height="" alt=""> 
                                <div class="p-4">
                                    <p class='text-gray-700 text-2xl'><strong>Bus Name:</strong> <a href="/LetsGO/user/BookBus.php?bus_id=<?php echo $row['BusID']; ?>"><?php echo $row['BusName']; ?></a></p>
                                    <div class="w-full flex justify-start gap-4">
                                        <img src="https://avatar.iran.liara.run/public/<?php echo rand(1, 50); ?>" width="50px" height="50px" class="rounded-full w-[50px] hidden sm:block" alt="boy">
                                        <div>
                                            <h3 class='text-xl font-semibold'><?php  $row['BusName']; ?></h3>
                                            <p class='text-gray-700'><strong>Driver: </strong> <?php echo $row['DriverName']; ?></p>
                                            <div class='text-gray-700'><span><i class="inline" width="1rem" data-lucide="map-pin"></i></span> <?php echo $row['StartLocation']; ?> -- <?php echo $row['EndLocation']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php    
                            }
                        ?> 
                        </div> 
                    </div>
                </div>
            </div>
        
    </header>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>