<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        // Apply theme immediately
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        tailwind.config = { darkMode: 'class' };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); 
        body { font-family: 'Inter', sans-serif; }

        /* PAGINATION STYLES */
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; }
        .pagination li { display: inline-block; }
        .pagination li a, .pagination li span {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        /* Dark Mode overrides for pagination */
        .dark .pagination li a, .dark .pagination li span {
            background-color: #1f2937; /* gray-800 */
            border-color: #374151; /* gray-700 */
            color: #d1d5db; /* gray-300 */
        }

        .pagination li a:hover { background-color: #f3f4f6; color: #2563eb; }
        .dark .pagination li a:hover { background-color: #374151; color: #60a5fa; }

        .pagination li.active a, .pagination li.active span {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        /* PRINT STYLES */
        @media print {
            body, html, .flex-1, main {
                height: auto !important;
                overflow: visible !important;
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                color: black !important;
            }
            body > *:not(.flex-col) { display: none !important; }
            header, .pagination, button, a[href*="logout"] { display: none !important; }
            
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 12px;
            }
            th, td {
                border: 1px solid #000 !important;
                padding: 8px !important;
                color: #000 !important;
            }
            thead {
                background-color: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
            }
            .rounded-full {
                border: 1px solid #000 !important;
                color: #000 !important;
                background: none !important;
                padding: 2px 6px;
            }
            main::before {
                content: "HCC Drive - System Activity Logs";
                display: block;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                text-align: center;
            }
            main::after {
                content: "Generated on: " attr(data-date);
                display: block;
                font-size: 10px;
                color: #666;
                margin-top: 20px;
                text-align: right;
            }
            /* Force light mode for print */
            .dark { color: black !important; background: white !important; }
            .dark table { color: black !important; }
            .dark th, .dark td { border-color: black !important; }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300" data-date="<?= date('Y-m-d H:i:s') ?>">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden print-wrapper">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <div class="text-xl font-bold text-gray-800 dark:text-white">System Logs</div>
            
            <div class="flex items-center space-x-4 ml-4">
                <button onclick="toggleTheme()" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-yellow-400 transition-colors focus:outline-none">
                    <i class='bx bxs-sun text-2xl dark:hidden'></i>
                    <i class='bx bxs-moon text-2xl hidden dark:block'></i>
                </button>

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8" data-date="<?= date('Y-m-d H:i:s') ?>">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Activity Audit Trail</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitoring user actions, uploads, and system events.</p>
                </div>
                <button onclick="window.print()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex items-center text-sm">
                    <i class='bx bx-printer mr-1'></i> Print Logs
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Timestamp</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if(!empty($logs)): foreach($logs as $log): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= date('M d, Y h:i:s A', strtotime($log['created_at'])) ?>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold text-xs print:hidden">
                                        <?= substr($log['user_name'], 0, 1) ?>
                                    </div>
                                    <div class="ml-3 print:ml-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($log['user_name']) ?></div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 capitalize"><?= str_replace('_', ' ', $log['role']) ?></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $color = 'gray';
                                    $icon = 'bx-radio-circle';
                                    $act = $log['action'];
                                    
                                    if(stripos($act, 'Login') !== false) { $color = 'green'; $icon = 'bx-log-in-circle'; }
                                    elseif(stripos($act, 'Upload') !== false) { $color = 'blue'; $icon = 'bx-cloud-upload'; }
                                    elseif(stripos($act, 'Delete') !== false || stripos($act, 'Archive') !== false) { $color = 'red'; $icon = 'bx-trash'; }
                                    elseif(stripos($act, 'Create') !== false) { $color = 'purple'; $icon = 'bx-user-plus'; }
                                    elseif(stripos($act, 'Update') !== false) { $color = 'indigo'; $icon = 'bx-edit'; }
                                    elseif(stripos($act, 'Restore') !== false) { $color = 'teal'; $icon = 'bx-revision'; }
                                ?>
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-<?= $color ?>-50 dark:bg-<?= $color ?>-900/30 text-<?= $color ?>-700 dark:text-<?= $color ?>-300 border border-<?= $color ?>-200 dark:border-<?= $color ?>-800">
                                    <i class='bx <?= $icon ?> mr-1'></i>
                                    <?= esc($log['action']) ?>
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 break-all max-w-xs">
                                <?= esc($log['details']) ?>
                            </td>

                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                <i class='bx bx-history text-4xl mb-2 text-gray-300 dark:text-gray-600'></i>
                                <p>No activity recorded yet.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                <?= $pager->links() ?>
            </div>

        </main>
    </div>

</body>
</html>