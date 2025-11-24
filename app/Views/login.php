<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex max-w-4xl w-full h-[550px]">
        
        <!-- Left Side: Branding (Hidden on mobile) -->
        <div class="hidden md:flex w-1/2 bg-blue-900 relative flex-col justify-center items-center text-center p-12">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
            <!-- Blue Overlay (High Opacity for readability) -->
            <div class="absolute inset-0 bg-blue-900/90"></div>
            
            <!-- Logo & Text Content -->
            <div class="relative z-10 flex flex-col items-center">
                <!-- HCC LOGO -->
                <div class="bg-white/10 p-4 rounded-full mb-6 backdrop-blur-sm shadow-lg border border-white/20">
                    <img src="https://hccp-sms.holycrosscollegepampanga.edu.ph/public/assets/images/logo4.png" 
                         alt="HCC Logo" 
                         class="w-24 h-24 object-contain drop-shadow-md">
                </div>
                
                <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">HCC Drive</h2>
                <div class="w-16 h-1 bg-yellow-400 rounded-full mb-4"></div>
                <p class="text-blue-100 text-sm leading-relaxed max-w-xs">
                    Holy Cross College<br>
                    Official File Management & Collaboration Portal
                </p>
            </div>
            
            <!-- Bottom decorative circles -->
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute bottom-0 right-0 -mb-10 -mr-10 w-40 h-40 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Welcome Back</h3>
                <p class="text-gray-500 text-sm mt-1">Please enter your credentials to access the drive.</p>
            </div>

            <!-- Flash Messages -->
            <?php if(session()->getFlashdata('msg')):?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm text-sm flex items-center">
                    <i class='bx bx-error-circle mr-2 text-lg'></i>
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif;?>
            <?php if(session()->getFlashdata('msg_success')):?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm text-sm flex items-center">
                    <i class='bx bx-check-circle mr-2 text-lg'></i>
                    <?= session()->getFlashdata('msg_success') ?>
                </div>
            <?php endif;?>

            <form action="<?= base_url('/auth/login') ?>" method="post" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5 ml-1">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class='bx bx-envelope text-xl'></i>
                        </span>
                        <input type="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" placeholder="user@hcc.edu.ph" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5 ml-1">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <i class='bx bx-lock-alt text-xl'></i>
                        </span>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 focus:bg-white" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 rounded-lg transition-all transform hover:scale-[1.01] shadow-lg shadow-blue-500/30 flex justify-center items-center space-x-2">
                        <span>Sign In</span>
                        <i class='bx bx-right-arrow-alt text-xl'></i>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500">Need an account? <a href="<?= base_url('/register') ?>" class="text-blue-600 font-semibold hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

    <!-- Animation Keyframes for the background blobs -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>