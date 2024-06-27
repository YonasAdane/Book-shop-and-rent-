<header x-data="{  }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
            <i x-show="!isOpen" class="fas fa-bars"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </button>
    </div>

    <!-- Dropdown Nav -->
    <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
        <a href="/LetsGO/admin/dashboard.php" :class="thisPath == '/LetsGO/admin/dashboard.php' ? 'active-nav-link' : '' "  class="flex items-center  text-white py-2 pl-4 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="/LetsGO/admin/all-drivers.php" :class="thisPath == '/LetsGO/admin/all-drivers.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-gauge mr-3"></i>
            View Drivers
        </a>
        <a href="/LetsGO/admin/add-driver.php" :class="thisPath == '/LetsGO/admin/add-driver.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-plus mr-3"></i>
            Add Driver
        </a>
        <a href="/LetsGO/admin/all-buses.php" :class="thisPath == '/LetsGO/admin/all-buses.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-bus mr-3"></i>
            View Buses
        </a>
        <a href="/LetsGO/admin/addBuzz.php" :class="thisPath == '/LetsGO/admin/addBuzz.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-plus mr-3"></i>
            Add Bus
        </a>
        <a href="/LetsGO/admin/all-busTypes.php" :class="thisPath == '/LetsGO/admin/all-busTypes.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-van-shuttle mr-3"></i>
            View Bus Category
        </a>
        <a href="/LetsGO/admin/add-buzzType.php" :class="thisPath == '/LetsGO/admin/add-buzzType.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-plus mr-3"></i>
            Add Bus category
        </a>
        <a href="/LetsGO/admin/routes.php" :class="thisPath == '/LetsGO/admin/routes.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fa-solid fa-road mr-3"></i>
            View Routes
        </a>
        <a href="/LetsGO/admin/profile.php" :class="thisPath == '/LetsGO/admin/all-drivers.php' ? 'active-nav-link' : '' " class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-user mr-3"></i>
            My Account
        </a>
        <a href="/LetsGO/auth/register.php?logout=true" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-sign-out-alt mr-3"></i>
            Sign Out
        </a>
    </nav>
</header>