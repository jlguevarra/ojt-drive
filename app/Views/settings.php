<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        // Init Theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        tailwind.config = { darkMode: 'class' };
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?php 
        $role = session()->get('role');
        $isAdmin = ($role == 'admin' || $role == 'program_chair'); // Check for admin/chair privileges generally
        $canEditEmail = ($role == 'admin'); // Specific flag for email editing (Admins only)
        $themeColor = $isAdmin ? 'blue' : 'green';
    ?>

    <?php 
        if(session()->get('role') == 'faculty') {
            echo view('components/sidebar_faculty');
        } else {
            echo view('components/sidebar_admin');
        }
    ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Account Settings</h1>
            
            <div class="flex items-center space-x-4">
                <button onclick="toggleTheme()" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-yellow-400 transition-colors focus:outline-none">
                    <i class='bx bxs-sun text-2xl dark:hidden'></i>
                    <i class='bx bxs-moon text-2xl hidden dark:block'></i>
                </button>

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase"><?= $role ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-<?= $themeColor ?>-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-2xl mx-auto">
                
                <?php if(session()->getFlashdata('success')):?>
                    <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-6 rounded-r shadow-sm flex items-center">
                        <i class='bx bx-check-circle mr-2 text-xl'></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif;?>

                <?php if(session()->getFlashdata('errors')):?>
                    <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-600 dark:text-red-300 p-4 mb-6 rounded-lg text-sm">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <p class="flex items-center"><i class='bx bx-error-circle mr-2'></i> <?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your personal details and password.</p>
                    </div>
                    
                    <form action="<?= base_url('settings/update') ?>" method="post" class="p-6 space-y-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <input type="text" name="email" value="<?= session()->get('email') ?>" 
                                <?= $canEditEmail ? '' : 'disabled' ?> 
                                class="block w-full px-3 py-2 border rounded-lg text-sm transition-colors 
                                <?= $canEditEmail 
                                    ? "border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-{$themeColor}-500 focus:border-{$themeColor}-500" 
                                    : "border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400" 
                                ?>">
                            
                            <?php if(!$canEditEmail): ?>
                                <p class="text-xs text-gray-400 mt-1">Email cannot be changed. Contact admin for help.</p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <input type="text" name="username" value="<?= session()->get('username') ?>" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
                        </div>

                        <hr class="border-gray-100 dark:border-gray-700 my-4">

                        <div>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-4">Change Password</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                                    <input type="password" name="password" placeholder="Leave blank to keep current" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                                    <input type="password" name="confpassword" placeholder="Confirm new password" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-<?= $themeColor ?>-600 hover:bg-<?= $themeColor ?>-700 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-all transform hover:scale-105">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

    <div id="logoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-2xl w-80 transform scale-100 transition-transform text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class='bx bx-log-out text-2xl text-red-600'></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Confirm Logout</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to sign out of your account?</p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition-colors">Cancel</button>
                <a href="<?= base_url('/logout') ?>" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium shadow-md shadow-red-500/30 transition-colors">Logout</a>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>
</body>
</html>