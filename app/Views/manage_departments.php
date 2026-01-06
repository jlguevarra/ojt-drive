<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments - HCC Drive</title>
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

        /* Fade out animation for alerts */
        .fade-out {
            animation: fadeOut 0.5s ease-in-out forwards;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; display: none; }
        }

        /* Autofill Fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover, 
        .dark input:-webkit-autofill:focus, 
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #374151 inset !important;
            -webkit-text-fill-color: white !important;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Departments</h1>
            
            <div class="flex items-center space-x-4">
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
                <button onclick="openLogoutModal()" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors" title="Logout">
                    <i class='bx bx-log-out text-2xl'></i>
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            
            <div id="alert-container">
                <?php if(session()->getFlashdata('success')):?>
                    <div class="alert-toast bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 flex justify-between items-center transition-all duration-500" role="alert">
                        <div class="flex items-center">
                            <i class='bx bxs-check-circle mr-2 text-xl'></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100 font-bold ml-4 text-xl leading-none focus:outline-none">&times;</button>
                    </div>
                <?php endif;?>
                
                <?php if(session()->getFlashdata('error')):?>
                    <div class="alert-toast bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4 flex justify-between items-center transition-all duration-500" role="alert">
                        <div class="flex items-center">
                            <i class='bx bxs-error-circle mr-2 text-xl'></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100 font-bold ml-4 text-xl leading-none focus:outline-none">&times;</button>
                    </div>
                <?php endif;?>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">School Departments</h2>
                
                <div class="flex flex-1 justify-end items-center gap-3 w-full md:w-auto">
                    <div class="relative max-w-sm w-full">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-search text-gray-400 text-xl'></i>
                        </span>
                        <input type="text" id="deptSearch" onkeyup="filterDepartments()" placeholder="Search code or name..." 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition-colors shadow-sm">
                    </div>

                    <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center transition-colors whitespace-nowrap">
                        <i class='bx bx-plus mr-2 text-xl'></i> Add Department
                    </button>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Description / Name</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="deptTableBody">
                        <?php if(!empty($departments)): foreach($departments as $dept): ?>
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors dept-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 dept-code">
                                    <?= esc($dept['code']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium dept-name"><?= esc($dept['name']) ?></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick='openEdit(<?= json_encode($dept) ?>)' class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-gray-700 p-2 rounded hover:bg-blue-100 dark:hover:bg-gray-600 transition-colors"><i class='bx bx-edit'></i></button>
                                <a href="<?= base_url('departments/delete/'.$dept['id']) ?>" onclick="return confirm('Delete this department?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-gray-700 p-2 rounded hover:bg-red-100 dark:hover:bg-gray-600 transition-colors"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No departments found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                <?= $pager->links() ?>
            </div>

        </main>
    </div>

    <div id="createModal" class="fixed inset-0 bg-gray-900 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 transition-colors duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Add Department</h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('departments/create') ?>" method="post" class="space-y-4" id="createForm">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department Code</label>
                    <input type="text" name="code" placeholder="e.g. SCITE" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none uppercase dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name / Description</label>
                    <input type="text" name="name" placeholder="e.g. School of Computing..." required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>
                <button type="submit" id="createBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors opacity-50 cursor-not-allowed" disabled>Save Department</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-900 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 transition-colors duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Department</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('departments/update') ?>" method="post" class="space-y-4" id="editForm">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department Code</label>
                    <input type="text" name="code" id="edit_code" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none uppercase dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name / Description</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>
                <button type="submit" id="editBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors opacity-50 cursor-not-allowed" disabled>Update Department</button>
            </form>
        </div>
    </div>

    <div id="logoutModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-sm">
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
        // --- ALERT AUTO DISMISS SCRIPT ---
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-toast');
                alerts.forEach(function(alert) {
                    alert.classList.add('fade-out');
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // --- SEARCH FUNCTIONALITY ---
        function filterDepartments() {
            let input = document.getElementById('deptSearch');
            let filter = input.value.toLowerCase();
            let rows = document.getElementsByClassName('dept-row');

            for (let i = 0; i < rows.length; i++) {
                let code = rows[i].querySelector('.dept-code').textContent.toLowerCase();
                let name = rows[i].querySelector('.dept-name').textContent.toLowerCase();
                
                if (code.indexOf(filter) > -1 || name.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // --- FORM VALIDATION (CREATE) ---
        function checkCreateForm() {
            const form = document.getElementById('createForm');
            const btn = document.getElementById('createBtn');
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            inputs.forEach(input => { if(!input.value.trim()) valid = false; });

            if(valid) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        const createForm = document.getElementById('createForm');
        createForm.addEventListener('input', checkCreateForm);

        // --- FORM VALIDATION (EDIT) ---
        let originalDept = {};
        function checkEditForm() {
            const btn = document.getElementById('editBtn');
            const code = document.getElementById('edit_code').value.trim();
            const name = document.getElementById('edit_name').value.trim();

            let isValid = code && name;
            let hasChanges = (code !== originalDept.code || name !== originalDept.name);

            if(isValid && hasChanges) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        const editForm = document.getElementById('editForm');
        editForm.addEventListener('input', checkEditForm);

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createForm').reset();
            checkCreateForm();
        }

        function openEdit(dept) {
            document.getElementById('edit_id').value = dept.id;
            document.getElementById('edit_code').value = dept.code;
            document.getElementById('edit_name').value = dept.name;
            
            originalDept = { code: dept.code, name: dept.name };
            
            document.getElementById('editModal').classList.remove('hidden');
            checkEditForm();
        }

        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>
</body>
</html>