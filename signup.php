<?php
include "db.php";
session_start();

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = isset($_GET['role']) && $_GET['role'] == 'vendor' ? 'vendor' : 'customer';

    if($password !== $confirm_password){
        $error = "Passwords do not match.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed', '$role')";
            
            if(mysqli_query($conn, $query)){
                $user_id = mysqli_insert_id($conn);
                
                if($role == 'vendor'){
                    mysqli_query($conn, "INSERT INTO vendors (user_id, name, status) VALUES ('$user_id', '$name', 'pending')");
                    $success = "Registration successful! Your vendor account is pending approval.";
                } else {
                    $success = "Registration successful! You can now login.";
                }
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>
<?php include "includes/header.php"; ?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50 mt-10">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 -m-20 w-72 h-72 bg-secondary rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob"></div>
    <div class="absolute bottom-0 right-0 -m-20 w-72 h-72 bg-primary rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob animation-delay-2000"></div>

    <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/50 relative z-10">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 tracking-tight">
                <?php echo isset($_GET['role']) && $_GET['role'] == 'vendor' ? 'Become a Vendor' : 'Create an Account'; ?>
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600">
                Already have an account? <a href="login.php" class="font-medium text-primary hover:text-indigo-500 transition-colors">Sign in</a>
            </p>
        </div>
        
        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <p class="text-sm text-red-700 font-medium"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="bg-green-50 border-l-4 border-emerald-500 p-4 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                <p class="text-sm text-emerald-700 font-medium"><?php echo $success; ?> <a href="login.php" class="underline font-bold">Login here</a>.</p>
            </div>
        <?php else: ?>

        <form class="mt-8 space-y-6" method="POST" action="">
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400"></i>
                        </div>
                        <input id="name" name="name" type="text" required class="appearance-none rounded-xl relative block w-full px-3 py-3 pl-10 border border-slate-300 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-white/50 backdrop-blur-sm transition-all shadow-sm" placeholder="John Doe">
                    </div>
                </div>

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
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required class="appearance-none rounded-xl relative block w-full px-3 py-3 pl-10 border border-slate-300 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-white/50 backdrop-blur-sm transition-all shadow-sm" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-slate-400"></i>
                        </div>
                        <input id="confirm_password" name="confirm_password" type="password" required class="appearance-none rounded-xl relative block w-full px-3 py-3 pl-10 border border-slate-300 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-white/50 backdrop-blur-sm transition-all shadow-sm" placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-primary to-indigo-600 hover:from-indigo-600 hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300 shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white/50 group-hover:text-white/80 transition-colors">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Sign Up
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
