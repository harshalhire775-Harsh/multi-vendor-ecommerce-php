<?php
include "db.php";
session_start();

$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if($stmt->execute()){
        $success = "Thank you! Your message has been sent successfully. We will get back to you shortly.";
    } else {
        $error = "Oops! Something went wrong. Please try again.";
    }
}
?>
<?php include "includes/header.php"; ?>

<div class="bg-dark min-h-screen relative overflow-hidden py-24">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -m-32 w-96 h-96 bg-primary rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -m-32 w-96 h-96 bg-secondary rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse" style="animation-duration: 4s;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4">Get in Touch</h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto font-light">Have questions about your order, our vendors, or just want to say hi? We're here to help you 24/7.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 bg-white/10 backdrop-blur-2xl rounded-[3rem] p-8 md:p-12 border border-white/10 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)]">
            
            <!-- Contact Info -->
            <div class="lg:col-span-2 space-y-8 text-white">
                <div>
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    <p class="text-slate-300 font-light mb-8">Fill up the form and our Team will get back to you within 24 hours.</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4 group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-slate-200">Phone</h4>
                            <p class="text-slate-400 font-light mt-1">+1 (555) 123-4567</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4 group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-slate-200">Email</h4>
                            <p class="text-slate-400 font-light mt-1">support@luxestore.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4 group">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-emerald-400 group-hover:bg-emerald-400 group-hover:text-white transition-all shadow-inner">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-slate-200">Office</h4>
                            <p class="text-slate-400 font-light mt-1">123 Luxury Ave, Suite 500<br>New York, NY 10001</p>
                        </div>
                    </div>
                </div>

                <div class="pt-12">
                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-700/50 pb-2">Connect with us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-[#1877F2] hover:text-white transition-all transform hover:scale-110"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-[#1DA1F2] hover:text-white transition-all transform hover:scale-110"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-[#E4405F] hover:text-white transition-all transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="lg:col-span-3 bg-white rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full z-0"></div>
                <h3 class="text-2xl font-bold text-slate-900 mb-6 relative z-10">Send us a message</h3>
                
                <?php if($success): ?>
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg mb-6 flex items-center shadow-sm relative z-10">
                        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
                        <p class="text-sm text-emerald-700 font-medium"><?php echo $success; ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if($error): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6 flex items-center shadow-sm relative z-10">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
                        <p class="text-sm text-red-700 font-medium"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide text-xs">Your Name</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-inner" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide text-xs">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-inner" placeholder="john@example.com">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide text-xs">Message</label>
                        <textarea name="message" required rows="5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-inner resize-none" placeholder="How can we help you?"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-dark to-slate-800 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center space-x-2 group">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane text-xs group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                    <p class="text-center text-xs text-slate-400 mt-4 font-medium"><i class="fas fa-lock mr-1"></i> Your data is safe with us.</p>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
