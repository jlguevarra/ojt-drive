<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Departments - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <?= view('components/sidebar_admin'); ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="font-semibold text-gray-700">Admin Panel > Departments</div>
            <div class="flex items-center space-x-4 ml-4">
                <span class="text-sm font-medium text-gray-800"><?= session()->get('username') ?></span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <!-- Alerts -->
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('success') ?></div>
            <?php endif;?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Departments</h2>
                <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center">
                    <i class='bx bx-plus mr-2'></i> Add Department
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Description / Name</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($departments as $dept): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-bold text-blue-800"><?= esc($dept['code']) ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= esc($dept['name']) ?></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick='openEdit(<?= json_encode($dept) ?>)' class="text-blue-600 hover:text-blue-900"><i class='bx bx-edit text-xl'></i></button>
                                <a href="<?= base_url('departments/delete/'.$dept['id']) ?>" onclick="return confirm('Delete?')" class="text-red-600 hover:text-red-900"><i class='bx bx-trash text-xl'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- CREATE MODAL -->
    <div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Add Department</h3>
            <form action="<?= base_url('departments/create') ?>" method="post" class="space-y-4">
                <input type="text" name="code" placeholder="Code (e.g. SCITE)" required class="w-full border p-2 rounded">
                <input type="text" name="name" placeholder="Description (e.g. School of Computing...)" required class="w-full border p-2 rounded">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Edit Department</h3>
            <form action="<?= base_url('departments/update') ?>" method="post" class="space-y-4">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="code" id="edit_code" required class="w-full border p-2 rounded">
                <input type="text" name="name" id="edit_name" required class="w-full border p-2 rounded">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(dept) {
            document.getElementById('edit_id').value = dept.id;
            document.getElementById('edit_code').value = dept.code;
            document.getElementById('edit_name').value = dept.name;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
```

### Step 4: Register Department Routes
Add this to `app/Config/Routes.php` inside the Admin group:

```php
// Inside 'admin' group
$routes->get('departments', 'Departments::index');
$routes->post('departments/create', 'Departments::create');
$routes->post('departments/update', 'Departments::update');
$routes->get('departments/delete/(:num)', 'Departments::delete/$1');
```

### Step 5: Update Admin Sidebar
Add the link to the new page in `app/Views/components/sidebar_admin.php` (Under Manage Users):

```php
<!-- ... inside the admin check ... -->
<a href="<?= base_url('admin/departments') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= (strpos($uri, 'departments') !== false) ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
    <i class='bx bx-building-house text-xl'></i>
    <span>Departments</span>
</a>
```

### Step 6: Update Dashboards with NEW Folders
Now we update `admin_dashboard.php` to match the specific folders in your sketch: **201, OBE, Exam, Teaching Materials**.

**Updated `app/Views/admin_dashboard.php` (Main Content Area Only):**

```php
<!-- FOLDERS SECTION -->
<h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Folders</h2>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <!-- 201 File -->
    <div onclick="filterByFolder('201 File')" class="bg-white p-4 rounded-xl border border-gray-200 hover:bg-blue-50 cursor-pointer transition-colors flex items-center space-x-3 group">
        <i class='bx bxs-folder text-yellow-500 text-2xl group-hover:scale-110 transition-transform'></i>
        <span class="text-sm font-medium text-gray-700">201 File</span>
    </div>
    <!-- OBE - Syllabus -->
    <div onclick="filterByFolder('OBE - Syllabus')" class="bg-white p-4 rounded-xl border border-gray-200 hover:bg-blue-50 cursor-pointer transition-colors flex items-center space-x-3 group">
        <i class='bx bxs-folder text-yellow-500 text-2xl group-hover:scale-110 transition-transform'></i>
        <span class="text-sm font-medium text-gray-700">OBE - Syllabus</span>
    </div>
    <!-- Exam -->
    <div onclick="filterByFolder('Exam')" class="bg-white p-4 rounded-xl border border-gray-200 hover:bg-blue-50 cursor-pointer transition-colors flex items-center space-x-3 group">
        <i class='bx bxs-folder text-yellow-500 text-2xl group-hover:scale-110 transition-transform'></i>
        <span class="text-sm font-medium text-gray-700">Exam</span>
    </div>
    <!-- Teaching Materials -->
    <div onclick="filterByFolder('Teaching Materials')" class="bg-white p-4 rounded-xl border border-gray-200 hover:bg-blue-50 cursor-pointer transition-colors flex items-center space-x-3 group">
        <i class='bx bxs-folder text-yellow-500 text-2xl group-hover:scale-110 transition-transform'></i>
        <span class="text-sm font-medium text-gray-700">Teaching Materials</span>
    </div>
</div>

<!-- ... in the UPLOAD MODAL SELECT ... -->
<select name="folder" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    <option value="201 File">201 File</option>
    <option value="OBE - Syllabus">OBE - Syllabus</option>
    <option value="Exam">Exam</option>
    <option value="Teaching Materials">Teaching Materials</option>
</select>