<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Hotel_Management_System';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch guest records
$sql = "SELECT guest_id, guest_name, gender, date_of_birth, email, phone_number FROM guests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guests - Luxury Stay Hotels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="hero">
        <div class="hero-text">
            <h1>Guests</h1>
            <p>View all guest details.</p>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="booking.php">Book Now</a></li>
            <li><a href="guests.php">Guests</a></li>
            <li><a href="payments.php">Payments</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <main>
        <section class="room-table">
            <h2>Guest Records</h2>
            <?php
            // Check if guests are available
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Guest ID</th><th>Name</th><th>Gender</th><th>Date of Birth</th><th>Email</th><th>Phone</th></tr>";

                // Fetch and display guest data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['guest_id'] . "</td>";
                    echo "<td>" . $row['guest_name'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['date_of_birth'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone_number'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No guest records available.</p>";
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
