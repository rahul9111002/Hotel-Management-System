<?php
// Connect to the database
$host = 'localhost'; // Your host
$username = 'root';  // Your database username
$password = '';      // Your database password
$dbname = 'Hotel_Management_System'; // Your database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch room details
$sql = "SELECT room_id, room_number, room_type, price, status FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms - Luxury Stay Hotels</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>

    <div class="hero">
        <div class="hero-text">
            <h1>Available Rooms</h1>
            <p>Choose the perfect room for your stay.</p>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="booking.php">Book Now</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <main>
        <section class="room-table">
            <h2>Our Rooms</h2>
            <?php
            // Check if rooms are available
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Room ID</th><th>Room Number</th><th>Room Type</th><th>Price</th><th>Status</th></tr>";

                // Fetch and display room data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['room_id'] . "</td>";
                    echo "<td>" . $row['room_number'] . "</td>";
                    echo "<td>" . $row['room_type'] . "</td>";
                    echo "<td>₹" . number_format($row['price']) . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No rooms available at the moment.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Luxury Stay Hotels. All rights reserved.</p>
    </footer>

</body>
</html>
