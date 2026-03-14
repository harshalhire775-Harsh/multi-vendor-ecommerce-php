<?php
include "db.php";
session_start();
?>
<?php include "includes/header.php"; ?>

<div class="bg-slate-50 min-h-screen py-12 md:py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-4">All Categories</h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">Browse our wide selection of categories and uncover exactly what you are looking for.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $cat_query = mysqli_query($conn, "SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id ORDER BY name ASC");
            
            $cat_images = [
                 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=500&q=80'
            ];
            
            $i = 0;
            if (mysqli_num_rows($cat_query) > 0) {
                while($cat = mysqli_fetch_assoc($cat_query)): 
                    $img = $cat_images[$i % 5];
                    $i++;
            ?>
            <a href="search.php?category=<?php echo $cat['id']; ?>" class="group flex flex-col items-center p-6 bg-white rounded-3xl border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden mb-6 border-4 border-slate-50 shadow-inner group-hover:border-primary transition-colors">
                    <img src="<?php echo $img; ?>" alt="<?php echo $cat['name']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors mb-1"><?php echo htmlspecialchars($cat['name']); ?></h3>
                <p class="text-sm font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100"><?php echo $cat['product_count']; ?> Items</p>
            </a>
            <?php 
                endwhile; 
            } else {
                echo "<p class='col-span-full text-slate-500 text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200'>No categories found.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
