<?php
$host = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$database = "your_db_name";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
//connection to mysqli_connect
//to add clients
<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Insert the new client into the database
    $sql = "INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Client added successfully!";
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
//to update clients information
<?php
// Include the database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST["client_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Update the client's information in the database
    $sql = "UPDATE clients SET name=?, email=?, phone=? WHERE client_id=?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $client_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Client updated successfully!";
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
//to retrieve clients information
<?php
// Include the database connection code here

// Retrieve a list of clients from the database
$sql = "SELECT * FROM clients";

if ($result = mysqli_query($conn, $sql)) {
    $clients = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $clients[] = $row;
    }
    
    echo json_encode($clients); // Output as JSON
    
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>