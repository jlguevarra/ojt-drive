<?php $uri = service('uri')->getPath(); ?>

<div class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex">
    <div class="p-6 flex items-center space-x-2">
        <div class="bg-blue-600 p-2 rounded-lg">
            <i class='bx bxs-folder text-white text-xl'></i>
        </div>
        <span class="text-xl font-bold text-gray-800">HCC Drive</span>
    </div>

    <!-- Upload Button (Only shows on Dashboard) -->
    <?php if(strpos($uri, 'dashboard') !== false): ?>
    <div class="px-4 mb-6">
        <button onclick="openUploadModal()" class="w-full flex items-center justify-center space-x-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-full shadow-sm transition-all font-medium">
            <i class='bx bx-upload text-xl'></i>
            <span>New Upload</span>
        </button>
    </div>
    <?php else: ?>
    <div class="px-4 mb-6">
        <a href="<?= base_url('admin/dashboard') ?>" class="w-full flex items-center justify-center space-x-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-full shadow-sm transition-all font-medium">
            <i class='bx bx-arrow-back text-xl'></i>
            <span>Back to Drive</span>
        </a>
    </div>
    <?php endif; ?>

    <nav class="flex-1 space-y-1 px-2">
        <!-- Dashboard Link -->
        <?php $isActive = (strpos($uri, 'dashboard') !== false); ?>
        <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= $isActive ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
            <i class='bx bx-home-alt text-xl'></i>
            <span>My Drive</span>
        </a>

        <!-- Shared Link -->
        <a href="#" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full text-gray-600 hover:bg-gray-100 font-medium">
            <i class='bx bx-group text-xl'></i>
            <span>Shared with me</span>
        </a>
        
        <div class="border-t border-gray-100 my-4 pt-4"></div>
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin Panel</p>
        
        <!-- Manage Users Link -->
        <?php $isActive = (strpos($uri, 'users') !== false); ?>
        <a href="<?= base_url('admin/users') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= $isActive ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
            <i class='bx bx-user text-xl'></i>
            <span>Manage Users</span>
        </a>

        <!-- Settings Link -->
        <?php $isActive = (strpos($uri, 'settings') !== false); ?>
        <a href="<?= base_url('settings') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= $isActive ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
            <i class='bx bx-cog text-xl'></i>
            <span>Settings</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-200">
        <div class="bg-blue-50 rounded-lg p-3">
            <p class="text-xs text-blue-600 font-medium mb-1">Storage Used</p>
            <div class="w-full bg-blue-200 rounded-full h-1.5 mb-2">
                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 45%"></div>
            </div>
            <p class="text-xs text-gray-500">Unlimited Access</p>
        </div>
    </div>
</div>