<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCC Drive - Faculty</title>
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

    <!-- SIDEBAR -->
    <?= view('components/sidebar_faculty'); ?>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="flex items-center flex-1 max-w-2xl">
                <!-- UPDATED SEARCH BAR CONTAINER -->
                <div class="relative w-full group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400 text-xl group-focus-within:text-green-500 transition-colors'></i>
                    </span>
                    
                    <input type="text" id="searchInput" onkeyup="filterFiles()" 
                           placeholder="Search shared files..." 
                           class="block w-full pl-10 pr-10 py-2 border-none rounded-lg bg-gray-100 focus:ring-2 focus:ring-green-500 focus:bg-white transition-colors text-sm">
                    
                    <!-- Clear Button -->
                    <button id="clearBtn" onclick="clearSearch()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 hidden cursor-pointer transition-colors">
                        <i class='bx bx-x-circle text-xl'></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-4 ml-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase">Faculty</p>
                </div>
                <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
            </div>
        </header>

        <!-- FILE BROWSER AREA -->
        <main class="flex-1 overflow-y-auto p-6">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Shared Repository</h1>
                <div class="flex space-x-2">
                     <button class="p-2 bg-gray-200 rounded hover:bg-gray-300"><i class='bx bx-list-ul'></i></button>
                     <button class="p-2 bg-green-100 text-green-600 rounded"><i class='bx bx-grid-alt'></i></button>
                </div>
            </div>

            <!-- FILES GRID (Added ID) -->
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">All Files</h2>
            <div id="fileGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                <?php if(!empty($files)): foreach($files as $file): ?>
                
                <!-- FILE CARD (Added class 'file-item') -->
                <div class="file-item bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-shadow flex flex-col justify-between h-40 relative group">
                    <div class="flex justify-between items-start">
                        <div class="p-2 rounded-lg bg-green-100 text-green-600">
                            <i class='bx bxs-file-doc text-xl'></i>
                        </div>
                        <!-- No Delete Button here -->
                    </div>
                    <div>
                        <!-- FILENAME (Added class 'file-name') -->
                        <h3 class="file-name text-sm font-medium text-gray-700 truncate" title="<?= esc($file['filename']) ?>">
                            <?= esc($file['filename']) ?>
                        </h3>
                        <div class="flex justify-between items-end mt-1">
                            <p class="text-xs text-gray-500"><?= esc($file['file_size']) ?></p>
                            <a href="<?= base_url('file/download/'.$file['id']) ?>" class="text-green-600 hover:underline text-xs font-semibold">Download</a>
                        </div>
                    </div>
                </div>

                <?php endforeach; else: ?>
                    <p class="text-gray-500 col-span-3">No files shared yet.</p>
                <?php endif; ?>

                <!-- No Results Hidden Message -->
                <div id="noResults" class="hidden col-span-full text-center py-10 text-gray-400">
                    <i class='bx bx-search text-4xl mb-2'></i>
                    <p>No matching files found.</p>
                </div>

            </div>
        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        function filterFiles() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let clearBtn = document.getElementById('clearBtn');
            let fileGrid = document.getElementById('fileGrid');
            let cards = fileGrid.getElementsByClassName('file-item');
            let noResults = document.getElementById('noResults');
            let visibleCount = 0;

            if(filter.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

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

            if(visibleCount === 0 && cards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
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