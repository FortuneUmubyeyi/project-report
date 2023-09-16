<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST["client_id"];
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    // Insert the new order into the database
    $sql = "INSERT INTO orders (client_id) VALUES (?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $client_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $order_id = mysqli_insert_id($conn);

            // Insert order items into the database
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "iii", $order_id, $product_id, $quantity);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "Order placed successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
    
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
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
//2. update_order_status.php - To update order status:
<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST["order_id"];
    $new_status = $_POST["new_status"];

    // Update the order status in the database
    $sql = "UPDATE orders SET status=? WHERE order_id=?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $new_status, $order_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Order status updated successfully!";
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
//3. get_order_history.php - To retrieve order history for a client:
<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $client_id = $_GET["client_id"];

    // Retrieve order history for the client from the database
    $sql = "SELECT o.order_id, o.order_date, o.status, p.name AS product_name, oi.quantity
            FROM orders o
            INNER JOIN order_items oi ON o.order_id = oi.order_id
            INNER JOIN products p ON oi.product_id = p.product_id
            WHERE o.client_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $client_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $orders = [];
            
            $result = mysqli_stmt_get_result($stmt);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
            
            echo json_encode($orders); // Output as JSON
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