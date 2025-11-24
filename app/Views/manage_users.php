<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - HCC Drive</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- SIDEBAR (Identical Structure) -->
    <div class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex">
        <div class="p-6 flex items-center space-x-2">
            <div class="bg-blue-600 p-2 rounded-lg">
                <i class='bx bxs-folder text-white text-xl'></i>
            </div>
            <span class="text-xl font-bold text-gray-800">HCC Drive</span>
        </div>

        <div class="px-4 mb-6">
            <!-- Upload Button (Redirects to Dashboard) -->
            <a href="<?= base_url('admin/dashboard') ?>" class="w-full flex items-center justify-center space-x-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-full shadow-sm transition-all font-medium decoration-transparent">
                <i class='bx bx-upload text-xl'></i>
                <span>New Upload</span>
            </a>
        </div>

        <nav class="flex-1 space-y-1 px-2">
            <!-- My Drive (Now Inactive/Gray) -->
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                <i class='bx bx-home-alt text-xl'></i>
                <span>My Drive</span>
            </a>
            <a href="#" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                <i class='bx bx-group text-xl'></i>
                <span>Shared with me</span>
            </a>
            
            <div class="border-t border-gray-100 my-4 pt-4"></div>
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin Panel</p>
            
            <!-- Manage Users (Now Active/Blue) -->
            <a href="#" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full bg-blue-100 text-blue-700 font-medium transition-colors">
                <i class='bx bx-user text-xl'></i>
                <span>Manage Users</span>
            </a>
            <a href="#" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                <i class='bx bx-cog text-xl'></i>
                <span>Settings</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200">
            <div class="bg-blue-50 rounded-lg p-3">
                <p class="text-xs text-blue-600 font-medium mb-1">Storage Used</p>
                <div class="w-full bg-blue-200 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: 45%"></div>
                </div>
                <p class="text-xs text-gray-500">Unlimited Access</p>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                <span>Admin Panel</span>
                <i class='bx bx-chevron-right'></i>
                <span class="font-semibold text-gray-800">User Management</span>
            </div>

            <div class="flex items-center space-x-4 ml-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
            </div>
        </header>

        <!-- TABLE AREA -->
        <main class="flex-1 overflow-y-auto p-8">
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex items-center">
                    <i class='bx bx-check-circle mr-2 text-xl'></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif;?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-gray-700 font-bold">Registered Users</h3>
                    <span class="text-xs text-gray-500">Total: <?= count($users) ?></span>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">System Role</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email Contact</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(!empty($users)): foreach($users as $user): ?>
                        <tr class="hover:bg-blue-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-600 font-bold shadow-sm">
                                        <?= substr($user['username'], 0, 1) ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= esc($user['username']) ?></div>
                                        <div class="text-xs text-gray-400">ID: #<?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $roleColor = 'bg-gray-100 text-gray-800';
                                    $icon = 'bx-user';
                                    if($user['role'] == 'admin') { $roleColor = 'bg-purple-100 text-purple-800'; $icon = 'bx-crown'; }
                                    if($user['role'] == 'program_chair') { $roleColor = 'bg-blue-100 text-blue-800'; $icon = 'bx-id-card'; }
                                    if($user['role'] == 'faculty') { $roleColor = 'bg-green-100 text-green-800'; $icon = 'bx-book-reader'; }
                                ?>
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full <?= $roleColor ?>">
                                    <i class='bx <?= $icon ?> mr-1'></i>
                                    <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($user['email']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('admin/deleteUser/'.$user['id']) ?>" onclick="return confirm('Are you sure? This will delete the user AND all files they uploaded.')" class="text-red-400 hover:text-red-600 transition-colors p-2 rounded hover:bg-red-50" title="Delete User">
                                    <i class='bx bx-trash text-lg'></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">No other users found in the system.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>