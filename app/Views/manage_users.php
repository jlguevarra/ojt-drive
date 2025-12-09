<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); 
        body { font-family: 'Inter', sans-serif; }
        
        /* Simple styling for CodeIgniter Pagination */
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
        .pagination li a:hover { background-color: #f3f4f6; color: #2563eb; }
        .pagination li.active a, .pagination li.active span {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="text-xl font-bold text-gray-800">Manage Users</div>
            <div class="flex items-center space-x-4 ml-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></p>
                    <p class="text-xs text-gray-500 uppercase"><?= session()->get('role') ?></p>
                </div>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    <?= substr(session()->get('username'), 0, 1) ?>
                </div>
                <a href="<?= base_url('/logout') ?>" class="text-gray-500 hover:text-red-600 transition-colors">
                    <i class='bx bx-log-out text-2xl'></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex items-center"><i class='bx bx-check-circle mr-2 text-xl'></i><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>
            <?php if(session()->getFlashdata('error')):?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex items-center"><i class='bx bx-error-circle mr-2 text-xl'></i><?= session()->getFlashdata('error') ?></div>
            <?php endif;?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">System Users</h2>
                <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center shadow-md transition-colors">
                    <i class='bx bx-plus mr-2'></i> Add New User
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">User Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(!empty($users)): foreach($users as $user): ?>
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                        <?= substr($user['username'], 0, 1) ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= esc($user['username']) ?></div>
                                        <div class="text-xs text-gray-400">ID: #<?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if(!empty($user['dept_code'])): ?>
                                    <span class="px-2 py-1 text-xs font-bold text-blue-700 bg-blue-50 rounded border border-blue-200">
                                        <?= esc($user['dept_code']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button onclick='openEditModal(<?= json_encode($user) ?>)' class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded hover:bg-blue-100 transition-colors"><i class='bx bx-edit'></i></button>
                                <a href="<?= base_url('admin/deleteUser/'.$user['id']) ?>" onclick="return confirm('Delete this user?')" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded hover:bg-red-100 transition-colors"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                <?= $pager->links() ?>
            </div>

        </main>
    </div>

    <div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Add New User</h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('admin/createUser') ?>" method="post" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="username" value="<?= old('username') ?>" required class="w-full border <?= session('errors.username') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.username')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.username') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required class="w-full border <?= session('errors.email') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.email')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.email') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="w-full border <?= session('errors.password') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.password')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="create_role" onchange="toggleDepartment('create_role', 'create_dept_container')" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="faculty" <?= old('role') == 'faculty' ? 'selected' : '' ?>>Faculty</option>
                        <option value="program_chair" <?= old('role') == 'program_chair' ? 'selected' : '' ?>>Program Chair</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select>
                </div>

                <div id="create_dept_container">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" id="create_dept_select" class="w-full border rounded px-3 py-2 bg-gray-50">
                        <option value="">-- Select Department --</option>
                        <?php if(!empty($departments)): foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>><?= $dept['code'] ?> - <?= $dept['name'] ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Required for Faculty and Program Chairs.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors">Create User</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Edit User</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="<?= base_url('admin/updateUser') ?>" method="post" class="space-y-4">
                <input type="hidden" name="user_id" id="edit_user_id" value="<?= old('user_id') ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="username" id="edit_username" value="<?= old('username') ?>" required class="w-full border <?= session('errors.username') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.username')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.username') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="edit_email" value="<?= old('email') ?>" required class="w-full border <?= session('errors.email') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.email')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.email') ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full border <?= session('errors.password') ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                    <?php if(session('errors.password')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="edit_role" onchange="toggleDepartment('edit_role', 'edit_dept_container')" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="faculty" <?= old('role') == 'faculty' ? 'selected' : '' ?>>Faculty</option>
                        <option value="program_chair" <?= old('role') == 'program_chair' ? 'selected' : '' ?>>Program Chair</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select>
                </div>

                <div id="edit_dept_container">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" id="edit_department_id" class="w-full border rounded px-3 py-2 bg-gray-50">
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

            if (role === 'admin') {
                container.classList.add('hidden'); 
            } else {
                container.classList.remove('hidden');
            }
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

        // Logic to keep Modal Open on Validation Error
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