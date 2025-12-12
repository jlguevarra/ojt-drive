<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); 
        body { font-family: 'Inter', sans-serif; }

        /* Autofill Fix */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #f9fafb inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .dark input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #374151 inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }
    </style>
    <script>
        // Init Theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        tailwind.config = { darkMode: 'class' };
    </script>
</head>
<body class="bg-slate-100 dark:bg-gray-900 h-screen flex items-center justify-center p-4 transition-colors duration-300">

    <button onclick="toggleTheme()" class="absolute top-6 right-6 p-2 rounded-full bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-yellow-400 hover:scale-110 transition-transform focus:outline-none z-50">
        <i class='bx bxs-sun text-2xl dark:hidden'></i> <i class='bx bxs-moon text-2xl hidden dark:block'></i> </button>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden flex max-w-4xl w-full h-[550px] transition-colors duration-300">
        
        <div class="hidden md:flex w-1/2 bg-blue-900 relative flex-col justify-center items-center text-center p-12">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-blue-900/90"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="bg-white/10 p-4 rounded-full mb-6 backdrop-blur-sm shadow-lg border border-white/20">
                    <img src="https://hccp-sms.holycrosscollegepampanga.edu.ph/public/assets/images/logo4.png" alt="HCC Logo" class="w-24 h-24 object-contain drop-shadow-md">
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">HCC Drive</h2>
                <div class="w-16 h-1 bg-yellow-400 rounded-full mb-4"></div>
                <p class="text-blue-100 text-sm leading-relaxed max-w-xs">Holy Cross College<br>Official File Management & Collaboration Portal</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome Back</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Please enter your credentials to access the drive.</p>
            </div>

            <?php if(session()->getFlashdata('error')):?>
                <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-6 rounded-r shadow-sm text-sm flex items-center">
                    <i class='bx bx-error-circle mr-2 text-lg'></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif;?>
            
            <?php if(session()->getFlashdata('success')):?>
                <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-6 rounded-r shadow-sm text-sm flex items-center">
                    <i class='bx bx-check-circle mr-2 text-lg'></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif;?>

            <form action="<?= base_url('/auth/login') ?>" method="post" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-1.5 ml-1">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400 transition-colors">
                            <i class='bx bx-envelope text-xl'></i>
                        </span>
                        <input type="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600" placeholder="user@hcc.edu.ph" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-1.5 ml-1">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400 transition-colors">
                            <i class='bx bx-lock-alt text-xl'></i>
                        </span>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 rounded-lg transition-all transform hover:scale-[1.01] shadow-lg shadow-blue-500/30 flex justify-center items-center space-x-2">
                        <span>Sign In</span>
                        <i class='bx bx-right-arrow-alt text-xl'></i>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-700 pt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Need an account? <a href="<?= base_url('/register') ?>" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>