<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Hotel_Management_System';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$branches_sql = "SELECT branch_id, branch_name FROM branches";
$branches_result = $conn->query($branches_sql);

// Fetch room price when a room is selected
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $room_price_sql = "SELECT price FROM rooms WHERE room_id='$room_id'";
    $room_price_result = $conn->query($room_price_sql);
    $room_price = $room_price_result->fetch_assoc()['price'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guest_name = $_POST['guest_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $branch_id = $_POST['branch_id'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $amount = $_POST['amount'];  // Amount entered by user

    // Insert into guests
    $insert_guest = "INSERT INTO guests (guest_name, gender, date_of_birth, email, phone_number)
                     VALUES ('$guest_name', '$gender', '$dob', '$email', '$phone')";
    $conn->query($insert_guest);
    $guest_id = $conn->insert_id;

    // Insert into bookings
    $insert_booking = "INSERT INTO bookings (guest_id, branch_id, room_id, check_in_date, check_out_date, booking_status)
                       VALUES ('$guest_id', '$branch_id', '$room_id', '$check_in', '$check_out', 'Confirmed')";
    $conn->query($insert_booking);

    // Get the booking ID
    $booking_id = $conn->insert_id;

    // Insert into payments
    $payment_date = date('Y-m-d');  // Current date for payment
    $insert_payment = "INSERT INTO payments (booking_id, payment_date, amount)
                       VALUES ('$booking_id', '$payment_date', '$amount')";
    $conn->query($insert_payment);

    // Update room status to Booked
    $update_room = "UPDATE rooms SET status='Booked' WHERE room_id='$room_id'";
    $conn->query($update_room);

    echo "<script>alert('Booking successful!'); window.location.href='booking.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Room - Luxury Stay Hotels</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing styles */
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="booking.php">Book Now</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <div class="booking-form">
        <h2>Book a Room</h2>
        <form method="POST" action="">
            <label>Full Name:</label>
            <input type="text" name="guest_name" required>

            <label>Gender:</label>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>

            <label>Date of Birth:</label>
            <input type="date" name="dob" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone Number:</label>
            <input type="text" name="phone" required>

            <label>Select Branch:</label>
            <select name="branch_id" id="branch_id" required>
                <option value="">Select Branch</option>
                <?php while ($row = $branches_result->fetch_assoc()) { ?>
                    <option value="<?= $row['branch_id'] ?>"><?= $row['branch_name'] ?></option>
                <?php } ?>
            </select>

            <label>Select Room:</label>
            <select name="room_id" id="room_id" required>
                <option value="">Select Room</option>
            </select>

            <label>Check-in Date:</label>
            <input type="date" name="check_in" required>

            <label>Check-out Date:</label>
            <input type="date" name="check_out" required>

            <label>Amount (₹):</label>
            <input type="number" name="amount" value="<?= isset($room_price) ? $room_price : '' ?>" required>

            <button type="submit">Confirm Booking</button>
        </form>
    </div>

    <script>
        document.getElementById('branch_id').addEventListener('change', function () {
            const branchId = this.value;
            const roomSelect = document.getElementById('room_id');

            fetch('get_rooms.php?branch_id=' + branchId)
                .then(response => response.json())
                .then(data => {
                    roomSelect.innerHTML = '<option value="">Select Room</option>';
                    data.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.room_id;
                        option.text = room.room_number;
                        roomSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading rooms:', error));
        });
    </script>

</body>
</html>
