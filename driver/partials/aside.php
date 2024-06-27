<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="/LetsGO/diver/dashboard.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Driver</a>
    </div>

    <nav class="text-white text-base font-semibold pt-3">
        <a href="/LetsGO/driver/dashboard.php" :class="thisPath == '/LetsGO/driver/dashboard.php' ? 'active-nav-link' : '' " class="flex items-center  text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="/LetsGO/driver/my-customers.php" :class="thisPath == '/LetsGO/driver/my-customers.php' ? 'active-nav-link' : '' " class="flex items-center text-white py-4 pl-6 nav-item">
            <i class="fas fa-sticky-note mr-3"></i>
            My Customers
        </a>
        <a href="/LetsGO/driver/scan-ticket.php" :class="thisPath == '/LetsGO/driver/scan-ticket.php' ? 'active-nav-link' : '' "  class="flex items-center  text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fa-solid fa-qrcode mr-3"></i>
            Scan Ticket
        </a>
        
        
    </nav>
</aside>