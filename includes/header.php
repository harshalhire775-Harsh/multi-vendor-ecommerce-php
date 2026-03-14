<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStore - Multi-Vendor E-Commerce</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1', // Indigo 500
                        secondary: '#f43f5e', // Rose 500
                        dark: '#0f172a',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; scroll-behavior: smooth; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

<!-- Navigation -->
<nav class="fixed w-full z-50 glass-effect transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php" class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                    Luxe<span class="text-dark">Store</span>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 items-center justify-center px-8">
                <div class="w-full max-w-lg relative group">
                    <form action="search.php" method="GET" class="relative">
                        <input type="text" name="query" placeholder="Search for products, categories..." class="w-full bg-white border border-slate-200 rounded-full py-2.5 pl-12 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all shadow-sm group-hover:shadow-md">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 group-hover:text-primary transition-colors"></i>
                        </div>
                        <button type="submit" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fas fa-arrow-right text-slate-400 hover:text-primary transition-colors cursor-pointer"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Nav Items -->
            <div class="hidden md:flex items-center space-x-6">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="relative group cursor-pointer inline-block">
                        <div class="flex items-center space-x-2 text-slate-600 hover:text-primary transition-colors">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=random" class="w-8 h-8 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                            <span class="font-medium text-sm"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                        <!-- Dropdown -->
                        <div class="absolute right-0 w-48 mt-2 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 pt-2">
                            <div class="py-2">
                                <?php if($_SESSION['user_role'] === 'admin'): ?>
                                    <a href="admin/index.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary"><i class="fas fa-chart-line w-5"></i> Admin Dashboard</a>
                                <?php elseif($_SESSION['user_role'] === 'vendor'): ?>
                                    <a href="vendor/index.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary"><i class="fas fa-store w-5"></i> Vendor Dashboard</a>
                                <?php endif; ?>
                                <a href="profile.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary"><i class="fas fa-user w-5"></i> My Profile</a>
                                <a href="orders.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary"><i class="fas fa-box w-5"></i> My Orders</a>
                                <hr class="my-1 border-slate-100">
                                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="text-slate-600 hover:text-primary font-medium text-sm transition-colors">Login</a>
                    <a href="signup.php" class="bg-dark hover:bg-slate-800 text-white px-5 py-2.5 rounded-full font-medium text-sm transition-colors shadow-md shadow-dark/20 flex items-center space-x-2">
                        <span>Sign Up</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                <?php endif; ?>

                <!-- Cart Icon -->
                <a href="cart.php" class="relative p-2 text-slate-600 hover:text-primary transition-colors group">
                    <i class="fas fa-shopping-cart text-xl group-hover:scale-110 transition-transform duration-200"></i>
                    <?php if($cart_count > 0): ?>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-secondary rounded-full border-2 border-white shadow-sm">
                            <?php echo $cart_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center space-x-4">
                <a href="cart.php" class="relative p-2 text-slate-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <?php if($cart_count > 0): ?>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-secondary rounded-full border-2 border-white">
                            <?php echo $cart_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
                <button type="button" class="text-slate-500 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary p-2" id="mobile-menu-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Categories Row (Desktop) -->
        <div class="hidden md:flex space-x-8 py-3 border-t border-slate-100 text-sm font-medium text-slate-600">
            <a href="index.php" class="hover:text-primary transition-colors">Home</a>
            <a href="products.php" class="hover:text-primary transition-colors">All Products</a>
            <?php 
                if(isset($conn)) {
                    $cat_query = mysqli_query($conn, "SELECT * FROM categories LIMIT 5");
                    if($cat_query) {
                        while($cat = mysqli_fetch_assoc($cat_query)) {
                            echo '<a href="search.php?category='.$cat['id'].'" class="hover:text-primary transition-colors">'.htmlspecialchars($cat['name']).'</a>';
                        }
                    }
                }
            ?>
            <a href="contact.php" class="hover:text-primary transition-colors">Contact Support</a>
        </div>
    </div>
</nav>
<div class="h-auto md:h-32 pt-20 md:pt-0"></div> <!-- Spacer for fixed nav -->
