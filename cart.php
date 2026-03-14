<?php
include "db.php";
session_start();

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['product_id'] ?? 0);
    $qty = intval($_POST['quantity'] ?? 1);

    if($action == 'add' && $id > 0){
        // Add or update quantity
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id] += $qty;
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    } elseif($action == 'update' && $id > 0){
        if($qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    } elseif($action == 'remove' && $id > 0){
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}

$cart_items = [];
$total = 0;

if(!empty($_SESSION['cart'])){
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = mysqli_query($conn, "SELECT p.*, v.name as vendor_name FROM products p LEFT JOIN vendors v ON p.vendor_id = v.id WHERE p.id IN ($ids)");
    while($row = mysqli_fetch_assoc($query)){
        $qty = $_SESSION['cart'][$row['id']];
        $subtotal = $row['price'] * $qty;
        $total += $subtotal;
        $row['qty'] = $qty;
        $row['subtotal'] = $subtotal;
        $cart_items[] = $row;
    }
}
?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-2">Shopping Cart</h1>
        <p class="text-slate-500 mb-10"><i class="fas fa-lock mr-2"></i> All transactions are secure and encrypted.</p>

        <?php if(empty($cart_items)): ?>
            <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-slate-100 max-w-2xl mx-auto border-dashed">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-4xl text-slate-300"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Your cart is empty</h2>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Looks like you haven't added anything to your cart yet. Let's find something incredible!</p>
                <a href="index.php" class="px-8 py-4 bg-dark text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">Start Shopping</a>
            </div>
        <?php else: ?>

            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <?php foreach($cart_items as $item): 
                        $img = $item['image'] ? (strpos($item['image'], 'http') === 0 ? $item['image'] : 'uploads/'.$item['image']) : 'https://placehold.co/200x200/e2e8f0/94a3b8';
                    ?>
                    <div class="bg-white rounded-2xl p-6 flex flex-col sm:flex-row shadow-sm border border-slate-100 items-start sm:items-center group hover:shadow-md transition-shadow">
                        <!-- Image -->
                        <div class="w-24 h-24 bg-slate-50 rounded-xl overflow-hidden shrink-0 border border-slate-100 mb-4 sm:mb-0">
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-full object-contain p-2 mix-blend-multiply">
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-grow sm:ml-6 flex flex-col mb-4 sm:mb-0">
                            <h3 class="font-bold text-lg inline-block text-slate-800 hover:text-primary transition-colors">
                                <a href="product.php?id=<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                            </h3>
                            <span class="text-xs text-slate-500 uppercase tracking-wide font-medium mt-1 mb-2">Vendor: <?php echo htmlspecialchars($item['vendor_name'] ?? 'Admin'); ?></span>
                            <span class="text-lg font-black text-slate-900 block">$<?php echo number_format($item['price'], 2); ?></span>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center space-x-6 shrink-0 sm:ml-auto w-full sm:w-auto justify-between sm:justify-end">
                            <!-- Update Quantity via Form inside JS to keep it simple or direct form -->
                            <form action="" method="POST" class="flex items-center border border-slate-200 rounded-lg p-1 bg-slate-50">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-primary focus:outline-none" onclick="this.nextElementSibling.value--; this.form.submit();"><i class="fas fa-minus text-xs"></i></button>
                                <input type="number" name="quantity" value="<?php echo $item['qty']; ?>" class="w-12 text-center bg-transparent border-none focus:ring-0 font-bold p-0 text-sm pointer-events-none appearance-none" readonly>
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-primary focus:outline-none" onclick="this.previousElementSibling.value++; this.form.submit();"><i class="fas fa-plus text-xs"></i></button>
                            </form>
                            
                            <!-- Subtotal display and remove button -->
                            <div class="flex flex-col items-end border-l border-slate-100 pl-6 space-y-2">
                                <span class="font-bold text-lg text-slate-900">$<?php echo number_format($item['subtotal'], 2); ?></span>
                                <form action="" method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors flex items-center focus:outline-none"><i class="fas fa-trash-alt mr-1"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Order Summary Sidebar -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8 sticky top-28">
                        <h3 class="text-xl font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Order Summary</h3>
                        
                        <div class="space-y-4 text-slate-600 mb-6">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-800">$<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center text-emerald-600">
                                <span>Discount</span>
                                <span class="font-bold">-$0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Shipping estimate</span>
                                <span class="font-bold">$15.00</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Tax estimate</span>
                                <span class="font-bold text-slate-800">$<?php echo number_format($total * 0.05, 2); ?></span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center border-t border-slate-100 py-6 mb-6">
                            <span class="text-lg font-medium text-slate-900">Estimated Total</span>
                            <span class="text-3xl font-black text-slate-900">$<?php echo number_format($total + 15 + ($total * 0.05), 2); ?></span>
                        </div>
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="checkout.php" class="block w-full text-center py-4 bg-gradient-to-r from-primary to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                Proceed to Checkout
                            </a>
                        <?php else: ?>
                            <a href="login.php?redirect=checkout" class="block w-full text-center py-4 bg-dark text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                Login to Checkout
                            </a>
                        <?php endif; ?>
                        
                        <!-- Mini trust badge -->
                        <div class="mt-8 flex justify-center space-x-3 text-2xl text-slate-300">
                            <i class="fab fa-cc-visa hover:text-blue-700 transition-colors"></i>
                            <i class="fab fa-cc-mastercard hover:text-red-500 transition-colors"></i>
                            <i class="fab fa-cc-paypal hover:text-sky-500 transition-colors"></i>
                            <i class="fab fa-cc-amex hover:text-blue-400 transition-colors"></i>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>
</div>

<?php include "includes/footer.php"; ?>
