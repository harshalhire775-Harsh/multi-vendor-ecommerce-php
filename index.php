<?php include "db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Hero Section -->
<section class="relative bg-dark hero-pattern overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-transparent z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center py-20 lg:py-32">
            
            <div class="w-full lg:w-1/2 text-center lg:text-left space-y-8">
                <span class="inline-block py-1.5 px-4 rounded-full bg-primary/20 text-indigo-400 font-semibold text-sm tracking-wider uppercase backdrop-blur-sm border border-primary/30 shadow-[0_0_15px_rgba(99,102,241,0.3)]">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i> New Arrivals
                </span>
                
                <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight tracking-tight">
                    Discover New <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary via-indigo-400 to-secondary animate-gradient-x">
                        Epic Collections
                    </span>
                </h1>
                
                <p class="text-slate-300 text-lg lg:text-xl max-w-2xl mx-auto lg:mx-0 leading-relaxed font-light">
                    Upgrade your lifestyle with our premium multi-vendor store. Find the best products from top verified sellers worldwide.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4 pt-4">
                    <a href="products.php" class="w-full sm:w-auto px-8 py-4 rounded-full bg-gradient-to-r from-primary to-indigo-600 text-white font-semibold shadow-lg shadow-primary/40 hover:shadow-xl hover:shadow-primary/50 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center group">
                        <span>Shop Now</span>
                        <i class="fas fa-shopping-bag ml-3 group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="#categories" class="w-full sm:w-auto px-8 py-4 rounded-full bg-slate-800 text-white font-semibold hover:bg-slate-700 border border-slate-700 transition-all duration-300 flex items-center justify-center">
                        <span>Explore Categories</span>
                        <i class="fas fa-arrow-down ml-3 text-slate-400"></i>
                    </a>
                </div>
                
                <!-- Trust Badges -->
                <div class="flex items-center justify-center lg:justify-start space-x-6 pt-8 text-slate-400 text-sm font-medium">
                    <div class="flex items-center"><i class="fas fa-check-circle text-primary mr-2"></i> Free Shipping</div>
                    <div class="flex items-center"><i class="fas fa-undo text-primary mr-2"></i> 30-Day Returns</div>
                    <div class="flex items-center"><i class="fas fa-shield-alt text-primary mr-2"></i> Secure Payment</div>
                </div>
            </div>

            <!-- Hero Image (Placeholder via CSS styling) -->
            <div class="w-full lg:w-1/2 mt-16 lg:mt-0 relative hidden lg:block">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/30 to-secondary/30 rounded-full blur-3xl opacity-50 block transform scale-150 -z-10 animate-pulse"></div>
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fashion Mode" class="relative z-10 w-[500px] h-[600px] object-cover rounded-[3rem] shadow-2xl mx-auto border-4 border-white/10 rotate-3 hover:rotate-0 transition-transform duration-500">
                
                <!-- Floating Card -->
                <div class="absolute bottom-10 -left-10 bg-white/10 backdrop-blur-md rounded-2xl p-4 flex items-center space-x-4 shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/20 z-20 hover:-translate-y-2 transition-transform">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-green-500 flex items-center justify-center text-white font-bold shadow-lg">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold text-lg">4.9/5</div>
                        <div class="text-slate-300 text-xs uppercase tracking-wide">Customer Rating</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-12 bg-white border-b border-slate-100 relative z-20 -mt-10 rounded-t-[3rem]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="flex items-center space-x-4 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-lg transition-all hover:-translate-y-1 group cursor-pointer">
                <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-primary text-2xl group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-inner">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Fast Delivery</h4>
                    <p class="text-sm text-slate-500 mt-1">On orders over $50</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-lg transition-all hover:-translate-y-1 group cursor-pointer">
                <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center text-secondary text-2xl group-hover:bg-secondary group-hover:text-white transition-colors duration-300 shadow-inner">
                    <i class="fas fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">24/7 Support</h4>
                    <p class="text-sm text-slate-500 mt-1">Dedicated team</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-lg transition-all hover:-translate-y-1 group cursor-pointer">
                <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500 text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Secure Payment</h4>
                    <p class="text-sm text-slate-500 mt-1">100% protected</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-lg transition-all hover:-translate-y-1 group cursor-pointer">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center text-amber-500 text-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Daily Offers</h4>
                    <p class="text-sm text-slate-500 mt-1">Save up to 30%</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Categories -->
