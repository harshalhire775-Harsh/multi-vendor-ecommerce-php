<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['password'];
    
    if(!empty($password)){
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name=?, password=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $hashed, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $user_id);
    }
    
    if($stmt->execute()){
        $_SESSION['user_name'] = $name;
        $success = "Profile updated successfully!";
    }
}

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));
?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24 relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="mb-12 border-b border-slate-200 pb-6 flex items-center mb-10">
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">My Profile</h1>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
            
            <div class="h-32 bg-gradient-to-r from-primary to-secondary relative">
                <!-- Avatar -->
                <div class="absolute -bottom-12 left-10">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&size=128&background=fff&color=0f172a" class="w-24 h-24 rounded-full border-4 border-white shadow-xl">
                </div>
            </div>
            
            <div class="pt-16 p-8 md:p-10">
                
                <?php if($success): ?>
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg mb-8 flex items-center shadow-sm">
                        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
                        <p class="text-sm text-emerald-700 font-medium"><?php echo $success; ?></p>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    
                    <div class="col-span-1 border-r border-slate-100 pr-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-6">Account Details</h2>
                        <ul class="space-y-4 text-sm text-slate-600 font-medium">
                            <li class="flex items-center"><i class="fas fa-envelope w-6 text-primary"></i> <?php echo htmlspecialchars($user['email']); ?></li>
                            <li class="flex items-center"><i class="fas fa-calendar-alt w-6 text-primary"></i> Joined <?php echo date('M Y', strtotime($user['created_at'])); ?></li>
                            <li class="flex items-center"><i class="fas fa-shield-alt w-6 text-primary"></i> Role: <span class="uppercase tracking-widest text-[10px] ml-2 px-2 py-0.5 bg-slate-100 rounded-md"><?php echo htmlspecialchars($user['role']); ?></span></li>
                        </ul>
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <h2 class="text-xl font-bold text-slate-800 mb-6">Update Information</h2>
                        
                        <form method="POST" action="" class="space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Full Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-inner">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">New Password</label>
                                <input type="password" name="password" placeholder="Leave blank to keep current password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-inner">
                            </div>
                            
                            <button type="submit" class="bg-primary hover:bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm flex items-center space-x-2">
                                <i class="fas fa-save"></i> <span>Save Changes</span>
                            </button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
