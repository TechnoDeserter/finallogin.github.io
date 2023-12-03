<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

include 'db_config.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
} else {
    // Handle error, user not found
    echo "Error: User not found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<style>
    .dash {
       display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;

    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body>

    <!-- Your dashboard content goes here -->
    <!-- Add a logout link or button -->
    <div class="container">
        <div class="dash">
            <h1>Welcome, <?php echo $name; ?>!</h1>
            <br>
            <button type="button" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>

</html>