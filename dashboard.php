<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styes.css">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>

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

$result = $conn->query('select * from accounts where customer_id=' . $user_data['customer_id'] . ';');
if ($result->num_rows == 0) $_SESSION['has_account'] = false;
else {
    $_SESSION['has_account'] = true;
    $_SESSION['acc_dets'] = $result->fetch_assoc();
}

?>

<body class="dash">
    <header>
        <a href="./index.html"><img src="./assets/images/logo-2.png" alt="logo"></a>
        <div>
            <p>Welcome to Our Online Banking Platform: Secure Banking Anytime, Anywhere</p>
        </div>
    </header>

    <main>
        <div class="score">
            <?php if (!$_SESSION['has_account']) : ?>
                <p>You currently don't have an active account.</p>
                <button onclick="window.location.assign('account.php');"> Create Account</button>
            <?php else : ?>
                <div class="acc_no">
                    <span>Account Number : </span>
                    <input readonly type="password" value="<?php echo $_SESSION['acc_dets']['account_no']; ?>" id="pass">
                    <button onclick="toggleView('pass','acc_number')"><img id="acc_number" src="./assets/images/view.png" alt="eye"></button>
                </div>
                <div class="acc_no acc_bal">
                    <span>Balance : </span>
                    <input readonly type="password" value="<?php echo $_SESSION['acc_dets']['balance']; ?>" id="bal">
                    <button onclick="toggleView('bal','balance')"><img id="balance" src="./assets/images/view.png" alt="eye"></button>
                </div>
                <div class="log">
                    <h2>Account Logs</h2>
                    <div class="tab">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $q = "select date(transaction_date) 'date',time(transaction_date) 'time',if(transaction_type='debit',-amount,amount) amount from transactions where account_no=".$_SESSION['acc_dets']['account_no'].";";
                                $result = $conn->query($q);
                                
                                if ($result->num_rows > 0) {
                                  // output data of each row
                                  while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                    <td>".$row['date']."</td>
                                    <td>".$row['time']."</td>";

                                    if($row['amount']<0) echo '<td class="less">'.$row['amount'].'</td>';
                                    else echo '<td class="more">+'.$row['amount'].'</td>';
                                    
                                echo "</tr>";
                                  }
                                }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="right">
            <h1>Hi, <?php echo $user_data['cust_name']; ?></h1>
            <p class="note">Welcome to Online Bank!<br>

                We're thrilled to have you here. We're dedicated to providing you with convenient, secure, and innovative banking solutions tailored to your needs. <br><br>

                Whether you're checking your account balance, transferring funds, or managing your finances, our user-friendly platform is designed to make your banking experience seamless and efficient. <br><br>

                Your trust and satisfaction are our top priorities. Rest assured, your financial well-being is in safe hands with us. <br><br>

                Thank you for choosing us for your banking needs. Let's embark on this journey together towards financial success! <br><br>

                <span>What Service you want to use :-</span>
            </p>
            <div class="opt">
                <button onclick="window.location.assign('transfer.php');">Transfer</button>
                <button onclick="window.location.assign('deposite.php');">Deposite</button>
                <button onclick="window.location.assign('withdraw.php');">With Draw</button>

                <?php if ($_SESSION['has_account']) : ?>
                    <button onclick="delAcc()" class="del">Delete Account</button>
                <?php endif; ?>

                <!-- <button onclick="window.location.assign('loan.php');">Apply for Loan</button> -->
            </div>
        </div>
    </main>

    <footer>
        <p>© All Rights Reserved</p>
        <p class="saprater">|</p>
        <p> Stay connected with us for the latest updates, promotions, and tips to manage your finances effectively.</p>
        <p class="saprater">|</p>
        <p>Made with ❤️ by Adolf Hitler</p>
    </footer>

    <script>
        function toggleView(a, b) {
            let pass = document.getElementById(a);
            let btn = document.getElementById(b);

            console.log(pass.type);
            console.log(btn.innerHTML);

            if (pass.type == 'text') {
                pass.type = 'password';
                btn.src = './assets/images/view.png';
            } else if (pass.type == 'password') {
                pass.type = 'text';
                btn.src = './assets/images/hide.png';
            }
        };

        function delAcc() {
            if (confirm("Do you want to delete your account")) {
                window.location.assign('delete.php');
            }
        }
    </script>
</body>

</html>