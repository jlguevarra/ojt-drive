<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCC Drive - Admin & Chair</title>
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
    <?= view('components/sidebar_admin'); ?>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="flex items-center flex-1 max-w-2xl">
                <!-- UPDATED SEARCH BAR CONTAINER -->
                <div class="relative w-full group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400 text-xl group-focus-within:text-blue-500 transition-colors'></i>
                    </span>
                    
                    <!-- Search Input with ID and onKeyup -->
                    <input type="text" id="searchInput" onkeyup="filterFiles()" 
                           placeholder="Search files instantly..." 
                           class="block w-full pl-10 pr-10 py-2 border-none rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors text-sm">
                    
                    <!-- Clear 'X' Button (Hidden by default) -->
                    <button id="clearBtn" onclick="clearSearch()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 hidden cursor-pointer transition-colors">
                        <i class='bx bx-x-circle text-xl'></i>
                    </button>
                </div>
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

        <!-- FILE BROWSER AREA -->
        <main class="flex-1 overflow-y-auto p-6">
            
            <!-- Alerts -->
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>
            <?php if(session()->getFlashdata('error')):?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><?= session()->getFlashdata('error') ?></div>
            <?php endif;?>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">My Drive</h1>
                <div class="flex space-x-2">
                     <button class="p-2 bg-gray-200 rounded hover:bg-gray-300"><i class='bx bx-list-ul'></i></button>
                     <button class="p-2 bg-blue-100 text-blue-600 rounded"><i class='bx bx-grid-alt'></i></button>
                </div>
            </div>

            <!-- FILES GRID (Added ID) -->
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">All Files</h2>
            <div id="fileGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                <?php if(!empty($files)): foreach($files as $file): ?>
                
                <!-- FILE CARD (Added class 'file-item') -->
                <div class="file-item bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-shadow flex flex-col justify-between h-40 relative group">
                    <div class="flex justify-between items-start">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                            <i class='bx bxs-file-doc text-xl'></i>
                        </div>
                        <!-- Delete Button (Visible to Admin/Chair Only) -->
                        <a href="<?= base_url('file/delete/'.$file['id']) ?>" onclick="return confirm('Are you sure you want to permanently delete this file?')" class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                            <i class='bx bx-trash text-xl'></i>
                        </a>
                    </div>
                    <div>
                        <!-- FILENAME (Added class 'file-name') -->
                        <h3 class="file-name text-sm font-medium text-gray-700 truncate" title="<?= esc($file['filename']) ?>">
                            <?= esc($file['filename']) ?>
                        </h3>
                        <div class="flex justify-between items-end mt-1">
                            <p class="text-xs text-gray-500"><?= esc($file['file_size']) ?></p>
                            <a href="<?= base_url('file/download/'.$file['id']) ?>" class="text-blue-600 hover:underline text-xs font-semibold">Download</a>
                        </div>
                    </div>
                </div>

                <?php endforeach; else: ?>
                    <p class="text-gray-500 col-span-3">No files found. Click "New Upload" to start.</p>
                <?php endif; ?>
                
                <!-- No Results Hidden Message -->
                <div id="noResults" class="hidden col-span-full text-center py-10 text-gray-400">
                    <i class='bx bx-search text-4xl mb-2'></i>
                    <p>No matching files found.</p>
                </div>

            </div>
        </main>
    </div>

    <!-- UPLOAD MODAL -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden h-full w-full z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-96 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Upload File</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form action="<?= base_url('/file/upload') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-6 border-2 border-dashed border-blue-300 rounded-lg p-8 text-center hover:bg-blue-50 transition-colors cursor-pointer relative group">
                    <input type="file" name="userfile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required onchange="updateFileName(this)">
                    <div class="space-y-2">
                        <i class='bx bx-cloud-upload text-5xl text-blue-400 group-hover:scale-110 transition-transform'></i>
                        <p class="text-sm text-gray-500 font-medium">Click or Drag file here</p>
                        <p class="text-xs text-gray-400">PDF, DOCX, XLSX, JPG</p>
                    </div>
                    <p id="fileNameDisplay" class="text-sm text-blue-600 mt-4 font-semibold break-all"></p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUploadModal()" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-500/30 font-medium transition-colors">Upload File</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('fileNameDisplay').innerText = "";
        }
        function updateFileName(input) {
            if(input.files && input.files[0]) {
                document.getElementById('fileNameDisplay').innerText = input.files[0].name;
            }
        }

        // --- REAL TIME SEARCH SCRIPT ---
        function filterFiles() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let clearBtn = document.getElementById('clearBtn');
            let fileGrid = document.getElementById('fileGrid');
            let cards = fileGrid.getElementsByClassName('file-item');
            let noResults = document.getElementById('noResults');
            let visibleCount = 0;

            // Toggle Clear Button
            if(filter.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            // Loop and Filter
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

            // Show 'No Results' if all hidden
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