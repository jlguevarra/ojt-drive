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
        
        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                <span>Admin Panel</span>
                <i class='bx bx-chevron-right'></i>
                <span class="font-semibold text-gray-800">System Logs</span>
            </div>
            <div class="flex items-center space-x-4 ml-4">
                <span class="text-sm font-medium text-gray-800"><?= session()->get('username') ?> (Admin)</span>
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
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
                                        <?= substr($log['user_name'], 0, 1) ?>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900"><?= esc($log['user_name']) ?></div>
                                        <div class="text-xs text-gray-400 capitalize"><?= str_replace('_', ' ', $log['role']) ?></div>
                                    </div>
                                </div>
                            </td>

                            <!-- 3. ACTION (Color Coded) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $color = 'gray';
                                    $icon = 'bx-radio-circle';
                                    
                                    switch($log['action']) {
                                        case 'Login': 
                                            $color = 'green'; 
                                            $icon = 'bx-log-in-circle';
                                            break;
                                        case 'Upload': 
                                            $color = 'blue'; 
                                            $icon = 'bx-cloud-upload';
                                            break;
                                        case 'Delete': 
                                            $color = 'red'; 
                                            $icon = 'bx-trash';
                                            break;
                                        case 'Create User':
                                            $color = 'purple';
                                            $icon = 'bx-user-plus';
                                            break;
                                    }
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

</body>
</html>