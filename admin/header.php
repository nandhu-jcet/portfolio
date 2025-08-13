<header class="fixed top-0 left-64 right-0 bg-white dark:bg-gray-800 shadow-md z-40 transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-between px-8 py-4">
        <div class="flex items-center space-x-4">
            <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white"><?php echo $pageTitle; ?></h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <button class="relative p-2 text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <div class="flex items-center space-x-3">
                <img src="../assets/images/avatar.png" alt="Profile" class="w-8 h-8 rounded-full">
                <span class="text-gray-700 dark:text-white">Boori Boori</span>
            </div>
        </div>
    </div>
</header>