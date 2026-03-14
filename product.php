<?php
include "db.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($conn, "SELECT p.*, c.name as category_name, v.name as vendor_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN vendors v ON p.vendor_id = v.id WHERE p.id = $id");

if(!$query || mysqli_num_rows($query) == 0){
    header("Location: index.php");
    exit();
}

$product = mysqli_fetch_assoc($query);
$image = $product['image'] ? (strpos($product['image'], 'http') === 0 ? $product['image'] : 'uploads/'.$product['image']) : 'https://placehold.co/800x800/e2e8f0/94a3b8?text=Product+Image';

// Fetch Reviews
$reviews_query = mysqli_query($conn, "SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = $id ORDER BY r.created_at DESC");
$avg_query = mysqli_query($conn, "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE product_id = $id");
$rating_data = mysqli_fetch_assoc($avg_query);
$avg_rating = round($rating_data['avg_rating'], 1) ?: 0;
$total_reviews = $rating_data['total_reviews'];

?>
<?php include "includes/header.php"; ?>

<div class="bg-white py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="index.php" class="hover:text-primary transition-colors"><i class="fas fa-home mr-2"></i>Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-xs mx-2"></i>
                        <a href="products.php" class="hover:text-primary transition-colors">Products</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-xs mx-2"></i>
                        <a href="search.php?category=<?php echo $product['category_id']; ?>" class="hover:text-primary transition-colors"><?php echo htmlspecialchars($product['category_name'] ?? 'Category'); ?></a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-xs mx-2"></i>
                        <span class="text-slate-800 font-medium truncate max-w-[150px] md:max-w-[300px]"><?php echo htmlspecialchars($product['name']); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
            
            <!-- Left: Product Image -->
            <div class="space-y-4">
                <div class="aspect-square bg-slate-50 rounded-3xl overflow-hidden border border-slate-100 flex items-center justify-center p-8 group relative shadow-inner">
                    <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-contain cursor-zoom-in group-hover:scale-105 transition-transform duration-500 hover:drop-shadow-2xl mix-blend-multiply">
                    
                    <button class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all shadow-md">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    
                    <?php if($product['stock'] < 10 && $product['stock'] > 0): ?>
                    <span class="absolute top-4 left-4 bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-orange-200">
                        Only <?php echo $product['stock']; ?> left!
                    </span>
                    <?php endif; ?>
                </div>
                
                <!-- Thumbnails (Mocked for UI) -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="aspect-square rounded-xl border-2 border-primary overflow-hidden cursor-pointer">
                        <img src="<?php echo $image; ?>" class="w-full h-full object-contain p-8">
                    </div>
                    <!-- Add more thumbnails if necessary -->
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="flex flex-col py-2">
                
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>
                
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex items-center bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200">
                        <i class="fas fa-star text-yellow-400 text-sm mr-1"></i>
                        <span class="font-bold text-slate-900"><?php echo $avg_rating; ?></span>
                        <span class="text-slate-500 ml-1 text-sm">(<?php echo $total_reviews; ?> reviews)</span>
                    </div>
                    <span class="text-slate-300">|</span>
                    <a href="#vendor" class="text-primary hover:text-indigo-600 font-medium text-sm transition-colors border-b border-transparent hover:border-indigo-600">
                        <i class="fas fa-store-alt mr-1"></i> <?php echo htmlspecialchars($product['vendor_name'] ?? 'Admin Store'); ?>
                    </a>
                </div>
                
                <div class="mb-8">
                    <span class="text-4xl font-black text-slate-900">$<?php echo number_format($product['price'], 2); ?></span>
                    <span class="text-lg text-slate-400 line-through ml-3 font-medium">$<?php echo number_format($product['price'] * 1.2, 2); ?></span>
                </div>
                
                <!-- Simple Description -->
                <p class="text-slate-600 leading-relaxed mb-8 border-b border-slate-100 pb-8 rounded-sm text-lg font-light">
                    <?php echo nl2br(htmlspecialchars(substr($product['description'], 0, 500))) . (strlen($product['description']) > 500 ? '...' : ''); ?>
                </p>

                <!-- Action form -->
                <form action="cart.php" method="POST" class="mt-auto space-y-6">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <!-- Variations (Mocked UI) -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-900">Color</label>
                        <div class="flex space-x-3">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="color" class="peer sr-only" checked>
                                <div class="w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-primary peer-checked:p-1 transition-all">
                                    <div class="w-full h-full rounded-full bg-slate-900 shadow-inner"></div>
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="color" class="peer sr-only">
                                <div class="w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-primary peer-checked:p-1 transition-all">
                                    <div class="w-full h-full rounded-full bg-slate-200 border border-slate-300 shadow-inner"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <!-- Quantity Selector -->
                        <div class="flex items-center border-2 border-slate-200 rounded-xl bg-white w-32 h-14">
                            <button type="button" class="w-10 h-full text-slate-500 hover:text-primary transition-colors focus:outline-none" onclick="document.getElementById('quantity').value = Math.max(1, parseInt(document.getElementById('quantity').value) - 1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="flex-1 w-full text-center font-bold text-slate-800 bg-transparent focus:outline-none border-none pointer-events-none appearance-none h-full">
                            <button type="button" class="w-10 h-full text-slate-500 hover:text-primary transition-colors focus:outline-none" onclick="document.getElementById('quantity').value = Math.min(<?php echo $product['stock']; ?>, parseInt(document.getElementById('quantity').value) + 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <!-- Add to Cart Btn -->
                        <?php if($product['stock'] > 0): ?>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-primary to-indigo-600 text-white font-bold h-14 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center space-x-2">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Add to Cart</span>
                        </button>
                        <?php else: ?>
                        <button disabled type="button" class="flex-1 bg-slate-300 text-slate-500 font-bold h-14 rounded-xl cursor-not-allowed flex items-center justify-center space-x-2">
                            <i class="fas fa-times-circle"></i>
                            <span>Out of Stock</span>
                        </button>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Guarantees -->
                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-slate-100">
                    <div class="flex items-center text-slate-600">
                        <i class="fas fa-shield-alt text-xl text-emerald-500 mr-3"></i>
                        <span class="text-sm font-medium">1 Year Warranty</span>
                    </div>
                    <div class="flex items-center text-slate-600">
                        <i class="fas fa-truck text-xl text-sky-500 mr-3"></i>
                        <span class="text-sm font-medium">Free Shipping inside US</span>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Tabs (Description / Reviews) -->
        <div class="mt-20 md:mt-32 border-t border-slate-200">
            <div class="flex justify-center space-x-8 -mt-px">
                <button class="py-4 border-b-2 border-primary text-primary font-bold px-4 text-lg" id="tab-desc">Full Description</button>
                <button class="py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-800 font-bold px-4 text-lg" id="tab-reviews">Customer Reviews (<span id="review-count"><?php echo $total_reviews; ?></span>)</button>
            </div>
            
            <div class="py-12 max-w-4xl mx-auto">
                <div id="content-desc" class="prose prose-lg prose-indigo mx-auto text-slate-600">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </div>
                
                <!-- Display Reviews UI (Basic layout) -->
                <div id="content-reviews" class="hidden">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">Real Reviews from verified buyers</h3>
                        <button class="px-6 py-2 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-slate-800 transition-colors">Write a Review</button>
                    </div>
                    
                    <div class="space-y-6">
                        <?php 
                        if(mysqli_num_rows($reviews_query) > 0){
                            while($review = mysqli_fetch_assoc($reviews_query)){
                        ?>
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-slate-900"><?php echo htmlspecialchars($review['user_name']); ?></h4>
                                    <div class="flex mt-1">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-slate-300'; ?> text-xs"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 font-medium"><?php echo date('M d, Y', strtotime($review['created_at'])); ?></span>
                            </div>
                            <p class="text-slate-600 leading-relaxed"><?php echo htmlspecialchars($review['comment']); ?></p>
                        </div>
                        <?php } } else { echo "<p class='text-slate-500 italic text-center py-8'>No reviews yet. Be the first to review this product!</p>"; } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Tab switching logic
    document.getElementById('tab-desc').addEventListener('click', function() {
        this.classList.add('border-primary', 'text-primary');
        this.classList.remove('border-transparent', 'text-slate-500');
        document.getElementById('tab-reviews').classList.remove('border-primary', 'text-primary');
        document.getElementById('tab-reviews').classList.add('border-transparent', 'text-slate-500');
        document.getElementById('content-desc').classList.remove('hidden');
        document.getElementById('content-reviews').classList.add('hidden');
    });

    document.getElementById('tab-reviews').addEventListener('click', function() {
        this.classList.add('border-primary', 'text-primary');
        this.classList.remove('border-transparent', 'text-slate-500');
        document.getElementById('tab-desc').classList.remove('border-primary', 'text-primary');
        document.getElementById('tab-desc').classList.add('border-transparent', 'text-slate-500');
        document.getElementById('content-reviews').classList.remove('hidden');
        document.getElementById('content-desc').classList.add('hidden');
    });
</script>

<?php include "includes/footer.php"; ?>
