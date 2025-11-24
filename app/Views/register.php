<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HCC Drive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex max-w-4xl w-full h-[550px]">
        
        <!-- Left Side: Branding -->
        <!-- Changed bg-purple to bg-amber (Gold) -->
        <div class="hidden md:flex w-1/2 bg-amber-600 relative flex-col justify-center items-center text-center p-12">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
            <!-- Gold/Amber Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-amber-600 to-yellow-700 opacity-90"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <!-- HCC LOGO -->
                <div class="bg-white/20 p-4 rounded-full mb-6 backdrop-blur-sm shadow-lg border border-white/30">
                    <img src="https://hccp-sms.holycrosscollegepampanga.edu.ph/public/assets/images/logo4.png" 
                         alt="HCC Logo" 
                         class="w-24 h-24 object-contain drop-shadow-md">
                </div>

                <h2 class="text-3xl font-bold text-white mb-2 drop-shadow-sm">Join HCC Drive</h2>
                <div class="w-16 h-1 bg-white rounded-full mb-4 shadow-sm"></div>
                <p class="text-yellow-50 text-sm leading-relaxed max-w-xs font-medium">
                    Create your faculty account to start sharing resources with your department.
                </p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Create Account</h3>
                <p class="text-gray-500 text-sm mt-1">Enter your details to register.</p>
            </div>

            <?php if(isset($validation)):?>
                <div class="bg-red-50 text-red-600 p-3 rounded text-sm mb-4 border border-red-200 flex items-start">
                    <i class='bx bx-error-circle mr-2 mt-0.5'></i>
                    <div><?= $validation->listErrors() ?></div>
                </div>
            <?php endif;?>

            <form action="<?= base_url('/auth/store') ?>" method="post" class="space-y-4">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1 ml-1">Full Name</label>
                    <div class="relative group">
                        <!-- Changed focus color to yellow/amber -->
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-amber-600 transition-colors">
                            <i class='bx bx-user text-xl'></i>
                        </span>
                        <input type="text" name="username" value="<?= set_value('username') ?>" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-gray-50 focus:bg-white" placeholder="Juan Dela Cruz" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1 ml-1">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-amber-600 transition-colors">
                            <i class='bx bx-envelope text-xl'></i>
                        </span>
                        <input type="email" name="email" value="<?= set_value('email') ?>" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-gray-50 focus:bg-white" placeholder="faculty@hcc.edu.ph" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1 ml-1">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-amber-600 transition-colors">
                            <i class='bx bx-lock-alt text-xl'></i>
                        </span>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-gray-50 focus:bg-white" placeholder="Minimum 6 characters" required>
                    </div>
                </div>

                <div class="pt-2">
                    <!-- Gold Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white font-bold py-3 rounded-lg transition-all transform hover:scale-[1.01] shadow-lg shadow-amber-500/30 flex justify-center items-center space-x-2">
                        <span>Sign Up</span>
                        <i class='bx bx-user-plus text-xl'></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center border-t border-gray-100 pt-4">
                <p class="text-sm text-gray-500">Already have an account? <a href="<?= base_url('/login') ?>" class="text-amber-600 font-bold hover:underline hover:text-amber-700">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>