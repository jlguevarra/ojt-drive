<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - HCC Drive</title>
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

        /* PAGINATION CSS */
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
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-screen flex overflow-hidden transition-colors duration-300">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center justify-between px-6 pl-14 md:pl-6 shadow-sm z-10 transition-colors duration-300">
            <div class="text-xl font-bold text-gray-800 dark:text-white">Manage Users</div>

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
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 flex items-center">
                    <i class='bx bx-check-circle mr-2 text-xl'></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif;?>
            <?php if(session()->getFlashdata('error')):?>
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4 flex items-center">
                    <i class='bx bx-error-circle mr-2 text-xl'></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif;?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">System Users</h2>
                <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center shadow-md transition-colors">
                    <i class='bx bx-plus mr-2'></i> Add New User
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">User Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Email</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if(!empty($users)): foreach($users as $user): ?>
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold">
                                        <?= substr($user['username'], 0, 1) ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($user['username']) ?></div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">ID: #<?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if(!empty($user['dept_code'])): ?>
                                    <span class="px-2 py-1 text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/30 rounded border border-blue-200 dark:border-blue-800">
                                        <?= esc($user['dept_code']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= esc($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button onclick='openEditModal(<?= json_encode($user) ?>)' class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-gray-700 p-2 rounded hover:bg-blue-100 dark:hover:bg-gray-600 transition-colors"><i class='bx bx-edit'></i></button>
                                <a href="<?= base_url('admin/deleteUser/'.$user['id']) ?>" onclick="return confirm('Delete this user?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-gray-700 p-2 rounded hover:bg-red-100 dark:hover:bg-gray-600 transition-colors"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No users found.</td></tr>
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
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Add New User</h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('admin/createUser') ?>" method="post" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input type="text" name="username" value="<?= old('username') ?>" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <select name="role" id="create_role" onchange="toggleDepartment('create_role', 'create_dept_container')" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                        <option value="faculty" <?= old('role') == 'faculty' ? 'selected' : '' ?>>Faculty</option>
                        <option value="program_chair" <?= old('role') == 'program_chair' ? 'selected' : '' ?>>Program Chair</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select>
                </div>

                <div id="create_dept_container">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" id="create_dept_select" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Department --</option>
                        <?php if(!empty($departments)): foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>><?= $dept['code'] ?> - <?= $dept['name'] ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Required for Faculty and Program Chairs.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors">Create User</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-900 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 transition-colors duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit User</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('admin/updateUser') ?>" method="post" class="space-y-4">
                <input type="hidden" name="user_id" id="edit_user_id" value="<?= old('user_id') ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input type="text" name="username" id="edit_username" value="<?= old('username') ?>" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" id="edit_email" value="<?= old('email') ?>" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <select name="role" id="edit_role" onchange="toggleDepartment('edit_role', 'edit_dept_container')" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                        <option value="faculty" <?= old('role') == 'faculty' ? 'selected' : '' ?>>Faculty</option>
                        <option value="program_chair" <?= old('role') == 'program_chair' ? 'selected' : '' ?>>Program Chair</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select>
                </div>

                <div id="edit_dept_container">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" id="edit_department_id" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Department --</option>
                        <?php if(!empty($departments)): foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>><?= $dept['code'] ?> - <?= $dept['name'] ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors">Update User</button>
            </form>
        </div>
    </div>

    <script>
        function toggleDepartment(roleSelectId, deptContainerId) {
            const role = document.getElementById(roleSelectId).value;
            const container = document.getElementById(deptContainerId);
            const select = container.querySelector('select');
            if (role === 'admin') { container.classList.add('hidden'); } 
            else { container.classList.remove('hidden'); }
        }

        function openCreateModal() { 
            document.getElementById('createModal').classList.remove('hidden');
            toggleDepartment('create_role', 'create_dept_container'); 
        }
        
        function openEditModal(user) {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role;
            document.getElementById('edit_department_id').value = user.department_id || "";
            toggleDepartment('edit_role', 'edit_dept_container');
            document.getElementById('editModal').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php if(session('errors')): ?>
                const oldUserId = "<?= old('user_id') ?>";
                if (oldUserId) {
                    document.getElementById('editModal').classList.remove('hidden');
                    toggleDepartment('edit_role', 'edit_dept_container');
                } else {
                    document.getElementById('createModal').classList.remove('hidden');
                    toggleDepartment('create_role', 'create_dept_container');
                }
            <?php endif; ?>
        });
    </script>
</body>
</html>