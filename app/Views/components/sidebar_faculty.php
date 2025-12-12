<?php $uri = service('uri')->getPath(); ?>

<div id="mobileOverlay" onclick="closeMobileSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity duration-300"></div>

<button onclick="openMobileSidebar()" class="fixed top-3 left-4 z-50 md:hidden bg-white p-2 rounded-lg shadow-md text-gray-600 focus:outline-none">
    <i class='bx bx-menu text-2xl'></i>
</button>

<div id="sidebar" class="bg-white border-r border-gray-200 flex flex-col 
            fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full transition-all duration-300 ease-in-out
            md:relative md:translate-x-0 md:flex">
    
    <button id="sidebarToggle" class="hidden md:flex absolute -right-3 top-9 bg-white border border-gray-200 text-gray-500 rounded-full p-1 shadow-sm hover:text-green-600 hover:bg-gray-50 transition-colors z-50 focus:outline-none">
        <i class='bx bx-chevron-left text-xl' id="toggleIcon"></i>
    </button>

    <div class="p-6 flex items-center space-x-3 overflow-hidden h-20 flex-shrink-0">
        <div class="bg-green-600 p-2 rounded-lg flex-shrink-0">
            <i class='bx bxs-folder text-white text-xl'></i>
        </div>
        <span class="text-xl font-bold text-gray-800 whitespace-nowrap sidebar-text transition-opacity duration-300">HCC Drive</span>
        <button onclick="closeMobileSidebar()" class="md:hidden ml-auto text-gray-500"><i class='bx bx-x text-2xl'></i></button>
    </div>

    <nav class="flex-1 space-y-1 px-3 mt-4 overflow-y-auto overflow-x-hidden scrollbar-hide">
        <?php 
        function navItem($url, $icon, $label, $currentUri) {
            $isActive = (strpos($currentUri, $url) !== false);
            $activeClass = $isActive ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100';
            $baseUrl = base_url($url);
            
            return "
            <a href='{$baseUrl}' class='group flex items-center px-3 py-2.5 mb-1 rounded-lg font-medium transition-all duration-200 {$activeClass}' title='{$label}'>
                <i class='bx {$icon} text-xl flex-shrink-0'></i>
                <span class='ml-3 sidebar-text whitespace-nowrap transition-opacity duration-300'>{$label}</span>
                <div class='absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none hidden sidebar-tooltip z-50 whitespace-nowrap'>
                    {$label}
                </div>
            </a>";
        }
        ?>
        <?= navItem('faculty/dashboard', 'bx-home-alt', 'Shared Files', $uri) ?>
    </nav>

    <div class="p-3 border-t border-gray-200 mt-auto">
        <?= navItem('settings', 'bx-cog', 'Settings', $uri) ?>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobileOverlay');

        function openMobileSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeMobileSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            const texts = document.querySelectorAll('.sidebar-text');
            const tooltips = document.querySelectorAll('.sidebar-tooltip');
            
            function applyState(collapsed) {
                if (window.innerWidth >= 768) {
                    if (collapsed) {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-20');
                        toggleIcon.classList.remove('bx-chevron-left');
                        toggleIcon.classList.add('bx-chevron-right');
                        texts.forEach(t => t.classList.add('hidden'));
                        tooltips.forEach(t => t.classList.remove('hidden'));
                    } else {
                        sidebar.classList.add('w-64');
                        sidebar.classList.remove('w-20');
                        toggleIcon.classList.add('bx-chevron-left');
                        toggleIcon.classList.remove('bx-chevron-right');
                        texts.forEach(t => t.classList.remove('hidden'));
                        tooltips.forEach(t => t.classList.add('hidden'));
                    }
                }
            }

            const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
            applyState(isCollapsed);

            toggleBtn.addEventListener('click', () => {
                const currentlyCollapsed = sidebar.classList.contains('w-20');
                const newState = !currentlyCollapsed;
                applyState(newState);
                localStorage.setItem('sidebar_collapsed', newState);
            });
        });
    </script>
</div>