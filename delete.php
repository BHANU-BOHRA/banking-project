<?php
session_start();

$user_data = $_SESSION['user_data'];

$servername = '127.0.0.1:3300';
$username = 'root';
$password = '';
$dbname = 'banking_system';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$q = "delete from customers where customer_id=" . $_SESSION['user_data']['customer_id'] . ";";

if ($conn->query($q)) {
    $_SESSION['has_account'] = false;
    $q = "update accounts set acc_status='inactive' where account_no=" . $_SESSION['acc_dets']['account_no'];

    if ($conn->query($q)) {
        echo "<script>
    alert('Account deleted Successfully...');
    window.location.assign('./index.html');
</script>";
    }
}
?>