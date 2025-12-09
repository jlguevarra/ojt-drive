<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs - HCC Drive</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- REUSE ADMIN SIDEBAR -->
    <?= view('components/sidebar_admin'); ?>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- HEADER (Updated to match Settings/Archive) -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <h1 class="text-xl font-bold text-gray-800">System Logs</h1>
            
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <!-- Logout Button Trigger -->
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <!-- TABLE AREA -->
        <main class="flex-1 overflow-y-auto p-8">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Activity Audit Trail</h2>
                    <p class="text-sm text-gray-500 mt-1">Monitoring user actions, uploads, and system events.</p>
                </div>
                <!-- Optional: Add an Export Button later -->
                <button onclick="window.print()" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                    <i class='bx bx-printer mr-1'></i> Print Logs
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Timestamp</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(!empty($logs)): foreach($logs as $log): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            
                            <!-- 1. TIME -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                <?= date('M d, Y h:i:s A', strtotime($log['created_at'])) ?>
                            </td>

                            <!-- 2. USER -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                                        <?= substr($log['username'], 0, 1) ?>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900"><?= esc($log['username']) ?></div>
                                    </div>
                                </div>
                            </td>

                            <!-- 3. ACTION (Color Coded) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $color = 'gray';
                                    $icon = 'bx-radio-circle';
                                    
                                    if(strpos($log['action'], 'Login') !== false) { $color = 'green'; $icon = 'bx-log-in-circle'; }
                                    elseif(strpos($log['action'], 'Upload') !== false) { $color = 'blue'; $icon = 'bx-cloud-upload'; }
                                    elseif(strpos($log['action'], 'Delete') !== false || strpos($log['action'], 'Archive') !== false) { $color = 'red'; $icon = 'bx-trash'; }
                                    elseif(strpos($log['action'], 'Create') !== false) { $color = 'purple'; $icon = 'bx-plus-circle'; }
                                    elseif(strpos($log['action'], 'Restore') !== false) { $color = 'teal'; $icon = 'bx-revision'; }
                                ?>
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-<?= $color ?>-50 text-<?= $color ?>-700 border border-<?= $color ?>-200">
                                    <i class='bx <?= $icon ?> mr-1'></i>
                                    <?= esc($log['action']) ?>
                                </span>
                            </td>

                            <!-- 4. DETAILS -->
                            <td class="px-6 py-4 text-sm text-gray-600 break-all max-w-xs">
                                <?= esc($log['details']) ?>
                            </td>

                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                <i class='bx bx-history text-4xl mb-2 text-gray-300'></i>
                                <p>No activity recorded yet.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- LOGOUT MODAL -->
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
        // LOGOUT LOGIC
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>
</body>
</html> 