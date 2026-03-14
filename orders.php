<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">My Orders</h1>
                <p class="text-slate-500 mt-2 font-medium">View and track your recent purchases.</p>
            </div>
            <a href="index.php" class="hidden md:flex px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">Back to Store</a>
        </div>

        <?php if(mysqli_num_rows($query) > 0): ?>
            <div class="space-y-8 max-w-5xl mx-auto">
                <?php while($order = mysqli_fetch_assoc($query)): 
                    $order_id = $order['id'];
                    $items_query = mysqli_query($conn, "SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
                    
                    $statusColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                    $icon = 'fa-clock';
                    if($order['status'] == 'completed') { $statusColor = 'bg-emerald-100 text-emerald-700 border-emerald-200'; $icon = 'fa-check-circle'; }
                    if($order['status'] == 'processing') { $statusColor = 'bg-blue-100 text-blue-700 border-blue-200'; $icon = 'fa-box'; }
                    if($order['status'] == 'cancelled') { $statusColor = 'bg-rose-100 text-rose-700 border-rose-200'; $icon = 'fa-times-circle'; }
                ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden transform hover:shadow-lg transition-all">
                    
                    <!-- Order Header -->
                    <div class="bg-slate-50 border-b border-slate-200 p-6 sm:px-8 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex gap-8">
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Order Placed</p>
                                <p class="text-slate-900 font-bold"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Total Amount</p>
                                <p class="text-slate-900 font-bold">$<?php echo number_format($order['total_amount'], 2); ?></p>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Order Number</p>
                                <p class="text-slate-900 font-bold">#<?php echo str_pad($order['id'], 6, "0", STR_PAD_LEFT); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 w-full sm:w-auto justify-between sm:justify-end">
                            <span class="px-4 py-1.5 rounded-full border shadow-sm text-xs font-bold uppercase tracking-widest flex items-center <?php echo $statusColor; ?>">
                                <i class="fas <?php echo $icon; ?> mr-2"></i> <?php echo htmlspecialchars($order['status']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="p-6 sm:px-8 divide-y divide-slate-100">
                        <?php while($item = mysqli_fetch_assoc($items_query)): 
                            $img = $item['image'] ? (strpos($item['image'], 'http') === 0 ? $item['image'] : 'uploads/'.$item['image']) : 'https://placehold.co/100x100/f1f5f9/94a3b8?text=Image';
                        ?>
                        <div class="py-6 flex flex-col sm:flex-row items-start first:pt-0 last:pb-0 group">
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-24 h-24 sm:w-20 sm:h-20 rounded-xl object-contain p-2 mix-blend-multiply bg-slate-50 border border-slate-100 mb-4 sm:mb-0 shrink-0">
                            
                            <div class="sm:ml-6 flex-1 w-full">
                                <div class="flex flex-col sm:flex-row justify-between w-full">
                                    <h4 class="text-lg font-bold text-slate-900 hover:text-primary transition-colors pr-4 mb-2 sm:mb-0">
                                        <a href="product.php?id=<?php echo $item['product_id']; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                                    </h4>
                                    <p class="font-black text-slate-900 text-lg sm:text-base whitespace-nowrap">$<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                                
                                <div class="flex justify-between items-end mt-4">
                                    <p class="text-slate-500 font-medium">Qty: <span class="text-slate-800 font-bold font-mono bg-slate-100 px-2 py-0.5 rounded ml-1"><?php echo $item['quantity']; ?></span></p>
                                    
                                    <div class="flex space-x-3">
                                        <button class="text-primary hover:text-indigo-700 font-bold text-sm bg-indigo-50 px-4 py-2 rounded-lg transition-colors flex items-center">
                                            <i class="fas fa-undo mr-2 text-xs"></i> Return
                                        </button>
                                        <a href="product.php?id=<?php echo $item['product_id']; ?>" class="text-slate-700 hover:text-white hover:bg-slate-900 font-bold text-sm bg-slate-100 border border-slate-200 px-4 py-2 rounded-lg transition-all shadow-sm">
                                            Buy Again
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-slate-100 max-w-2xl mx-auto border-dashed">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-box-open text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">No orders found</h2>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">You haven't placed any orders yet. Start exploring our stunning collection.</p>
                <a href="index.php" class="px-8 py-4 bg-gradient-to-r from-primary to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-1 transition-all">Start Shopping</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include "includes/footer.php"; ?>
