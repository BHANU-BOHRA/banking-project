<?php

session_start();
date_default_timezone_set("Asia/Calcutta");

if (!$_SERVER['REQUEST_METHOD'] == "POST") exit();

$servername = '127.0.0.1:3300';
$username = 'root';
$password = '';
$dbname = 'banking_system';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if ($_POST['service_choosen'] === 'account') {
    $q = "insert into accounts(customer_id,acc_type,balance,open_date,acc_status,cradit_score) value (
        " . $_SESSION['user_data']['customer_id'] . ",'" . $_POST['acc_type'] . "'," . $_POST['init_amt'] . ",'" . date("Y-m-d") . "','active'," . random_int(450, 600) . "
    );";

    if ($conn->query($q) === TRUE) {
        echo "<br><br>Insertion Sucessful";
        $_SESSION['has_account'] = true;

        echo "<script>
            window.location.assign('./dashboard.php');
        </script>";
    } else {
        echo "Failed to Insert data";
    }
}

if ($_POST['service_choosen'] === 'deposite') {
    $acc_dets = $_SESSION['acc_dets'];

    $q = "update accounts set balance=balance+" . $_POST['amt'] . " where account_no=" . $acc_dets['account_no'] . ";";
    echo $q;

    if ($conn->query($q) === TRUE) {
        echo "<br><br>Updatation Sucessful";

        $q = "insert into transactions(account_no,amount,transaction_date,transaction_type) value(" . $acc_dets['account_no'] . ", " . $_POST['amt'] . ", '" . date("Y-m-d H:i:s") . "', 'credit');";
        if ($conn->query($q) === TRUE) {
            echo "<br><br>Insertion Sucessful";

            echo "<script>
                window.location.assign('./dashboard.php');
            </script>";
        } else {
            echo "Failed to Insert data";
        }

        echo "<script>
            window.location.assign('./dashboard.php');
        </script>";
    } else {
        echo "Failed to Update data";
    }
}

if ($_POST['service_choosen'] === 'withdraw') {
    $acc_dets = $_SESSION['acc_dets'];

    if ($acc_dets['balance'] < $_POST['amt']) {
        echo "<script>
            alert('Insufficient Funds');
            window.location.assign('./withdraw.php');
        </script>";
        exit(1);
    }

    $q = "update accounts set balance=balance-" . $_POST['amt'] . " where account_no=" . $acc_dets['account_no'] . ";";
    echo $q;

    if ($conn->query($q) === TRUE) {
        echo "<br><br>Updatation Sucessful";

        $q = "insert into transactions(account_no,amount,transaction_date,transaction_type) value(" . $acc_dets['account_no'] . ", " . $_POST['amt'] . ", '" . date("Y-m-d H:i:s") . "', 'debit');";
        if ($conn->query($q) === TRUE) {
            echo "<br><br>Insertion Sucessful";

            echo "<script>
                window.location.assign('./dashboard.php');
            </script>";
        } else {
            echo "Failed to Insert data";
        }

        echo "<script>
            window.location.assign('./dashboard.php');
        </script>";
    } else {
        echo "Failed to Update data";
    }
}


if ($_POST['service_choosen'] === 'transfer') {

    $q = "select * from accounts where account_no=" . $_POST['receiver'] . ";";
    $result = $conn->query($q);
    $sen = $_SESSION['acc_dets'];

    if ($result->num_rows > 0 && $sen['account_no'] != $_POST['receiver']) {
        $rec = $result->fetch_assoc();

        if ($sen['balance'] < $_POST['amt']) {
            echo "<script>
                alert('Insufficient Funds');
                window.location.assign('./transfer.php');
            </script>";
            exit(1);
        }

        $q = "update accounts set balance=balance-" . $_POST['amt'] . " where account_no=" . $sen['account_no'] . ";";
        $s = $conn->query($q);

        $q = "update accounts set balance=balance+" . $_POST['amt'] . " where account_no=" . $rec['account_no'] . ";";

        if ($conn->query($q) === TRUE && $s === TRUE) {
            echo "<br><br>Updatation Sucessful";

            $q = "insert into transactions(account_no,amount,transaction_date,transaction_type) value(" . $sen['account_no'] . ", " . $_POST['amt'] . ", '" . date("Y-m-d H:i:s") . "', 'debit');";
            $s = $conn->query($q);
            $q = "insert into transactions(account_no,amount,transaction_date,transaction_type) value(" . $rec['account_no'] . ", " . $_POST['amt'] . ", '" . date("Y-m-d H:i:s") . "', 'credit');";
            $r = $conn->query($q);

            $q = "insert into transfers(sender,amount,receiver,transfer_date) value(" . $sen['account_no'] . ", " . $_POST['amt'] . ", " . $rec['account_no'] . ", '" . date("Y-m-d H:i:s") . "');";
            if ($conn->query($q) === TRUE && $s === TRUE && $r === TRUE) {
                echo "<br><br>Insertion Sucessful";

                echo "<script>
                    window.location.assign('./dashboard.php');
                </script>";
            } else {
                echo "Failed to Insert data";
            }

            echo "<script>
                window.location.assign('./dashboard.php');
            </script>";
        } else {
            echo "Failed to Update data";
        }
    } else {
        echo "<script>
                alert('Invaild Account Number for Receiver.');
                window.location.assign('./transfer.php');
            </script>";
    }
}
