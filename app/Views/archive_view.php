<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <h1 class="text-xl font-bold text-gray-800">Archived Items</h1>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <!-- [NEW] Logout Button -->
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>

            <!-- FOLDERS -->
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Archived Folders</h2>
            <?php if(!empty($folders)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <?php foreach($folders as $folder): ?>
                    <div class="bg-white p-4 rounded-xl border border-gray-200 flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <i class='bx bxs-folder text-gray-400 text-3xl'></i>
                            <span class="text-sm font-medium text-gray-600"><?= esc($folder['name']) ?></span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="<?= base_url('admin/archive/restore/folder/'.$folder['id']) ?>" class="text-green-500 hover:text-green-700" title="Restore"><i class='bx bx-revision text-xl'></i></a>
                            <a href="<?= base_url('admin/archive/delete/folder/'.$folder['id']) ?>" onclick="return confirm('Permanently delete this folder?')" class="text-red-400 hover:text-red-600" title="Delete Forever"><i class='bx bx-trash text-xl'></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400 text-sm mb-8">No archived folders.</p>
            <?php endif; ?>

            <!-- FILES -->
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Archived Files</h2>
            <?php if(!empty($files)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach($files as $file): ?>
                    <div class="bg-white p-4 rounded-xl border border-gray-200 flex justify-between items-center">
                        <div class="flex items-center space-x-3 overflow-hidden">
                            <i class='bx bxs-file text-gray-400 text-2xl'></i>
                            <span class="text-sm font-medium text-gray-600 truncate"><?= esc($file['filename']) ?></span>
                        </div>
                        <div class="flex space-x-2 shrink-0">
                            <a href="<?= base_url('admin/archive/restore/file/'.$file['id']) ?>" class="text-green-500 hover:text-green-700" title="Restore"><i class='bx bx-revision text-xl'></i></a>
                            <a href="<?= base_url('admin/archive/delete/file/'.$file['id']) ?>" onclick="return confirm('Permanently delete this file?')" class="text-red-400 hover:text-red-600" title="Delete Forever"><i class='bx bx-trash text-xl'></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400 text-sm">No archived files.</p>
            <?php endif; ?>
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