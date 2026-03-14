<?php
include "db.php";
session_start();

$query_str = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000;

$sql = "SELECT p.*, c.name as category_name, v.name as vendor_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN vendors v ON p.vendor_id = v.id WHERE 1=1";

if(!empty($query_str)){
    $sql .= " AND (p.name LIKE '%$query_str%' OR p.description LIKE '%$query_str%')";
}
if($category_id > 0){
    $sql .= " AND p.category_id = $category_id";
}
if($min_price > 0){
    $sql .= " AND p.price >= $min_price";
}
if($max_price < 10000 && $max_price > 0){
    $sql .= " AND p.price <= $max_price";
}

$sql .= " ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $sql);

// Handlers for UI
$category_query = mysqli_query($conn, "SELECT * FROM categories");

?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 pb-6 border-b border-slate-200">
            <div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
                    <?php echo !empty($query_str) ? "Search: '".htmlspecialchars($query_str)."'" : "Explore Products"; ?>
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Showing <?php echo mysqli_num_rows($result); ?> results for your search</p>
            </div>
            
            <!-- Mobile Filter Toggle -->
            <button class="md:hidden mt-4 px-6 py-3 bg-white border border-slate-200 rounded-xl shadow-sm text-slate-700 font-bold flex items-center space-x-2">
                <i class="fas fa-filter text-primary"></i> <span>Filters</span>
            </button>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Filters Sidebar -->
            <div class="w-full md:w-1/4 hidden md:block">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 sticky top-28">
                    <form action="" method="GET" class="space-y-8">
                        <?php if(!empty($query_str)): ?>
                            <input type="hidden" name="query" value="<?php echo htmlspecialchars($query_str); ?>">
                        <?php endif; ?>
                        
                        <!-- Categories Filter -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center"><i class="fas fa-layer-group text-primary mr-2"></i> Categories</h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="category" value="0" <?php echo $category_id == 0 ? 'checked' : ''; ?> class="form-radio text-primary border-slate-300 focus:ring-primary h-5 w-5 transition-all outline-none">
                                    <span class="text-slate-600 group-hover:text-primary transition-colors font-medium">All Categories</span>
                                </label>
                                <?php while($cat = mysqli_fetch_assoc($category_query)): ?>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="category" value="<?php echo $cat['id']; ?>" <?php echo $category_id == $cat['id'] ? 'checked' : ''; ?> class="form-radio text-primary border-slate-300 focus:ring-primary h-5 w-5 transition-all outline-none">
                                    <span class="text-slate-600 group-hover:text-primary transition-colors font-medium"><?php echo htmlspecialchars($cat['name']); ?></span>
                                </label>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        
                        <!-- Price Filter -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center"><i class="fas fa-tags text-primary mr-2"></i> Price Range</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 block">Min Price</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-slate-400 font-bold">$</span></div>
                                        <input type="number" name="min_price" value="<?php echo $min_price ?: ''; ?>" placeholder="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-8 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 block">Max Price</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-slate-400 font-bold">$</span></div>
                                        <input type="number" name="max_price" value="<?php echo $max_price < 10000 ? $max_price : ''; ?>" placeholder="10000" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-8 py-3 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-dark text-white font-bold rounded-xl shadow-lg hover:bg-slate-800 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                            <span>Apply Filters</span>
                            <i class="fas fa-check text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full md:w-3/4">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while($prod = mysqli_fetch_assoc($result)): 
                            $image = $prod['image'] ? (strpos($prod['image'], 'http') === 0 ? $prod['image'] : 'uploads/'.$prod['image']) : 'https://placehold.co/400x400/f3f4f6/a1a1aa?text=No+Image';
                            $old_price = $prod['price'] * 1.2;
                        ?>
                            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 group hover:-translate-y-2 flex flex-col relative w-full aspect-auto h-auto min-h-[400px]">
                                <!-- Product Image Container -->
                                <div class="relative w-full pb-[100%] bg-white m-0 p-0 overflow-hidden">
                                     <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="absolute top-0 left-0 w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-500 ease-in-out z-0">
                                     
                                     <!-- Badges -->
                                     <div class="absolute top-4 left-4 flex flex-col space-y-2 z-10 pointer-events-none">
                                         <span class="bg-secondary text-white text-[10px] uppercase font-bold px-2 py-1 rounded shadow-sm tracking-wider backdrop-blur-md bg-opacity-90">Sale</span>
                                     </div>
                                     
                                     <!-- Quick Actions -->
                                     <div class="absolute inset-0 bg-dark/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-3 backdrop-blur-[2px] z-20">
                                         <a href="product.php?id=<?php echo $prod['id']; ?>" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 hover:bg-primary hover:text-white transition-all transform hover:scale-110 shadow-lg" title="View Details">
                                             <i class="fas fa-eye text-lg"></i>
                                         </a>
                                         <form action="cart.php" method="POST" class="inline m-0">
                                             <input type="hidden" name="action" value="add">
                                             <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                             <input type="hidden" name="quantity" value="1">
                                             <button type="submit" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-indigo-600 transition-all transform hover:scale-110 shadow-[0_0_15px_rgba(99,102,241,0.5)] border-0 cursor-pointer" title="Add to Cart">
                                                 <i class="fas fa-shopping-cart text-lg"></i>
                                             </button>
                                         </form>
                                     </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-6 flex flex-col flex-grow bg-white z-10 border-t border-slate-50 mt-auto">
                                    <p class="text-[10px] text-slate-400 font-bold mb-2 uppercase tracking-widest line-clamp-1"><?php echo htmlspecialchars($prod['category_name'] ?? 'Uncategorized'); ?></p>
                                    
                                    <a href="product.php?id=<?php echo $prod['id']; ?>" class="font-extrabold text-lg text-slate-800 hover:text-primary transition-colors line-clamp-2 leading-tight mb-3">
                                        <?php echo htmlspecialchars($prod['name']); ?>
                                    </a>
                                    
                                    <!-- Stars Mock -->
                                    <div class="flex items-center space-x-1 mb-4 opacity-80">
                                        <i class="fas fa-star text-yellow-400 text-xs shadow-sm"></i>
                                        <i class="fas fa-star text-yellow-400 text-xs shadow-sm"></i>
                                        <i class="fas fa-star text-yellow-400 text-xs shadow-sm"></i>
                                        <i class="fas fa-star text-yellow-400 text-xs shadow-sm"></i>
                                        <i class="fas fa-star-half-alt text-yellow-400 text-xs shadow-sm"></i>
                                        <span class="text-[10px] text-slate-500 font-bold ml-1 tracking-wider bg-slate-100 px-1.5 py-0.5 rounded">(12)</span>
                                    </div>

                                    <div class="flex items-end justify-between mt-auto pt-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-rose-500 line-through font-bold drop-shadow-sm">$<?php echo number_format($old_price, 2); ?></span>
                                            <span class="text-2xl font-black text-slate-900 drop-shadow-sm leading-none">$<?php echo number_format($prod['price'], 2); ?></span>
                                        </div>
                                        <span class="text-[10px] text-slate-600 bg-slate-100 border border-slate-200 px-2 py-1 rounded-md font-bold truncate max-w-[100px] shadow-sm flex items-center"><i class="fas fa-store text-slate-400 mr-1 text-[8px]"></i><?php echo htmlspecialchars($prod['vendor_name'] ?? 'Admin'); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-slate-100 border-dashed">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <i class="fas fa-search text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">No products found</h2>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">We couldn't find any products matching your current filters. Try adjusting them.</p>
                        <a href="search.php" class="px-8 py-3 outline outline-2 outline-primary text-primary font-bold rounded-lg hover:bg-primary hover:text-white transition-all shadow-sm">Clear Filters</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
