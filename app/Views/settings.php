<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <?php 
        // DYNAMIC THEME LOGIC
        $role = session()->get('role');
        $isAdmin = ($role == 'admin' || $role == 'program_chair');
        
        // Colors
        $themeColor = $isAdmin ? 'blue' : 'green';
    ?>

    <!-- SIDEBAR -->
    <?php 
        if(session()->get('role') == 'faculty') {
            echo view('components/sidebar_faculty');
        } else {
            echo view('components/sidebar_admin');
        }
    ?>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <h1 class="text-xl font-bold text-gray-800">Account Settings</h1>
            
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase"><?= $role ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-<?= $themeColor ?>-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <!-- [NEW] Logout Button Trigger -->
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <!-- FORM AREA -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-2xl mx-auto">
                
                <?php if(session()->getFlashdata('success')):?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm flex items-center">
                        <i class='bx bx-check-circle mr-2 text-xl'></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif;?>

                <?php if(session()->getFlashdata('errors')):?>
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 mb-6 rounded-lg text-sm">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <p class="flex items-center"><i class='bx bx-error-circle mr-2'></i> <?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                        <p class="text-sm text-gray-500">Update your personal details and password.</p>
                    </div>
                    
                    <form action="<?= base_url('settings/update') ?>" method="post" class="p-6 space-y-6">
                        
                        <!-- Read Only Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="text" value="<?= session()->get('email') ?>" disabled class="block w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-500 text-sm">
                            <p class="text-xs text-gray-400 mt-1">Email cannot be changed. Contact admin for help.</p>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="username" value="<?= session()->get('username') ?>" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
                        </div>

                        <hr class="border-gray-100 my-4">

                        <!-- Password Section -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-4">Change Password</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="password" placeholder="Leave blank to keep current" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Confirm Password</label>
                                    <input type="password" name="confpassword" placeholder="Confirm new password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-<?= $themeColor ?>-500 focus:border-<?= $themeColor ?>-500 text-sm transition-colors">
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

    <!-- [NEW] LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-2xl w-80 transform scale-100 transition-transform text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class='bx bx-log-out text-2xl text-red-600'></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Confirm Logout</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to sign out of your account?</p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">Cancel</button>
                <a href="<?= base_url('/logout') ?>" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium shadow-md shadow-red-500/30 transition-colors">Logout</a>
            </div>
        </div>
    </div>

    <script>
        // [NEW] LOGOUT LOGIC
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>

</body>
</html>