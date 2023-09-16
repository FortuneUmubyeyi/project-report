<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Insert the new product into the database
    $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssd", $name, $description, $price);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
//2. update_product.php - To update product information:


<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Update the product's information in the database
    $sql = "UPDATE products SET name=?, description=?, price=? WHERE product_id=?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssdi", $name, $description, $price, $product_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Product updated successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
//. get_products.php - To retrieve a list of products:
<?php
// Include the database connection code here

// Retrieve a list of products from the database
$sql = "SELECT * FROM products";

if ($result = mysqli_query($conn, $sql)) {
    $products = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    echo json_encode($products); // Output as JSON
    
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>





