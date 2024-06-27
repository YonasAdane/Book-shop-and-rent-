
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /LetsGO/auth/login.php");
    exit();
}

include("../database/connection.php");

$userID = $_SESSION['user_id'];
$userQuery = "SELECT * FROM User WHERE UserID = $userID";
$userResult = $conn->query($userQuery);
$userData = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $userName = $_POST['user_name'];
    $userEmail = $_POST['user_email'];
    $userAddress = $_POST['user_address'];
    $userPhone = $_POST['user_phone'];
    
    $updateQuery = "UPDATE User SET UserName='$userName', UserEmail='$userEmail', UserAddress='$userAddress', UserPhone='$userPhone' WHERE UserID = $userID";
    
    if ($conn->query($updateQuery) === TRUE) {
        $message = "Profile updated successfully.";
        $userData['UserName'] = $userName;
        $userData['UserEmail'] = $userEmail;
        $userData['UserAddress'] = $userAddress;
        $userData['UserPhone'] = $userPhone;
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

$bookingQuery = "SELECT * FROM Ticket WHERE UserID = $userID";
$bookingResult = $conn->query($bookingQuery);

$paymentQuery = "SELECT * FROM Payment WHERE UserID = $userID";
$paymentResult = $conn->query($paymentQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container sm:w-4/5 mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">User Profile</h1>
    
    <?php if(isset($message)): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="user_name" class="block text-gray-700">Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $userData['UserName']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="user_email" class="block text-gray-700">Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo $userData['UserEmail']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="user_address" class="block text-gray-700">Address:</label>
                <input type="text" id="user_address" name="user_address" value="<?php echo $userData['UserAddress']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="user_phone" class="block text-gray-700">Phone:</label>
                <input type="text" id="user_phone" name="user_phone" value="<?php echo $userData['UserPhone']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <input type="submit" name="update_info" value="Update Information" class="p-2 rounded-lg px-4 bg-blue-400 text-white border-none">
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-2xl font-bold mb-4">Booking History</h2>
        <?php if ($bookingResult->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Ticket ID</th>
                            <th class="py-2 px-4 border-b">Departure City</th>
                            <th class="py-2 px-4 border-b">Destination City</th>
                            <th class="py-2 px-4 border-b">Departure Date</th>
                            <th class="py-2 px-4 border-b">Arrival Date</th>
                            <th class="py-2 px-4 border-b">Price</th>
                            <th class="py-2 px-4 border-b">Seat Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $bookingResult->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo $booking['TicketID']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['DepartureCity']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['DestinationCity']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['DepartureDateTime']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['ArrivalDateTime']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['Price']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $booking['SeatNumber']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-red-500">No booking history found.</p>
        <?php endif; ?>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-2xl font-bold mb-4">Payment Methods</h2>
        <?php if ($paymentResult->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Payment ID</th>
                            <th class="py-2 px-4 border-b">Payment Method</th>
                            <th class="py-2 px-4 border-b">Price</th>
                            <th class="py-2 px-4 border-b">Transaction Date</th>
                            <th class="py-2 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($payment = $paymentResult->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo $payment['PaymentID']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $payment['PaymentMethod']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $payment['Price']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $payment['TransactionDateTime']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $payment['Status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-red-500">No payment methods found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
