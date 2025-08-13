<div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-6 z-50 transition-all duration-300 ease-in-out shadow-2xl sidebar">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img src="../assets/images/me.png" alt="Logo" class="w-10 h-10 rounded-full logo-icon">
            <div class="ml-3 logo-text">
                <h2 class="text-xl font-bold text-white">Nandhakumar Sekar</h2>
               
            </div>
        </div>
    </div>
    <nav class="space-y-1">
        <a href="dashboard.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-home w-6"></i>
            <span class="ml-3 nav-text">Dashboard</span>
        </a>
        <a href="manage_projects.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'manage_projects.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-project-diagram w-6"></i>
            <span class="ml-3 nav-text">Projects</span>
        </a>
        <a href="manage_blog.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'manage_blog.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-blog w-6"></i>
            <span class="ml-3 nav-text">Blog Posts</span>
        </a>
        <a href="resume_management.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'resume_management.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-file-alt w-6"></i>
            <span class="ml-3 nav-text">Resume</span>
        </a>
        <a href="admin_contact_manage.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'admin_contact_manage.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-envelope w-6"></i>
            <span class="ml-3 nav-text">Contact</span>
        </a>
        <a href="skills_manage.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'skills_manage.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-cog w-6"></i>
            <span class="ml-3 nav-text">Skills</span>
        </a>
        <a href="services_manage.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2 <?php echo basename($_SERVER['PHP_SELF']) == 'services_manage.php' ? 'bg-blue-700' : ''; ?>">
            <i class="fas fa-concierge-bell w-6"></i>
            <span class="ml-3 nav-text">Services</span>
        </a>
        <a href="../index.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-2">
            <i class="fas fa-sign-out-alt w-6"></i>
            <span class="ml-3 nav-text">Logout</span>
        </a>
    </nav>
    
    <!-- <div class="absolute bottom-0 left-0 right-0 p-6 bg-gray-800">
        
    </div> -->
</div>

<script>
    // Sidebar toggle functionality with persistence
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const logoText = document.querySelector('.logo-text');
        const navTexts = document.querySelectorAll('.nav-text');
        const mainContent = document.querySelector('main');
        const header = document.querySelector('header');

        // Check localStorage for sidebar state
        const isCompact = localStorage.getItem('sidebarCompact') === 'true';
        if (isCompact) {
            sidebar.classList.add('compact');
            sidebar.style.width = '80px'; // Compact width
            mainContent.style.marginLeft = '80px'; // Adjust main content margin
            header.style.left = '80px'; // Adjust header position
            logoText.style.display = 'none';
            navTexts.forEach(text => text.style.display = 'none');
        } else {
            sidebar.style.width = '256px'; // Full width
            mainContent.style.marginLeft = '256px'; // Adjust main content margin
            header.style.left = '256px'; // Adjust header position
            logoText.style.display = 'block';
            navTexts.forEach(text => text.style.display = 'inline');
        }

        // Toggle sidebar on button click
        document.getElementById('sidebar-toggle').addEventListener('click', function () {
            const isCurrentlyCompact = sidebar.classList.contains('compact');
            sidebar.classList.toggle('compact');
            if (!isCurrentlyCompact) {
                sidebar.style.width = '80px'; // Compact width
                mainContent.style.marginLeft = '80px'; // Adjust main content margin
                header.style.left = '80px'; // Adjust header position
                logoText.style.display = 'none';
                navTexts.forEach(text => text.style.display = 'none');
                localStorage.setItem('sidebarCompact', 'true'); // Save compact state
            } else {
                sidebar.style.width = '256px'; // Full width
                mainContent.style.marginLeft = '256px'; // Adjust main content margin
                header.style.left = '256px'; // Adjust header position
                logoText.style.display = 'block';
                navTexts.forEach(text => text.style.display = 'inline');
                localStorage.setItem('sidebarCompact', 'false'); // Save full state
            }
        });
    });
</script>