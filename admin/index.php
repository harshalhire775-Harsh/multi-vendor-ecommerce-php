<?php
include "../db.php";
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cx FROM users WHERE role='customer'"))['cx'];
$vendor_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cx FROM users WHERE role='vendor'"))['cx'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cx FROM products"))['cx'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cx FROM orders"))['cx'];
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as rev FROM orders WHERE status='completed'"))['rev'] ?: 0;

$recent_orders = mysqli_query($conn, "SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LuxeStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col transition-all duration-300">
        <div class="h-20 flex items-center px-8 border-b border-slate-800">
            <a href="../index.php" class="text-2xl font-bold text-white tracking-tight">Luxe<span class="text-indigo-500">Admin</span></a>
        </div>
        
        <div class="p-6">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Overview</p>
            <nav class="space-y-2">
                <a href="index.php" class="flex items-center space-x-3 text-white bg-indigo-600 px-4 py-3 rounded-lg shadow-lg shadow-indigo-500/30 transition-all font-medium">
                    <i class="fas fa-home w-5"></i><span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-box w-5"></i><span>Products</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-layer-group w-5"></i><span>Categories</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-shopping-cart w-5"></i><span>Orders</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-users w-5"></i><span>Customers</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-store w-5"></i><span>Vendors</span>
                </a>
            </nav>
        </div>
        
        <div class="mt-auto p-6 border-t border-slate-800">
            <a href="../logout.php" class="flex items-center space-x-3 text-rose-400 hover:text-rose-300 font-medium">
                <i class="fas fa-sign-out-alt w-5"></i><span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Top Header -->
        <header class="h-20 bg-white flex items-center justify-between px-8 border-b border-slate-200 shrink-0 shadow-sm z-10">
            <div class="flex items-center">
                <button class="text-slate-500 hover:text-indigo-600 focus:outline-none focus:text-indigo-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="ml-6 relative border border-slate-200 rounded-full bg-slate-50 flex items-center px-4 py-2">
                    <i class="fas fa-search text-slate-400"></i>
                    <input type="text" placeholder="Search..." class="bg-transparent border-none outline-none pl-3 text-sm flex-1 text-slate-700 placeholder-slate-400">
                </div>
            </div>
            
            <div class="flex items-center space-x-6">
                <button class="relative text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-rose-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center space-x-3 cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" alt="Admin" class="w-10 h-10 rounded-full shadow-sm border-2 border-slate-100">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-slate-800">Admin User</p>
                        <p class="text-xs text-slate-500">Superadmin</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Overview</h1>
                    <p class="text-slate-500 mt-1 font-medium">Welcome back, here's what's happening with your store today.</p>
                </div>
                <button class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                    <i class="fas fa-download"></i> <span>Download Report</span>
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-dollar-sign"></i></div>
                    <div class="ml-5">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Revenue</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">$<?php echo number_format($revenue, 2); ?></h3>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-shopping-cart"></i></div>
                    <div class="ml-5">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Orders</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1"><?php echo $order_count; ?></h3>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-users"></i></div>
                    <div class="ml-5">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Customers</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1"><?php echo $user_count; ?></h3>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-store"></i></div>
                    <div class="ml-5">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Active Vendors</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1"><?php echo $vendor_count; ?></h3>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-900">Recent Transactions</h2>
                    <a href="#" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">View All</a>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 border-b border-slate-100">Order ID</th>
                                <th class="px-6 py-4 border-b border-slate-100">Customer</th>
                                <th class="px-6 py-4 border-b border-slate-100">Date</th>
                                <th class="px-6 py-4 border-b border-slate-100">Amount</th>
                                <th class="px-6 py-4 border-b border-slate-100">Status</th>
                                <th class="px-6 py-4 border-b border-slate-100 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium">
                            <?php if(mysqli_num_rows($recent_orders) > 0): ?>
                                <?php while($order = mysqli_fetch_assoc($recent_orders)): 
                                    $statusColor = 'bg-yellow-100 text-yellow-700';
                                    if($order['status'] == 'completed') $statusColor = 'bg-emerald-100 text-emerald-700';
                                    if($order['status'] == 'processing') $statusColor = 'bg-blue-100 text-blue-700';
                                    if($order['status'] == 'cancelled') $statusColor = 'bg-rose-100 text-rose-700';
                                ?>
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4"><span class="font-bold text-slate-800">#<?php echo str_pad($order['id'], 5, "0", STR_PAD_LEFT); ?></span></td>
                                    <td class="px-6 py-4 text-slate-600"><div class="flex items-center"><i class="fas fa-user-circle text-slate-300 text-lg mr-2"></i> <?php echo htmlspecialchars($order['user_name']); ?></div></td>
                                    <td class="px-6 py-4 text-slate-500"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td class="px-6 py-4 font-bold text-slate-900">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full <?php echo $statusColor; ?>">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1.5 rounded-lg text-xs opacity-0 group-hover:opacity-100 transition-opacity">Details</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No orders found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
