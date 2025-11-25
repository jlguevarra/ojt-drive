<?php $uri = service('uri')->getPath(); ?>

<div class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex">
    <!-- Header -->
    <div class="p-6 flex items-center space-x-2">
        <div class="bg-green-600 p-2 rounded-lg">
            <i class='bx bxs-folder text-white text-xl'></i>
        </div>
        <span class="text-xl font-bold text-gray-800">HCC Drive</span>
    </div>

    <!-- Navigation Menu (Added margin-top since 'Read Only' is gone) -->
    <nav class="flex-1 space-y-1 px-2 mt-4">
        <!-- Shared Files Link -->
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
    
    <!-- Footer Removed -->
</div>