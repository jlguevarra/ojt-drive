<?php $uri = service('uri')->getPath(); ?>

<div class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex">
    <div class="p-6 flex items-center space-x-2">
        <div class="bg-green-600 p-2 rounded-lg">
            <i class='bx bxs-folder text-white text-xl'></i>
        </div>
        <span class="text-xl font-bold text-gray-800">HCC Drive</span>
    </div>

    <div class="px-4 mb-6">
        <div class="w-full flex items-center justify-center space-x-2 bg-gray-100 text-gray-500 py-3 rounded-full font-medium cursor-default">
            <i class='bx bx-lock-alt text-xl'></i>
            <span>Read Only Mode</span>
        </div>
    </div>

    <nav class="flex-1 space-y-1 px-2">
        <!-- Dashboard Link -->
        <?php $isActive = (strpos($uri, 'dashboard') !== false); ?>
        <a href="<?= base_url('faculty/dashboard') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= $isActive ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100' ?>">
            <i class='bx bx-home-alt text-xl'></i>
            <span>Shared Files</span>
        </a>

        <!-- Settings Link -->
        <?php $isActive = (strpos($uri, 'settings') !== false); ?>
        <a href="<?= base_url('settings') ?>" class="flex items-center space-x-3 w-full px-4 py-2 rounded-r-full font-medium transition-colors <?= $isActive ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100' ?>">
            <i class='bx bx-cog text-xl'></i>
            <span>Settings</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-200">
        <div class="bg-green-50 rounded-lg p-3">
            <p class="text-xs text-green-600 font-medium mb-1">Account Type</p>
            <p class="text-xs text-gray-500">Faculty Access</p>
        </div>
    </div>
</div>