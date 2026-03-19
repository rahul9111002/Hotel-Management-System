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

// Query to fetch payment records
$sql = "SELECT payments.payment_id, bookings.booking_id, guests.guest_name, payments.payment_date, payments.amount
        FROM payments
        JOIN bookings ON payments.booking_id = bookings.booking_id
        JOIN guests ON bookings.guest_id = guests.guest_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments - Luxury Stay Hotels</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="hero">
        <div class="hero-text">
            <h1>Payments</h1>
            <p>View all payment transactions.</p>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="booking.php">Book Now</a></li>
            <li><a href="payments.php">Payments</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <main>
        <section class="room-table">
            <h2>Payment Records</h2>
            <?php
            // Check if payments are available
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Payment ID</th><th>Booking ID</th><th>Guest Name</th><th>Payment Date</th><th>Amount</th></tr>";

                // Fetch and display payment data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['booking_id'] . "</td>";
                    echo "<td>" . $row['guest_name'] . "</td>";
                    echo "<td>" . $row['payment_date'] . "</td>";
                    echo "<td>₹" . number_format($row['amount']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No payments recorded.</p>";
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
