<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCC Drive - Admin & Chair</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        // Check theme immediately to prevent flash
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

        /* Notification Fade Out Animation */
        .alert-toast {
            transition: opacity 0.5s ease-out;
            opacity: 1;
        }
        .fade-out {
            opacity: 0;
            pointer-events: none;
        }

        /* --- VIEW MODES CSS --- */
        /* GRID VIEW */
        .view-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        /* LIST VIEW */
        .view-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        /* List View Card Overrides */
        .view-list .item-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 0.75rem 1rem;
            height: auto;
            min-height: 3.5rem;
        }
        .view-list .item-icon {
            font-size: 1.5rem;
            margin-bottom: 0;
            margin-right: 1rem;
        }
        .view-list .item-name {
            margin-top: 0;
            flex: 1;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .view-list .item-meta {
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            width: auto;
            text-align: right;
        }
        .view-list .item-actions {
            position: static;
            opacity: 1;
            margin-left: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        /* Input Autofill Fix */
        input:-webkit-autofill { -webkit-text-fill-color: #111827 !important; transition: background-color 5000s ease-in-out 0s; }
        html.dark input:-webkit-autofill { -webkit-text-fill-color: #ffffff !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 shadow-sm z-20 shrink-0">
            <div class="flex items-center flex-1 max-w-4xl gap-4">
                
                <form id="searchForm" action="<?= base_url('admin/dashboard') ?>" method="get" class="relative w-full max-w-md group">
                    <?php if(!empty($current_folder_id)): ?>
                        <input type="hidden" name="folder_id" value="<?= esc($current_folder_id) ?>">
                    <?php endif; ?>
                    <?php if(!empty($selected_dept)): ?>
                        <input type="hidden" name="dept" value="<?= esc($selected_dept) ?>">
                    <?php endif; ?>
                    
                    <input type="hidden" name="sort" value="<?= esc($sort_by ?? 'date_desc') ?>">

                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400 dark:text-gray-500 text-xl group-focus-within:text-blue-500 transition-colors'></i>
                    </span>
                    
                    <input type="text" name="q" id="searchInput" value="<?= esc($search_term ?? '') ?>" 
                           placeholder="Search current folder..." autocomplete="off"
                           class="block w-full pl-10 pr-10 py-2 border-none rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition-colors text-sm">
                    
                    <button type="button" id="clearSearchBtn" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 cursor-pointer hidden">
                        <i class='bx bx-x-circle text-xl'></i>
                    </button>
                </form>

                <?php if(session()->get('role') === 'admin'): ?>
                <form action="<?= base_url('admin/dashboard') ?>" method="get" class="hidden sm:block">
                    <?php if(!empty($search_term)): ?><input type="hidden" name="q" value="<?= esc($search_term) ?>"><?php endif; ?>
                    <input type="hidden" name="sort" value="<?= esc($sort_by ?? 'date_desc') ?>">
                    <select name="dept" onchange="this.form.submit()" class="bg-gray-100 dark:bg-gray-700 border-none text-gray-700 dark:text-gray-200 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 block w-40 p-2 h-9 cursor-pointer">
                        <option value="">All Departments</option>
                        <?php if(!empty($departments)): foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= (isset($selected_dept) && $selected_dept == $dept['id']) ? 'selected' : '' ?>>
                                <?= $dept['code'] ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </form>
                <?php endif; ?>
            </div>

            <div class="flex items-center space-x-3">
                <button onclick="toggleTheme()" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 transition-colors">
                    <i class='bx bxs-sun text-2xl dark:hidden'></i>
                    <i class='bx bxs-moon text-2xl hidden dark:block'></i>
                </button>
                
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold cursor-default">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <div class="px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 shrink-0 z-10">
            
            <nav class="flex overflow-x-auto w-full md:w-auto" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="<?= base_url('admin/dashboard') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">
                            <i class='bx bxs-home mr-2'></i> My Drive
                        </a>
                    </li>
                    <?php if(!empty($breadcrumbs)): foreach($breadcrumbs as $crumb): ?>
                    <li>
                        <div class="flex items-center">
                            <i class='bx bx-chevron-right text-gray-400 text-xl'></i>
                            <a href="<?= base_url('admin/dashboard?folder_id='.$crumb['id']) ?>" class="ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 md:ml-2">
                                <?= esc($crumb['name']) ?>
                            </a>
                        </div>
                    </li>
                    <?php endforeach; endif; ?>
                </ol>
            </nav>

            <div class="flex items-center gap-2">
                <form action="<?= base_url('admin/dashboard') ?>" method="get">
                    <?php if(!empty($current_folder_id)): ?><input type="hidden" name="folder_id" value="<?= esc($current_folder_id) ?>"><?php endif; ?>
                    <?php if(!empty($search_term)): ?><input type="hidden" name="q" value="<?= esc($search_term) ?>"><?php endif; ?>
                    <?php if(!empty($selected_dept)): ?><input type="hidden" name="dept" value="<?= esc($selected_dept) ?>"><?php endif; ?>
                    
                    <select name="sort" onchange="this.form.submit()" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded-lg focus:ring-blue-500 block p-2 h-10 cursor-pointer shadow-sm">
                        <option value="date_desc" <?= ($sort_by ?? 'date_desc') == 'date_desc' ? 'selected' : '' ?>>Newest First</option>
                        <option value="date_asc" <?= ($sort_by ?? '') == 'date_asc' ? 'selected' : '' ?>>Oldest First</option>
                        <option value="name_asc" <?= ($sort_by ?? '') == 'name_asc' ? 'selected' : '' ?>>A-Z</option>
                        <option value="name_desc" <?= ($sort_by ?? '') == 'name_desc' ? 'selected' : '' ?>>Z-A</option>
                    </select>
                </form>

                <div class="flex bg-gray-200 dark:bg-gray-700 rounded-lg p-1">
                    <button onclick="setView('grid')" id="btnGrid" class="p-1.5 rounded-md hover:bg-white dark:hover:bg-gray-600 shadow-sm transition-all text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-600">
                        <i class='bx bxs-grid-alt text-lg'></i>
                    </button>
                    <button onclick="setView('list')" id="btnList" class="p-1.5 rounded-md hover:bg-white dark:hover:bg-gray-600 text-gray-500 dark:text-gray-400 transition-all">
                        <i class='bx bx-list-ul text-lg'></i>
                    </button>
                </div>

                <button onclick="openFolderModal()" class="h-10 px-3 flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white transition-colors" title="New Folder">
                    <i class='bx bx-folder-plus text-xl mr-1'></i> <span class="text-sm font-medium hidden sm:inline">New Folder</span>
                </button>
                <div class="flex gap-1">
                    <button onclick="openUploadFolderModal()" class="h-10 w-10 flex items-center justify-center bg-indigo-600 rounded-lg hover:bg-indigo-700 text-white shadow-md transition-colors" title="Upload Folder">
                        <i class='bx bx-folder text-xl'></i>
                    </button>
                    <button onclick="openUploadModal()" class="h-10 w-10 flex items-center justify-center bg-blue-600 rounded-lg hover:bg-blue-700 text-white shadow-md transition-colors" title="Upload File">
                        <i class='bx bx-cloud-upload text-xl'></i>
                    </button>
                </div>
            </div>
        </div>

        <main class="flex-1 overflow-y-auto p-6 scroll-smooth bg-white dark:bg-gray-900">
            
            <div id="alert-container">
                <?php if(session()->getFlashdata('success')):?>
                    <div class="alert-toast bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 flex justify-between items-center shadow-md transition-all duration-500">
                        <div class="flex items-center">
                            <i class='bx bxs-check-circle mr-2 text-xl'></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100 font-bold ml-4 text-xl leading-none focus:outline-none">&times;</button>
                    </div>
                <?php endif;?>
                
                <?php if(session()->getFlashdata('error')):?>
                    <div class="alert-toast bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4 flex justify-between items-center shadow-md transition-all duration-500">
                        <div class="flex items-center">
                            <i class='bx bxs-error-circle mr-2 text-xl'></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100 font-bold ml-4 text-xl leading-none focus:outline-none">&times;</button>
                    </div>
                <?php endif;?>
            </div>

            <div id="contentContainer" class="view-grid pb-4">
                
                <?php if(!empty($items)): foreach($items as $item): ?>
                    
                    <?php if($item['type'] === 'folder'): ?>
                        <a href="<?= base_url('admin/dashboard?folder_id='.$item['id']) ?>" class="item-card group bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md transition-all relative">
                            <div class="item-icon text-yellow-500 mb-2 group-hover:scale-110 transition-transform duration-200">
                                <i class='bx bxs-folder text-4xl'></i>
                            </div>
                            
                            <h3 class="item-name text-sm font-medium text-gray-700 dark:text-gray-200 truncate" title="<?= esc($item['name']) ?>">
                                <?= esc($item['name']) ?>
                            </h3>
                            
                            <div class="item-meta mt-1 text-xs text-gray-400 dark:text-gray-500 flex justify-between items-center w-full">
                                <span><?= date('M d, Y', strtotime($item['created_at'])) ?></span>
                                <?php if(session()->get('role') === 'admin' && !empty($item['dept_code'])): ?>
                                    <span class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold border border-gray-200 dark:border-gray-600"><?= esc($item['dept_code']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-actions absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <object>
                                    <a href="<?= base_url('folder/delete/'.$item['id']) ?>" onclick="return confirm('Delete folder?')" class="p-1.5 text-gray-400 hover:text-red-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 block transition-colors">
                                        <i class='bx bx-trash text-lg'></i>
                                    </a>
                                </object>
                            </div>
                        </a>

                    <?php else: ?>
                        <div class="item-card group bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md transition-all relative cursor-default">
                            <div class="item-icon text-blue-500 mb-2 group-hover:scale-110 transition-transform duration-200 cursor-pointer" onclick="openPreview(<?= $item['id'] ?>, '<?= esc($item['name']) ?>')">
                                <i class='bx bxs-file-doc text-4xl'></i>
                            </div>
                            
                            <h3 class="item-name text-sm font-medium text-gray-700 dark:text-gray-200 truncate cursor-pointer hover:text-blue-600 dark:hover:text-blue-400" 
                                onclick="openPreview(<?= $item['id'] ?>, '<?= esc($item['name']) ?>')" title="<?= esc($item['name']) ?>">
                                <?= esc($item['name']) ?>
                            </h3>
                            
                            <div class="item-meta mt-1 text-xs text-gray-400 dark:text-gray-500 flex justify-between items-center w-full">
                                <div class="flex flex-col text-right w-full">
                                    <span><?= esc($item['file_size']) ?></span>
                                    <span class="text-[10px]"><?= date('M d, Y', strtotime($item['created_at'])) ?></span>
                                </div>
                                <?php if(session()->get('role') === 'admin' && !empty($item['dept_code'])): ?>
                                    <span class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold border border-gray-200 dark:border-gray-600 ml-2"><?= esc($item['dept_code']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-actions absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex">
                                <a href="<?= base_url('file/download/'.$item['id']) ?>" class="p-1.5 text-gray-400 hover:text-blue-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Download">
                                    <i class='bx bx-download text-lg'></i>
                                </a>
                                <a href="<?= base_url('file/delete/'.$item['id']) ?>" onclick="return confirm('Delete file?')" class="p-1.5 text-gray-400 hover:text-red-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Delete">
                                    <i class='bx bx-trash text-lg'></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; else: ?>
                    <div class="col-span-full text-center py-20 flex flex-col items-center justify-center">
                        <div class="inline-block p-6 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                            <i class='bx bx-folder-open text-5xl text-gray-300 dark:text-gray-600'></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">It's empty here.</p>
                        <?php if(!empty($search_term)): ?>
                            <p class="text-sm text-gray-400 mt-1">No results found for "<?= esc($search_term) ?>"</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </main>

        <div class="bg-white dark:bg-gray-900 p-4 shrink-0 z-20">
            <div class="flex justify-center">
                <?= isset($pager_links) ? $pager_links : '' ?>
            </div>
        </div>
    </div>

    <div id="folderModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-2xl w-80 transform scale-100 transition-transform">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Create New Folder</h3>
            <form action="<?= base_url('/folder/create') ?>" method="post">
                <input type="hidden" name="parent_id" value="<?= esc($current_folder_id ?? '') ?>">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Folder Name</label>
                    <input type="text" name="folder_name" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white" required autofocus>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('folderModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Create</button>
                </div>
            </form>
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl w-96 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Upload File</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl">&times;</button>
            </div>
            <form action="<?= base_url('/file/upload') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="folder_id" value="<?= esc($current_folder_id ?? '') ?>">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <i class='bx bx-folder-open mr-1 align-middle text-yellow-500'></i>
                    Uploading to: <strong class="dark:text-white"><?= !empty($breadcrumbs) ? esc(end($breadcrumbs)['name']) : 'My Drive' ?></strong>
                </p>
                <div class="mb-6 border-2 border-dashed border-blue-300 dark:border-blue-700 rounded-lg p-8 text-center hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors cursor-pointer relative group">
                    <input type="file" name="userfile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required onchange="updateFileName(this)">
                    <div class="space-y-2">
                        <i class='bx bx-cloud-upload text-5xl text-blue-400 dark:text-blue-500 group-hover:scale-110 transition-transform'></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Click or Drag file here</p>
                    </div>
                    <p id="fileNameDisplay" class="text-sm text-blue-600 dark:text-blue-400 mt-4 font-semibold break-all"></p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUploadModal()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-500/30 font-medium transition-colors">Upload File</button>
                </div>
            </form>
        </div>
    </div>

    <div id="uploadFolderModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl w-96 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Upload Folder</h3>
                <button onclick="closeUploadFolderModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl">&times;</button>
            </div>
            
            <form action="<?= base_url('/file/upload_folder') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="folder_id" value="<?= esc($current_folder_id ?? '') ?>">
                <input type="hidden" name="folder_name" id="detectedFolderName">

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded border border-gray-200 dark:border-gray-600">
                    <i class='bx bx-folder mr-1 align-middle text-indigo-500'></i>
                    Target: <strong class="dark:text-white"><?= !empty($breadcrumbs) ? esc(end($breadcrumbs)['name']) : 'My Drive' ?></strong>
                </p>
                <div class="mb-6 border-2 border-dashed border-indigo-300 dark:border-indigo-700 rounded-lg p-8 text-center hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors cursor-pointer relative group">
                    <input type="file" name="folder_files[]" webkitdirectory directory multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required onchange="updateFolderName(this)">
                    <div class="space-y-2">
                        <i class='bx bx-folder-plus text-5xl text-indigo-400 dark:text-indigo-500 group-hover:scale-110 transition-transform'></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Click or Drag Folder</p>
                    </div>
                    <p id="folderNameDisplay" class="text-sm text-indigo-600 dark:text-indigo-400 mt-4 font-semibold break-all"></p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUploadFolderModal()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 font-medium transition-colors">Upload Folder</button>
                </div>
            </form>
        </div>
    </div>

    <div id="logoutModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-2xl w-80 transform scale-100 transition-transform text-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Confirm Logout</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to sign out?</p>
            <div class="flex justify-center space-x-3">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition-colors">Cancel</button>
                <a href="<?= base_url('/logout') ?>" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium shadow-md shadow-red-500/30 transition-colors">Logout</a>
            </div>
        </div>
    </div>

    <div id="previewModal" class="fixed inset-0 bg-gray-900 bg-opacity-95 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="w-full h-full flex flex-col p-4 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-2 text-white shrink-0">
                <h3 id="previewTitle" class="font-bold truncate text-lg">Preview</h3>
                <div class="flex gap-4">
                    <a id="downloadBtn" href="#" class="flex items-center hover:text-blue-400"><i class='bx bx-download mr-1'></i> Download</a>
                    <button onclick="closePreview()" class="text-2xl hover:text-red-400">&times;</button>
                </div>
            </div>
            <div class="flex-1 bg-gray-100 dark:bg-gray-800 rounded-lg relative flex items-center justify-center overflow-hidden">
                <iframe id="previewFrame" class="w-full h-full border-none bg-white hidden"></iframe>
                <div id="noPreviewMsg" class="text-center hidden">
                    <i class='bx bxs-file-doc text-6xl text-gray-400 mb-4'></i>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Preview Not Available</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">This file type cannot be viewed in the browser.</p>
                </div>
                <div id="previewLoading" class="absolute inset-0 flex items-center justify-center text-gray-500 hidden bg-white dark:bg-gray-900 bg-opacity-90">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- VIEW TOGGLE LOGIC ---
        function setView(type) {
            const container = document.getElementById('contentContainer');
            const btnGrid = document.getElementById('btnGrid');
            const btnList = document.getElementById('btnList');
            
            localStorage.setItem('viewMode', type);

            if (type === 'list') {
                container.classList.remove('view-grid');
                container.classList.add('view-list');
                
                // Highlight List Btn
                btnList.classList.add('bg-white', 'dark:bg-gray-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
                btnList.classList.remove('text-gray-500', 'dark:text-gray-400');
                // Dim Grid Btn
                btnGrid.classList.remove('bg-white', 'dark:bg-gray-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
                btnGrid.classList.add('text-gray-500', 'dark:text-gray-400');
            } else {
                container.classList.add('view-grid');
                container.classList.remove('view-list');
                
                // Highlight Grid Btn
                btnGrid.classList.add('bg-white', 'dark:bg-gray-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
                btnGrid.classList.remove('text-gray-500', 'dark:text-gray-400');
                // Dim List Btn
                btnList.classList.remove('bg-white', 'dark:bg-gray-600', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
                btnList.classList.add('text-gray-500', 'dark:text-gray-400');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedView = localStorage.getItem('viewMode') || 'grid';
            setView(savedView);
            
            // --- ALERT AUTO DISMISS SCRIPT ---
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-toast');
                alerts.forEach(function(alert) {
                    alert.classList.add('fade-out'); // Adds class with CSS transition
                    setTimeout(() => alert.remove(), 500); // Waits for transition then removes
                });
            }, 5000);
        });

        // --- AUTO-SEARCH (SERVER SIDE) ---
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearchBtn');
        let searchTimeout = null;

        searchInput.addEventListener('input', function() {
            // Toggle X button
            if(this.value.length > 0) clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');

            // Debounce submit
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 600); // 600ms delay before reloading
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            document.getElementById('searchForm').submit();
        });

        // Show X button on load if there's a value
        if(searchInput.value.length > 0) clearBtn.classList.remove('hidden');

        // --- MODAL HELPERS ---
        function openUploadModal() { document.getElementById('uploadModal').classList.remove('hidden'); }
        function closeUploadModal() { 
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('fileNameDisplay').innerText = "";
        }
        function updateFileName(input) {
            if(input.files && input.files[0]) document.getElementById('fileNameDisplay').innerText = input.files[0].name;
        }

        function openUploadFolderModal() { document.getElementById('uploadFolderModal').classList.remove('hidden'); }
        function closeUploadFolderModal() { 
            document.getElementById('uploadFolderModal').classList.add('hidden');
            document.getElementById('folderNameDisplay').innerText = "";
        }
        function updateFolderName(input) {
            if(input.files && input.files.length > 0) {
                let fullPath = input.files[0].webkitRelativePath;
                let rootFolder = fullPath.split('/')[0];
                document.getElementById('detectedFolderName').value = rootFolder;
                document.getElementById('folderNameDisplay').innerText = "Folder: " + rootFolder + " (" + input.files.length + " files)";
            }
        }

        function openFolderModal() { 
            document.getElementById('folderModal').classList.remove('hidden'); 
            document.querySelector('#folderModal input[name="folder_name"]').focus();
        }
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }

        function openPreview(id, name) {
            const modal = document.getElementById('previewModal');
            const frame = document.getElementById('previewFrame');
            const noPrev = document.getElementById('noPreviewMsg');
            const load = document.getElementById('previewLoading');
            
            document.getElementById('previewTitle').innerText = name;
            document.getElementById('downloadBtn').href = "<?= base_url('file/download/') ?>" + id;
            
            const ext = name.split('.').pop().toLowerCase();
            const viewable = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt'];

            if(viewable.includes(ext)) {
                noPrev.classList.add('hidden');
                frame.classList.remove('hidden');
                load.classList.remove('hidden');
                frame.src = "<?= base_url('file/preview/') ?>" + id;
                frame.onload = function() { load.classList.add('hidden'); };
            } else {
                frame.classList.add('hidden');
                load.classList.add('hidden');
                noPrev.classList.remove('hidden');
            }
            modal.classList.remove('hidden');
        }
        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
            document.getElementById('previewFrame').src = "";
        }
    </script>
</body>
</html>