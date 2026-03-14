<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../db.php";

$sql = "SELECT p.*, c.name as category_name, v.name as vendor_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN vendors v ON p.vendor_id = v.id ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $sql);

$products = array();
$products['records'] = array();

if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $product_item = array(
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => html_entity_decode($row['description']),
            "price" => $row['price'],
            "category" => $row['category_name'] ?? 'Uncategorized',
            "vendor" => $row['vendor_name'] ?? 'Admin',
            "image" => $row['image'] ? 'uploads/'.$row['image'] : null,
            "stock" => $row['stock'],
            "created_at" => $row['created_at']
        );
        array_push($products['records'], $product_item);
    }
    http_response_code(200);
    echo json_encode($products);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No products found."));
}
?>
