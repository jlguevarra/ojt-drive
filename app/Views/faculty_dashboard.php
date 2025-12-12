<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCC Drive - Faculty</title>
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?= view('components/sidebar_faculty'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <div class="flex items-center flex-1 max-w-3xl">
                <div class="relative w-full max-w-md group mr-4">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400 dark:text-gray-500 text-xl group-focus-within:text-green-500 transition-colors'></i>
                    </span>
                    <input type="text" id="searchInput" onkeyup="filterFiles()" 
                           placeholder="Search shared files..." 
                           class="block w-full pl-10 pr-10 py-2 border-none rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:bg-white dark:focus:bg-gray-600 transition-colors text-sm">
                    <button id="clearBtn" onclick="clearSearch()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 hidden cursor-pointer transition-colors">
                        <i class='bx bx-x-circle text-xl'></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-4 ml-4">
                <button onclick="toggleTheme()" class="text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-yellow-400 transition-colors focus:outline-none">
                    <i class='bx bxs-sun text-2xl dark:hidden'></i>
                    <i class='bx bxs-moon text-2xl hidden dark:block'></i>
                </button>

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert"><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>
            <?php if(session()->getFlashdata('error')):?>
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert"><?= session()->getFlashdata('error') ?></div>
            <?php endif;?>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                
                <nav class="flex overflow-x-auto" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="<?= base_url('faculty/dashboard') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                                <i class='bx bxs-home mr-2'></i> Shared Files
                            </a>
                        </li>
                        
                        <?php if(!empty($breadcrumbs)): foreach($breadcrumbs as $crumb): ?>
                        <li>
                            <div class="flex items-center">
                                <i class='bx bx-chevron-right text-gray-400 text-xl'></i>
                                <a href="<?= base_url('faculty/dashboard?folder_id='.$crumb['id']) ?>" class="ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 md:ml-2">
                                    <?= esc($crumb['name']) ?>
                                </a>
                            </div>
                        </li>
                        <?php endforeach; endif; ?>
                    </ol>
                </nav>

                <div class="flex space-x-3">
                    </div>
            </div>

            <?php if(!empty($folders)): ?>
            <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Folders</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
                <?php foreach($folders as $folder): ?>
                <a href="<?= base_url('faculty/dashboard?folder_id='.$folder['id']) ?>" class="block group">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-green-50 dark:hover:bg-green-900/30 hover:border-green-200 dark:hover:border-green-800 cursor-pointer transition-all flex items-center space-x-3 relative">
                        <i class='bx bxs-folder text-yellow-500 text-3xl group-hover:scale-110 transition-transform'></i>
                        
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate flex-1" title="<?= esc($folder['name']) ?>">
                            <?= esc($folder['name']) ?>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Files</h2>
            <div id="fileGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                <?php if(!empty($files)): foreach($files as $file): ?>
                
                <div class="file-item bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow flex flex-col justify-between h-44 relative group">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                                <i class='bx bxs-file-doc text-xl'></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="file-name text-sm font-medium text-gray-700 dark:text-gray-200 truncate mt-2" title="<?= esc($file['filename']) ?>">
                            <?= esc($file['filename']) ?>
                        </h3>
                        <div class="flex justify-between items-end mt-1">
                            <div class="flex flex-col">
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase font-semibold tracking-wider">
                                    <?= !empty($file['folder_name']) ? esc($file['folder_name']) : 'File' ?>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= esc($file['file_size']) ?></p>
                            </div>
                            
                            <button onclick="openPreview(<?= $file['id'] ?>, '<?= esc($file['filename']) ?>')" class="text-green-600 dark:text-green-400 hover:underline text-xs font-semibold">Preview</button>
                        </div>
                    </div>
                </div>

                <?php endforeach; endif; ?>
                
                <?php if(empty($files) && empty($folders)): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="inline-block p-4 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                            <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">This folder is empty.</p>
                    </div>
                <?php endif; ?>

                <div id="noResults" class="hidden col-span-full text-center py-10 text-gray-400">
                    <i class='bx bx-search text-4xl mb-2'></i>
                    <p>No matching files found.</p>
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

    <div id="previewModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col">
            <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white" id="previewTitle">File Preview</h3>
                <div class="flex space-x-2">
                    <a id="downloadBtn" href="#" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 flex items-center">
                        <i class='bx bx-download mr-1'></i> Download
                    </a>
                    <button onclick="closePreview()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 text-2xl">&times;</button>
                </div>
            </div>
            <div class="flex-1 bg-gray-100 dark:bg-gray-900 p-2 relative flex items-center justify-center">
                <iframe id="previewFrame" src="" class="w-full h-full border-none bg-white hidden"></iframe>
                <div id="noPreviewMsg" class="text-center hidden">
                    <i class='bx bxs-file-doc text-6xl text-gray-400 mb-4'></i>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Preview Not Available</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">This file type cannot be viewed in the browser.</p>
                    <p class="text-gray-500 dark:text-gray-400">Please download the file to view it.</p>
                </div>
                <div id="previewLoading" class="absolute inset-0 flex items-center justify-center text-gray-500 hidden bg-white dark:bg-gray-900 bg-opacity-90">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }

        function openPreview(id, filename) {
            document.getElementById('previewModal').classList.remove('hidden');
            document.getElementById('previewTitle').innerText = filename;
            document.getElementById('downloadBtn').href = "<?= base_url('file/download/') ?>" + id;
            
            const frame = document.getElementById('previewFrame');
            const noPreview = document.getElementById('noPreviewMsg');
            const loading = document.getElementById('previewLoading');

            const ext = filename.split('.').pop().toLowerCase();
            const viewable = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt'];

            if (viewable.includes(ext)) {
                noPreview.classList.add('hidden');
                frame.classList.remove('hidden');
                loading.classList.remove('hidden');
                frame.onload = function() { loading.classList.add('hidden'); };
                frame.src = "<?= base_url('file/preview/') ?>" + id;
            } else {
                frame.src = "";
                frame.classList.add('hidden');
                loading.classList.add('hidden');
                noPreview.classList.remove('hidden');
            }
        }
        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewFrame').src = "";
        }

        function filterFiles() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let clearBtn = document.getElementById('clearBtn');
            let cards = document.getElementsByClassName('file-item');
            let noResults = document.getElementById('noResults');
            let visibleCount = 0;

            if(filter.length > 0) { clearBtn.classList.remove('hidden'); } 
            else { clearBtn.classList.add('hidden'); }

            for (let i = 0; i < cards.length; i++) {
                let titleElement = cards[i].getElementsByClassName('file-name')[0];
                let txtValue = titleElement.textContent || titleElement.innerText;
                
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    cards[i].classList.remove('hidden');
                    visibleCount++;
                } else {
                    cards[i].classList.add('hidden');
                }
            }
            if(visibleCount === 0 && cards.length > 0) { noResults.classList.remove('hidden'); } 
            else { noResults.classList.add('hidden'); }
        }

        function clearSearch() {
            let input = document.getElementById('searchInput');
            input.value = '';
            filterFiles();
            input.focus();
        }
    </script>
</body>
</html>