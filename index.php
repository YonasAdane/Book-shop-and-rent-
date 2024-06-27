<?php
session_start();
$loggedin="false";
if (isset($_SESSION['user_id'])) {
    $loggedin="true";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script type="module" src="dist/index.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>


    <title>LetsGO Ticketing System</title>
</head>

<body x-data="{loggedin:<?php echo $loggedin;?>,isOpen:false}" class="bg-gray-100 text-gray-900">
    <!-- Dropdown Nav -->
    <div  class="sm:hidden sticky top-0 z-5 flex w-full bg-blue-500 justify-center min-h-20">
        <h1 href="#home" class="z-0 text-white px-3 font-bold py-4 hover:text-black  ">LetsGO Ticketing System</h1>
        <ul  id="smyLinks" :class="isOpen ? 'flex' :'hidden'" class=" absolute  flex-col justify-center w-full   border-red-500 bg-green-400" >
            <li class="w-full hover:bg-slate-500 bg-purple-500 p-3"><a href="/LetsGO/index.php" class="hover:text-gray-300">Home</a></li>
            <li class="w-full hover:bg-slate-500 bg-purple-500 p-3"><a href="/LetsGO/user/search.php" class="hover:text-gray-300">Book Tickets</a></li>
            <li class="w-full hover:bg-slate-500 bg-purple-500 p-3"><a href="/LetsGO/user/profile.php" class="hover:text-gray-300">Profile</a></li>
            <li class="w-full hover:bg-slate-500 bg-purple-500 p-3"><a :href="loggedin?'/LetsGO/auth/register.php?logout=true':'/LetsGO/auth/login.php'" class="hover:text-gray-300" x-text="loggedin ? 'Logout' : 'Login' "></a></li>
        </ul>
        <a class="icon " @click="isOpen = !isOpen" >
            <i x-show="!isOpen" class="text-white absolute right-3 top-4 fa fa-bars"></i>
            <i x-show="isOpen" class="text-white absolute right-3 top-4 fas fa-times"></i>
        </a>
    </div>
    <header class="text-gray-800 hidden sm:block bg-white">
        <nav class="container mx-auto p-4 flex justify-between items-center">
            <div class="text-xl font-semibold">LetsGO Ticketing System</div>

            <ul class="flex space-x-6">
                <li><a href="/LetsGO/index.php" class="hover:text-gray-300">Home</a></li>
                <li><a href="/LetsGO/user/search.php" class="hover:text-gray-300">Book Tickets</a></li>
                <li><a href="/LetsGO/user/profile.php" class="hover:text-gray-300">Profile</a></li>
                <li><a href="#" class="hover:text-gray-300">Support</a></li>
                <li><a :href="loggedin?'/LetsGO/auth/register.php?logout=true':'/LetsGO/auth/login.php'" class="p-2 bg-blue-600 text-white rounded-lg hover:text-gray-300" x-text="loggedin ? 'Logout' : 'Login' "></a></li>
            </ul>
        </nav>
    </header>
    <main class=" w-3/4 mx-auto px-8rem flex flex-col justify-center items-center">
        <section class=" w-full border mt-4 bg-cover bg-center min-h-[100vh] flex justify-end gap-2 p-6 text-gray-100 rounded-xl text-start flex-col" style="background:linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0.7)), url('./assets/annie-spratt-tG822f1XzT4-unsplash.jpg'); height:50vh; background-size: cover;">
            <h1 class="text-2xl md:text-4xl font-bold mb-4">Welcome to LetsGO Ticketing System</h1>
            <p class="text-xl mb-8">Book your tickets easily and travel safely with us!</p>
            <a href="/LetsGO/user/search.php" class="">
            <button type="button" class="inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-center text-white border border-white rounded-lg hover:bg-white hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-700">
                    Book Now
                    <svg class="ml-3 w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </button>
            </a>
        </section>
       
        <section class="container mx-auto py-16">
            <div class="grid grid-cols-1 border md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white shadow-lg rounded">
                    <h2 class="text-2xl font-bold mb-4">Easy Booking</h2>
                    <p>Search and book tickets easily with our user-friendly interface.</p>
                </div>
                <div class="text-center p-6 bg-white shadow-lg rounded">
                    <h2 class="text-2xl font-bold mb-4">Secure Payment</h2>
                    <p>Multiple payment options to ensure a secure transaction.</p>
                </div>
                <div class="text-center p-6 bg-white shadow-lg rounded">
                    <h2 class="text-2xl font-bold mb-4">24/7 Support</h2>
                    <p>Our customer support team is here to help you anytime.</p>
                </div>
            </div>
        </section>
        
    </main>
    <footer class="bg-gray-800 text-white text-center p-6">
        <p>&copy; 2024 LetsGO Ticketing System. All rights reserved.</p>
    </footer>
</body>
</html>
