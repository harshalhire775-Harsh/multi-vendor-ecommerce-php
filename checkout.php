<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php?redirect=checkout");
    exit();
}

if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = [];
$total = 0;

$ids = implode(',', array_keys($_SESSION['cart']));
$query = mysqli_query($conn, "SELECT id, price, stock, name FROM products WHERE id IN ($ids)");
while($row = mysqli_fetch_assoc($query)){
    $qty = $_SESSION['cart'][$row['id']];
    if($qty > $row['stock']) {
        // Handle out of stock scenario gracefully
        $qty = $row['stock'];
        $_SESSION['cart'][$row['id']] = $qty;
    }
    $subtotal = $row['price'] * $qty;
    $total += $subtotal;
    $row['qty'] = $qty;
    $cart_items[] = $row;
}
$shipping = 15;
$tax = $total * 0.05;
$final_total = $total + $shipping + $tax;

$success = false;
$order_id = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment_method = $_POST['payment_method'];
    
    // Insert Order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $final_total);
    
    if($stmt->execute()){
        $order_id = $stmt->insert_id;
        
        // Insert Order Items & Update Stock
        foreach($cart_items as $item){
            $item_id = $item['id'];
            $item_qty = $item['qty'];
            $item_price = $item['price'];
            
            $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $item_stmt->bind_param("iiid", $order_id, $item_id, $item_qty, $item_price);
            $item_stmt->execute();
            
            // Deduct Stock
            mysqli_query($conn, "UPDATE products SET stock = stock - $item_qty WHERE id = $item_id");
        }
        
        // Clear Cart
        unset($_SESSION['cart']);
        $success = true;
    }
}
?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if($success): ?>
            <!-- Success Screen -->
            <div class="max-w-3xl mx-auto text-center py-20 bg-white rounded-3xl shadow-xl border border-emerald-100 p-12">
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i class="fas fa-check text-4xl text-emerald-500"></i>
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Order Confirmed!</h1>
                <p class="text-lg text-slate-500 mb-8 max-w-xl mx-auto leading-relaxed">Thank you for your purchase. Your order <span class="font-bold text-primary">#<?php echo str_pad($order_id, 6, "0", STR_PAD_LEFT); ?></span> has been received and is being processed.</p>
                
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="orders.php" class="px-8 py-4 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-indigo-600 transition-colors">View My Orders</a>
                    <a href="index.php" class="px-8 py-4 bg-white text-slate-700 border-2 border-slate-200 font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-colors">Continue Shopping</a>
                </div>
            </div>
            
        <?php else: ?>
        
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-8">Secure Checkout</h1>
            
            <form method="POST" action="" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Billing Details -->
                <div class="lg:col-span-8 space-y-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 sm:p-10">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center mr-3 text-sm">1</span> Shipping Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                                <input type="text" name="name" required value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" required placeholder="+1 (555) 000-0000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Delivery Address</label>
                                <textarea name="address" required rows="3" placeholder="Street address, apartment, suite, unit, etc." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 sm:p-10">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center"><span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center mr-3 text-sm">2</span> Payment Method</h2>
                        
                        <div class="space-y-4">
                            <!-- Stripe / Card Mockup -->
                            <label class="relative flex items-center p-5 border-2 border-primary rounded-xl bg-indigo-50/30 cursor-pointer overflow-hidden group">
                                <input type="radio" name="payment_method" value="card" checked class="form-radio h-5 w-5 text-primary border-slate-300 focus:ring-primary">
                                <div class="ml-4 flex flex-col">
                                    <span class="font-bold text-slate-900">Credit or Debit Card</span>
                                    <span class="text-sm text-slate-500">Safe money transfer using your bank account</span>
                                </div>
                                <div class="absolute right-5 flex -space-x-2">
                                    <i class="fab fa-cc-visa text-3xl text-blue-800 bg-white rounded-md flex"></i>
                                    <i class="fab fa-cc-mastercard text-3xl text-red-600 bg-white rounded-md flex"></i>
                                </div>
                            </label>
                            
                            <label class="relative flex items-center p-5 border-2 border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="radio" name="payment_method" value="paypal" class="form-radio h-5 w-5 text-primary border-slate-300 focus:ring-primary">
                                <div class="ml-4 flex flex-col">
                                    <span class="font-bold text-slate-900">PayPal</span>
                                    <span class="text-sm text-slate-500">You will be redirected to PayPal website</span>
                                </div>
                                <i class="fab fa-paypal absolute right-5 text-3xl text-sky-600"></i>
                            </label>

                            <label class="relative flex items-center p-5 border-2 border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="radio" name="payment_method" value="cod" class="form-radio h-5 w-5 text-primary border-slate-300 focus:ring-primary">
                                <div class="ml-4 flex flex-col">
                                    <span class="font-bold text-slate-900">Cash on Delivery</span>
                                    <span class="text-sm text-slate-500">Pay with cash upon delivery</span>
                                </div>
                                <i class="fas fa-money-bill-wave absolute right-5 text-3xl text-emerald-600"></i>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 sticky top-28">
                        <h3 class="text-xl font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Order Summary</h3>
                        
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            <?php foreach($cart_items as $item): ?>
                            <div class="flex justify-between text-sm">
                                <div class="flex space-x-3">
                                    <span class="font-medium text-slate-500"><?php echo $item['qty']; ?>x</span>
                                    <span class="text-slate-800 line-clamp-1 max-w-[150px] font-medium" title="<?php echo htmlspecialchars($item['name']); ?>"><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                                <span class="font-bold text-slate-900">$<?php echo number_format($item['price'] * $item['qty'], 2); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-6">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-800">$<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="font-bold text-slate-800">$<?php echo number_format($shipping, 2); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Estimated Tax</span>
                                <span class="font-bold text-slate-800">$<?php echo number_format($tax, 2); ?></span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center border-t border-slate-100 mt-6 pt-6 mb-8">
                            <span class="text-lg font-bold text-slate-900">Total</span>
                            <span class="text-3xl font-black text-primary">$<?php echo number_format($final_total, 2); ?></span>
                        </div>
                        
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-primary to-indigo-600 text-white text-lg font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2 group">
                            <i class="fas fa-lock text-sm group-hover:scale-110 transition-transform"></i>
                            <span>Pay & Place Order</span>
                        </button>
                        
                        <p class="text-center text-xs text-slate-400 mt-6 mt-4"><i class="fas fa-shield-alt mr-1"></i> Your payment information is encrypted and secure.</p>
                    </div>
                </div>

            </form>
            
        <?php endif; ?>

    </div>
</div>

<?php include "includes/footer.php"; ?>
