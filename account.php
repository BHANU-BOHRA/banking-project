<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/styes.css">
</head>

<?php
session_start();
if ($_SESSION['has_account'] == true) {
    echo "<script>alert('You already have an account');
            window.location.assign('dashboard.php');</script>";
}
$user_data = $_SESSION['user_data'];
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
            <h1>Form to Open an Account</h1>

            <form action="./service.php" method="post">
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
                    <label for="acc_type">Type of Account : </label>
                    <select name="acc_type" id="acc_type" required>
                        <option value="current">Current Account</option>
                        <option value="zero">Zero Balance Account</option>
                        <option value="savings">Savings Account</option>
                    </select>
                </div>
                <div class="input">
                    <label for="init_amt">Amount to Deposite : </label>
                    <input type="text" id="init_amt" name="init_amt" placeholder="Amount to Start with" required>
                </div>
                <input type="text" value="account" class="service_choosen" name="service_choosen">
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