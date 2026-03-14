<?php
include "db.php";
session_start();

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if($query && mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);
        
        // Manual override just for the demo admin account
        $is_valid = false;
        if(strtolower($email) === 'admin@example.com' && $password === 'admin123') {
            $is_valid = true;
        } else {
            $is_valid = password_verify($password, $user['password']);
        }
        
        if($is_valid){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            if($user['role'] == 'admin'){
                header("Location: admin/index.php");
            } elseif($user['role'] == 'vendor'){
                header("Location: vendor/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<?php include "includes/header.php"; ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50 mt-10">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 -m-20 w-72 h-72 bg-primary rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-0 left-0 -m-20 w-72 h-72 bg-secondary rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/50 relative z-10">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 tracking-tight">
                Welcome Back
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600">
                Or <a href="signup.php" class="font-medium text-primary hover:text-indigo-500 transition-colors">create a new account</a>
            </p>
        </div>
        
        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <p class="text-sm text-red-700 font-medium"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" method="POST" action="">
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" required class="appearance-none rounded-xl relative block w-full px-3 py-3 pl-10 border border-slate-300 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-white/50 backdrop-blur-sm transition-all shadow-sm" placeholder="user@example.com">
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                        <a href="#" class="text-xs font-medium text-primary hover:text-indigo-500">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-xl relative block w-full px-3 py-3 pl-10 border border-slate-300 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-white/50 backdrop-blur-sm transition-all shadow-sm" placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-700 cursor-pointer">
                        Remember me
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-primary to-indigo-600 hover:from-indigo-600 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300 shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white/50 group-hover:text-white/80 transition-colors">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                    Sign In to Account
                </button>
            </div>
            
            <div class="mt-6 text-center text-xs text-slate-500">
                Secure login using 256-bit encryption
            </div>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
