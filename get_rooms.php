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

if (isset($_GET['branch_id']))
{
    $branch_id = $_GET['branch_id'];
    $sql = "SELECT room_id, room_number FROM rooms WHERE branch_id='$branch_id' AND status='Available'";
    $result = $conn->query($sql);

    $rooms = [];
    while ($row = $result->fetch_assoc())
    {
        $rooms[] = $row;
    }

    echo json_encode($rooms);
}

$conn->close();
?>
