<footer class="bg-dark text-slate-300 py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            
            <!-- Brand & Description -->
            <div class="space-y-6">
                <a href="index.php" class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                    Luxe<span class="text-white">Store</span>
                </a>
                <p class="text-sm text-slate-400 leading-relaxed mb-6">
                    Your premier destination for high-quality products from top vendors worldwide. Experience luxury shopping at your fingertips.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all transform hover:-translate-y-1 shadow-md"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-sky-400 hover:text-white transition-all transform hover:-translate-y-1 shadow-md"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-pink-500 hover:text-white transition-all transform hover:-translate-y-1 shadow-md"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:text-white transition-all transform hover:-translate-y-1 shadow-md"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-6 flex items-center space-x-2"><i class="fas fa-link text-primary text-xs"></i> <span>Quick Links</span></h4>
                <ul class="space-y-4">
                    <li><a href="index.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Home</a></li>
                    <li><a href="products.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> All Products</a></li>
                    <li><a href="vendors.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Top Vendors</a></li>
                    <li><a href="about.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> About Us</a></li>
                    <li><a href="contact.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Contact Support</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-white font-semibold mb-6 flex items-center space-x-2"><i class="fas fa-headset text-primary text-xs"></i> <span>Customer Service</span></h4>
                <ul class="space-y-4">
                    <li><a href="profile.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> My Account</a></li>
                    <li><a href="orders.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Track Order</a></li>
                    <li><a href="faq.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> FAQs</a></li>
                    <li><a href="shipping.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Shipping Policy</a></li>
                    <li><a href="returns.php" class="text-slate-400 hover:text-primary transition-colors text-sm"><i class="fas fa-chevron-right text-[10px] mr-2 text-slate-600"></i> Returns & Refunds</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-white font-semibold mb-6 flex items-center space-x-2"><i class="fas fa-envelope-open-text text-primary text-xs"></i> <span>Newsletter</span></h4>
                <p class="text-slate-400 text-sm mb-4">Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                <form class="flex flex-col space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-500"></i>
                        </div>
                        <input type="email" placeholder="Enter your email" class="w-full bg-slate-800 border-none rounded-lg py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-primary placeholder-slate-500" required>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-indigo-600 text-white font-medium py-3 rounded-lg hover:from-indigo-600 hover:to-primary transition-all shadow-lg shadow-primary/30 flex items-center justify-center space-x-2">
                        <span>Subscribe Now</span>
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>
            
        </div>
        
        <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
            <p>&copy; <?php echo date('Y'); ?> LuxeStore. All rights reserved.</p>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <i class="fab fa-cc-visa text-2xl hover:text-white transition-colors cursor-pointer"></i>
                <i class="fab fa-cc-mastercard text-2xl hover:text-white transition-colors cursor-pointer"></i>
                <i class="fab fa-cc-paypal text-2xl hover:text-white transition-colors cursor-pointer"></i>
                <i class="fab fa-cc-amex text-2xl hover:text-white transition-colors cursor-pointer"></i>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Menu Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('mobile-menu-btn');
        // Mobile menu functionality can be expanded here
        if(btn) {
            btn.addEventListener('click', () => {
                alert('Mobile menu toggle activated. Implement full menu modal here.');
            });
        }
    });
</script>

</body>
</html>
