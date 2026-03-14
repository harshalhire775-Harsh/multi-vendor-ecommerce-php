<?php
include "../db.php";
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'vendor'){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$vendor_query = mysqli_query($conn, "SELECT id, status FROM vendors WHERE user_id = $user_id");
$vendor = mysqli_fetch_assoc($vendor_query);
$vendor_id = $vendor['id'];
$vendor_status = $vendor['status'];

$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cx FROM products WHERE vendor_id=$vendor_id"))['cx'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT oi.order_id) as cx FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE p.vendor_id=$vendor_id"))['cx'];
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(oi.price * oi.quantity) as rev FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE p.vendor_id=$vendor_id AND o.status='completed'"))['rev'] ?: 0;

$recent_orders = mysqli_query($conn, "SELECT oi.*, o.created_at, o.status, p.name as product_name, p.image FROM order_items oi JOIN orders o ON oi.order_id = o.id JOIN products p ON oi.product_id = p.id WHERE p.vendor_id = $vendor_id ORDER BY o.created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard | LuxeStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col transition-all duration-300">
        <div class="h-20 flex items-center px-8 border-b border-slate-800">
            <a href="../index.php" class="text-2xl font-bold text-white tracking-tight">Vendor<span class="text-secondary">Hub</span></a>
        </div>
        
        <div class="p-6">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Store Management</p>
            <nav class="space-y-2">
                <a href="index.php" class="flex items-center space-x-3 text-white bg-rose-600 px-4 py-3 rounded-lg shadow-lg shadow-rose-500/30 transition-all font-medium">
                    <i class="fas fa-home w-5"></i><span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-box w-5"></i><span>My Products</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-clipboard-list w-5"></i><span>Order History</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-3 rounded-lg transition-all font-medium">
                    <i class="fas fa-chart-bar w-5"></i><span>Sales Reports</span>
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
                <button class="text-slate-500 hover:text-rose-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-6">
                <a href="../index.php" class="text-sm font-bold text-slate-500 hover:text-rose-600 flex items-center"><i class="fas fa-external-link-alt mr-2"></i> Visit Store</a>
                <div class="flex items-center space-x-3 cursor-pointer pl-6 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=f43f5e&color=fff" alt="Vendor" class="w-10 h-10 rounded-full shadow-sm border-2 border-slate-100">
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-emerald-500"><i class="fas fa-circle text-[8px] mr-1"></i> Online</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
            
            <?php if($vendor_status == 'pending'): ?>
                <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-2xl mb-8 flex items-center shadow-lg shadow-amber-100/50">
                    <i class="fas fa-clock text-amber-500 text-3xl mr-4 drop-shadow-sm"></i>
                    <div>
                        <h3 class="text-amber-800 font-bold text-lg mb-1">Account under review</h3>
                        <p class="text-sm text-amber-700 font-medium">Your vendor application is currently being reviewed by our team. Features are limited until approval.</p>
                    </div>
                </div>
            <?php elseif($vendor_status == 'rejected'): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl mb-8 flex items-center shadow-lg">
                    <i class="fas fa-times-circle text-red-500 text-3xl mr-4 drop-shadow-sm"></i>
                    <div>
                        <h3 class="text-red-800 font-bold text-lg mb-1">Application Rejected</h3>
                        <p class="text-sm text-red-700 font-medium">Unfortunately, your application to become a vendor was not approved. Please contact support.</p>
                    </div>
                </div>
            <?php else: ?>

                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Vendor Dashboard</h1>
                        <p class="text-slate-500 mt-1 font-medium">Manage your products, track sales, and grow your business.</p>
                    </div>
                    <button class="px-5 py-2.5 bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-200 hover:bg-rose-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-plus"></i> <span>Add Product</span>
                    </button>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div class="w-16 h-16 rounded-[1.25rem] bg-rose-50 text-rose-500 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-wallet"></i></div>
                        <div class="ml-5">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Sales</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-1">$<?php echo number_format($revenue, 2); ?></h3>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div class="w-16 h-16 rounded-[1.25rem] bg-indigo-50 text-indigo-500 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-box-open"></i></div>
                        <div class="ml-5">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">My Products</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-1"><?php echo $product_count; ?></h3>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div class="w-16 h-16 rounded-[1.25rem] bg-emerald-50 text-emerald-500 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform"><i class="fas fa-shopping-bag"></i></div>
                        <div class="ml-5">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Orders</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-1"><?php echo $order_count; ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-8">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-900">Recent Sales Activity</h2>
                        <a href="#" class="text-sm font-bold text-rose-600 hover:text-rose-800 transition-colors">View All</a>
                    </div>
                    
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 border-b border-slate-100">Product</th>
                                    <th class="px-6 py-4 border-b border-slate-100 text-center">Qty</th>
                                    <th class="px-6 py-4 border-b border-slate-100">Date</th>
                                    <th class="px-6 py-4 border-b border-slate-100 text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium">
                                <?php if(mysqli_num_rows($recent_orders) > 0): ?>
                                    <?php while($order = mysqli_fetch_assoc($recent_orders)): 
                                        $img = $order['image'] ? (strpos($order['image'], 'http') === 0 ? $order['image'] : '../uploads/'.$order['image']) : 'https://placehold.co/100x100/f1f5f9/94a3b8';
                                    ?>
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4 flex items-center space-x-3">
                                            <img src="<?php echo $img; ?>" alt="Img" class="w-10 h-10 rounded-lg object-cover shadow-sm mix-blend-multiply">
                                            <span class="font-bold text-slate-800 line-clamp-1 max-w-xs block"><?php echo htmlspecialchars($order['product_name']); ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 text-center font-bold bg-slate-50/50 group-hover:bg-white"><?php echo $order['quantity']; ?></td>
                                        <td class="px-6 py-4 text-slate-500"><?php echo date('M d, g:i A', strtotime($order['created_at'])); ?></td>
                                        <td class="px-6 py-4 font-black text-slate-900 text-right text-lg">$<?php echo number_format($order['price'], 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fas fa-inbox text-4xl text-slate-200 mb-3 block"></i>
                                        No sales yet. Share your store link to get started!
                                    </td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            <?php endif; ?>

        </div>
    </main>
</body>
</html>
