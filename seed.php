<?php
// seed.php - Run this file in browser to populate dummy data
$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

echo "<h1>Populating Database with Premium Mock Data...</h1>";

// 1. Insert Categories
$categories = [
    "Electronics & Gadgets",
    "Men's Fashion",
    "Women's Fashion",
    "Home & Living",
    "Beauty & Care",
    "Sports & Fitness"
];

foreach ($categories as $cat) {
    mysqli_query($conn, "INSERT IGNORE INTO categories (name) VALUES ('$cat')");
}
echo "<p>✅ Categories added successfully.</p>";

// Get Category IDs
$cat_elec = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE name='Electronics & Gadgets'"))['id'];
$cat_men = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE name=\"Men's Fashion\""))['id'];
$cat_women = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE name=\"Women's Fashion\""))['id'];
$cat_home = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE name='Home & Living'"))['id'];
$cat_beauty = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE name='Beauty & Care'"))['id'];

// 2. Create a Mock Vendor
$vendor_user_email = 'vendorhq@example.com';
mysqli_query($conn, "INSERT IGNORE INTO users (name, email, password, role) VALUES ('Vendor HQ', '$vendor_user_email', '\$2y\$10\$C.Q6U/e5bN5y5L/Z2d3C/.lY3O1/cOz4c0wK2Xzj2x/z6E5Dq.XyO', 'vendor')");
$vendor_user_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$vendor_user_email'"))['id'];

mysqli_query($conn, "INSERT IGNORE INTO vendors (user_id, name, status) VALUES ($vendor_user_id, 'Luxe Official Store', 'approved')");
$vendor_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM vendors WHERE user_id=$vendor_user_id"))['id'];
echo "<p>✅ Vendor added successfully.</p>";


// 3. Insert Premium Products
$products = [
    [
        "name" => "Apple MacBook Air M2",
        "description" => "Supercharged by M2 chip. Incredibly thin and light laptop with a stunning 13.6-inch Liquid Retina display and up to 18 hours of battery life.",
        "price" => 1199.00,
        "stock" => 25,
        "category_id" => $cat_elec,
        "image" => "https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Sony WH-1000XM5 Headphones",
        "description" => "Industry-leading noise cancellation. Exceptional sound quality with newly developed drivers and up to 30-hour battery life.",
        "price" => 348.00,
        "stock" => 50,
        "category_id" => $cat_elec,
        "image" => "https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Minimalist Ceramic Coffee Mug",
        "description" => "Handcrafted ceramic mug with a matte finish. Perfect for your morning coffee or evening tea. Microwave and dishwasher safe.",
        "price" => 24.50,
        "stock" => 120,
        "category_id" => $cat_home,
        "image" => "https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Luxury Men's Chronograph Watch",
        "description" => "Elegant stainless steel chronograph watch featuring a sapphire crystal dial, water resistance up to 50m, and a premium leather strap.",
        "price" => 295.00,
        "stock" => 15,
        "category_id" => $cat_men,
        "image" => "https://images.unsplash.com/photo-1524592094714-0f0654e20314?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Satin Slip Silk Dress",
        "description" => "A beautifully curated silk blend dress with a flattering cowl neckline and adjustable straps. Perfect for evening occasions.",
        "price" => 110.00,
        "stock" => 40,
        "category_id" => $cat_women,
        "image" => "https://images.unsplash.com/photo-1595777457583-95e059d581b8?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Organic Vitamin C Serum",
        "description" => "Advanced antioxidant formula designed to target the most common signs of aging including brightness, firmness, fine lines, and dark spots.",
        "price" => 35.00,
        "stock" => 85,
        "category_id" => $cat_beauty,
        "image" => "https://images.unsplash.com/photo-1620916566398-39f1143ab7be?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Smart Home Security Camera",
        "description" => "1080p HD indoor, plug-in security camera with motion detection and two-way audio that lets you monitor the inside of your home.",
        "price" => 59.99,
        "stock" => 60,
        "category_id" => $cat_elec,
        "image" => "https://images.unsplash.com/photo-1557322984-78bb79659a22?fit=crop&w=800&q=80"
    ],
    [
        "name" => "Premium Leather Backpack",
        "description" => "Hand-stitched full-grain leather backpack. Features a dedicated 15-inch laptop compartment and multiple utility pockets.",
        "price" => 185.00,
        "stock" => 30,
        "category_id" => $cat_men,
        "image" => "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?fit=crop&w=800&q=80"
    ]
];

// In the database 'image' column holds just text, we'll store full URLs temporarily for demo purposes.
// Since originally I coded for 'uploads/abc.jpg', we need to gently modify the frontend to allow absolute http URLs too.

foreach ($products as $p) {
    $name = mysqli_real_escape_string($conn, $p['name']);
    $desc = mysqli_real_escape_string($conn, $p['description']);
    $price = $p['price'];
    $stock = $p['stock'];
    $cat_id = $p['category_id'];
    $img = $p['image'];

    // Check if product exists
    $check = mysqli_query($conn, "SELECT id FROM products WHERE name='$name'");
    if(mysqli_num_rows($check) == 0){
        mysqli_query($conn, "INSERT INTO products (vendor_id, name, description, price, stock, image, category_id) VALUES ($vendor_id, '$name', '$desc', $price, $stock, '$img', $cat_id)");
    }
}
echo "<p>✅ 8 Premium Products added successfully.</p>";

echo "<h3>🎉 Database seeded! <a href='index.php'>Click here to go back to the store</a></h3>";
?>
