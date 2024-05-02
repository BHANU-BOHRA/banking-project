<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposite</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/styes.css">
</head>

<?php
session_start();
if ($_SESSION['has_account'] == false) {
    echo "<script>alert('You don\'t have an account.);
            window.location.assign('dashboard.php');</script>";
}
$user_data = $_SESSION['user_data'];
$acc_dets=$_SESSION['acc_dets'];
?>

<body class="account">
    <header>
        <img src="./assets/images/logo-2.png" alt="logo">
        <div>
            <p>Welcome to Our Online Banking Platform: Secure Banking Anytime, Anywhere</p>
        </div>
    </header>

    <main>
        <div class="card">
            <h1>Deposite</h1>

            <form action="./service.php" method="post">
                <div class="input">
                    <label for="account_no">Account Number : </label>
                    <input type="text" value="<?php echo $acc_dets['account_no']; ?>" id="account_no" disabled>
                </div>
                <div class="input">
                    <label for="name">Name : </label>
                    <input type="text" value="<?php echo $user_data['cust_name']; ?>" id="name" disabled>
                </div>
                <div class="input">
                    <label for="phone">Phone No. : </label>
                    <input type="text" value="<?php echo $user_data['phone']; ?>" disabled>
                </div>
                <div class="input">
                    <label for="dob">Date of Birth : </label>
                    <input type="date" value="<?php echo $user_data['dob']; ?>" disabled>
                </div>
                <div class="input">
                    <label for="init_amt">Amount to Deposite : </label>
                    <input type="text" id="init_amt" name="amt" placeholder="Enter Amount" required>
                </div>
                <input type="text" value="deposite" class="service_choosen" name="service_choosen">
                <input type="submit" class="underline">
            </form>
        </div>
    </main>

    <footer>
        <p>© All Rights Reserved</p>
        <p class="saprater">|</p>
        <p> Stay connected with us for the latest updates, promotions, and tips to manage your finances effectively.</p>
        <p class="saprater">|</p>
        <p>Made with ❤️ by Adolf Hitler</p>
    </footer>
</body>

</html>