<section id="categories" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-primary font-bold uppercase tracking-wider text-sm"><i class="fas fa-grip-horizontal mr-2"></i> Collections</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Shop by Category</h2>
            </div>
            <a href="categories.php" class="hidden md:flex items-center text-primary font-medium hover:text-indigo-700 transition-colors group">
                See all categories <i class="fas fa-long-arrow-alt-right ml-2 transform group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $cat_query = mysqli_query($conn, "SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id ORDER BY product_count DESC LIMIT 4");
            
            // Hardcoded images for demo
            $cat_images = [
                 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ];
            
            $i = 0;
            if (mysqli_num_rows($cat_query) > 0) {
                while($cat = mysqli_fetch_assoc($cat_query)): 
                    $img = $cat_images[$i % 4];
                    $i++;
            ?>
            <a href="search.php?category=<?php echo $cat['id']; ?>" class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 aspect-[4/5] block">
                <img src="<?php echo $img; ?>" alt="<?php echo $cat['name']; ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 flex justify-between items-end">
                    <div>
                        <h3 class="text-white font-bold text-2xl group-hover:text-primary transition-colors"><?php echo htmlspecialchars($cat['name']); ?></h3>
                        <p class="text-slate-300 text-sm mt-1"><?php echo $cat['product_count']; ?> Products</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            <?php 
                endwhile; 
            } else {
                echo "<p class='col-span-4 text-slate-500 text-center py-10 bg-white rounded-2xl border border-dashed border-slate-300'>No categories found. Please add categories via Admin Panel.</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <span class="text-secondary font-bold uppercase tracking-wider text-sm"><i class="fas fa-fire mr-2"></i> Trending Now</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mt-4 mb-6">Featured Products</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg hover:text-slate-700 transition-colors">Our top picks for you this week. Don't miss out on these exclusive deals from top vendors.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $prod_query = mysqli_query($conn, "SELECT p.*, c.name as category_name, v.name as vendor_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN vendors v ON p.vendor_id = v.id ORDER BY p.created_at DESC LIMIT 8");
            
            if (mysqli_num_rows($prod_query) > 0) {
                while($prod = mysqli_fetch_assoc($prod_query)): 
                    $image = $prod['image'] ? (strpos($prod['image'], 'http') === 0 ? $prod['image'] : 'uploads/'.$prod['image']) : 'https://placehold.co/400x400/f3f4f6/a1a1aa?text=Image+Not+Found';
                    $has_discount = true; // Mocking a discount for UI
                    $old_price = $prod['price'] * 1.2;
            ?>
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 group hover:-translate-y-2 flex flex-col">
                <!-- Product Image -->
                <div class="relative aspect-square overflow-hidden bg-slate-50">
                    <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col space-y-2">
                        <span class="bg-secondary text-white text-[10px] uppercase font-bold px-2 py-1 rounded shadow-sm tracking-wider">Sale</span>
                        <span class="bg-dark text-white text-[10px] uppercase font-bold px-2 py-1 rounded shadow-sm tracking-wider">New</span>
                    </div>

                    <!-- Quick Actions Hover -->
                    <div class="absolute inset-0 bg-dark/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-3 backdrop-blur-[2px]">
                        <a href="product.php?id=<?php echo $prod['id']; ?>" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 hover:bg-primary hover:text-white transition-all transform hover:scale-110 shadow-lg" title="Quick View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="cart.php" method="POST" class="inline">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white hover:bg-dark transition-all transform hover:scale-110 shadow-[0_0_15px_rgba(99,102,241,0.5)]" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-6 flex flex-col flex-grow relative">
                    <p class="text-xs text-slate-400 font-medium mb-2 uppercase tracking-wide"><?php echo htmlspecialchars($prod['category_name'] ?? 'Uncategorized'); ?></p>
                    <a href="product.php?id=<?php echo $prod['id']; ?>" class="font-bold text-lg text-slate-800 hover:text-primary transition-colors line-clamp-2 leading-tight flex-grow mb-3">
                        <?php echo htmlspecialchars($prod['name']); ?>
                    </a>
                    
                    <div class="flex items-center space-x-1 mb-4">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                        <span class="text-xs text-slate-500 font-medium ml-1">(120)</span>
                    </div>

                    <div class="flex items-end justify-between mt-auto">
                        <div class="flex flex-col">
                            <?php if($has_discount): ?>
                                <span class="text-xs text-slate-400 line-through font-medium">$<?php echo number_format($old_price, 2); ?></span>
                            <?php endif; ?>
                            <span class="text-xl font-black text-slate-900">$<?php echo number_format($prod['price'], 2); ?></span>
                        </div>
                        <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-1 rounded font-medium truncate max-w-[80px]">By <?php echo htmlspecialchars($prod['vendor_name'] ?? 'Admin'); ?></span>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            } else {
                echo "<div class='col-span-full py-20 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200'>
                    <i class=".'fas fa-box-open text-6xl text-slate-300 mb-4'."></i>
                    <h3 class='text-xl font-bold text-slate-700'>No products found</h3>
                    <p class='text-slate-500 mt-2'>Be the first to add products to the store.</p>
                </div>";
            }
            ?>
        </div>
        
        <div class="mt-16 text-center">
            <a href="products.php" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-primary text-primary font-bold rounded-full hover:bg-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg">
                View All Products <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action (Vendor) -->
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-dark z-0"></div>
    <!-- Decorative blobs -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] p-10 lg:p-16 flex flex-col md:flex-row items-center justify-between text-center md:text-left shadow-2xl">
            <div class="max-w-2xl mb-10 md:mb-0">
                <span class="px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold tracking-widest uppercase mb-6 inline-block">Partner With Us</span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4">Become a Vendor Today!</h2>
                <p class="text-slate-300 text-lg sm:text-xl font-light leading-relaxed">Reach millions of customers. Open your online store with us and start selling in minutes with zero setup fees.</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="signup.php?role=vendor" class="px-8 py-4 bg-white text-dark font-bold rounded-full hover:bg-slate-100 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.3)] flex items-center justify-center">
                    Register as Vendor <i class="fas fa-store ml-2 text-primary"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
