<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - HCC Drive</title>
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

        /* Pagination CSS */
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

        /* Tab Active State */
        .tab-btn.active {
            border-bottom: 2px solid #2563eb;
            color: #2563eb;
            font-weight: 600;
        }
        /* Dark Mode Active Tab */
        .dark .tab-btn.active {
            color: #60a5fa; /* blue-400 */
            border-color: #60a5fa;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Archived Items</h1>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6"><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>

            <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button onclick="switchTab('users')" id="btn-users" class="tab-btn active whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
                        <i class='bx bx-user mr-2'></i> Archived Users
                    </button>
                    <button onclick="switchTab('depts')" id="btn-depts" class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
                        <i class='bx bxs-building-house mr-2'></i> Departments
                    </button>
                    <button onclick="switchTab('folders')" id="btn-folders" class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
                        <i class='bx bxs-folder mr-2'></i> Folders
                    </button>
                    <button onclick="switchTab('files')" id="btn-files" class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
                        <i class='bx bxs-file mr-2'></i> Files
                    </button>
                </nav>
            </div>

            <div id="tab-users" class="tab-content">
                <?php if(!empty($users)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        <?php foreach($users as $user): ?>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold">
                                    <?= substr($user['username'], 0, 1) ?>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-200 block"><?= esc($user['username']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 block"><?= esc($user['role']) ?></span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="<?= base_url('admin/archive/restore/user/'.$user['id']) ?>" class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/20 p-2 rounded-full" title="Restore"><i class='bx bx-revision'></i></a>
                                <a href="<?= base_url('admin/archive/delete/user/'.$user['id']) ?>" onclick="return confirm('Permanently delete this user?')" class="text-red-400 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 p-2 rounded-full" title="Delete Forever"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-center"><?= $pager_users->links('users') ?></div>
                <?php else: ?>
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-400 dark:text-gray-500 text-sm">No archived users found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="tab-depts" class="tab-content hidden">
                <?php if(!empty($departments)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        <?php foreach($departments as $dept): ?>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 font-bold">
                                    <i class='bx bxs-building-house'></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-200 block"><?= esc($dept['code']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 block truncate w-32"><?= esc($dept['name']) ?></span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="<?= base_url('admin/archive/restore/department/'.$dept['id']) ?>" class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/20 p-2 rounded-full" title="Restore"><i class='bx bx-revision'></i></a>
                                <a href="<?= base_url('admin/archive/delete/department/'.$dept['id']) ?>" onclick="return confirm('Permanently delete this department?')" class="text-red-400 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 p-2 rounded-full" title="Delete Forever"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-center"><?= $pager_departments->links('departments') ?></div>
                <?php else: ?>
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-400 dark:text-gray-500 text-sm">No archived departments.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="tab-folders" class="tab-content hidden">
                <?php if(!empty($folders)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        <?php foreach($folders as $folder): ?>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3">
                                <i class='bx bxs-folder text-yellow-400 text-3xl'></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-200"><?= esc($folder['name']) ?></span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="<?= base_url('admin/archive/restore/folder/'.$folder['id']) ?>" class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/20 p-2 rounded-full" title="Restore"><i class='bx bx-revision'></i></a>
                                <a href="<?= base_url('admin/archive/delete/folder/'.$folder['id']) ?>" onclick="return confirm('Permanently delete this folder?')" class="text-red-400 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 p-2 rounded-full" title="Delete Forever"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-center"><?= $pager_folders->links('folders') ?></div>
                <?php else: ?>
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-400 dark:text-gray-500 text-sm">No archived folders.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="tab-files" class="tab-content hidden">
                <?php if(!empty($files)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach($files as $file): ?>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3 overflow-hidden">
                                <i class='bx bxs-file text-blue-400 text-2xl'></i>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-200 truncate"><?= esc($file['filename']) ?></span>
                            </div>
                            <div class="flex space-x-2 shrink-0">
                                <a href="<?= base_url('admin/archive/restore/file/'.$file['id']) ?>" class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 bg-green-50 dark:bg-green-900/20 p-2 rounded-full" title="Restore"><i class='bx bx-revision'></i></a>
                                <a href="<?= base_url('admin/archive/delete/file/'.$file['id']) ?>" onclick="return confirm('Permanently delete this file?')" class="text-red-400 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 p-2 rounded-full" title="Delete Forever"><i class='bx bx-trash'></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-center mt-4"><?= $pager_files->links('files') ?></div>
                <?php else: ?>
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-400 dark:text-gray-500 text-sm">No archived files.</p>
                    </div>
                <?php endif; ?>
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
        // TAB SWITCHING LOGIC
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400', 'dark:border-blue-400');
                el.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });

            document.getElementById('tab-' + tabName).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-' + tabName);
            activeBtn.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400', 'dark:border-blue-400');
            activeBtn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            
            localStorage.setItem('activeArchiveTab', tabName);
        }

        // Initialize Tab on Load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTab = localStorage.getItem('activeArchiveTab') || 'users';
            switchTab(savedTab);
        });

        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>
</body>
</html> 