<header x-data="{  }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <a href="/LetsGO/driver/dashboard.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Driver</a>
        <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
            <i x-show="!isOpen" class="fas fa-bars"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </button>
    </div>

    <!-- Dropdown Nav -->
    <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
        <a href="/LetsGO/driver/dashboard.php" :class="thisPath == '/LetsGO/driver/dashboard.php' ? 'active-nav-link' : '' " class="flex items-center  text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="/LetsGO/driver/my-customers.php" :class="thisPath == '/LetsGO/driver/my-customers.php' ? 'active-nav-link' : '' " class="flex items-center text-white py-2 pl-4 nav-item">
            <i class="fas fa-sticky-note mr-3"></i>
            My Customers
        </a>
        <a href="/LetsGO/driver/scan-ticket.php" :class="thisPath == '/LetsGO/driver/scan-ticket.php' ? 'active-nav-link' : '' " class="flex items-center text-white  opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-qrcode"></i>
            Scan Ticket
        </a>
        <a href="/LetsGO/driver/profile.php" :class="thisPath == '/LetsGO/driver/profile.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-user mr-3"></i>
            My Account
        </a>
        <a href="/LetsGO/auth/register.php?logout=true" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-sign-out-alt mr-3"></i>
            Sign Out
        </a>
    </nav>
</header>