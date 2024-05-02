<?php
    session_start();

    if(!$_SERVER['REQUEST_METHOD']=="POST") exit();
    
    $servername='127.0.0.1:3300';
    $username='root';
    $password='';
    $dbname='banking_system';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    

    if(count($_POST)==2){
        $q="select * from customers where cust_name='".$_POST['user']."' and login_password='".$_POST['pass']."';";
        $result=$conn->query($q);

        if($result->num_rows==0){
            echo "<script>
                window.location.assign('./index.html');
            </script>";
        }
        else{
            $_SESSION['user_data']=$result->fetch_assoc();
            $_SESSION['has_account']=false;

            echo "<script>
                window.location.assign('./dashboard.php');
            </script>";
        }
    }
    else{
        $q="insert into customers(cust_name,login_password,address,phone,email,dob) value (
            '".$_POST['user']."','".$_POST['pass']."','".$_POST['address']."','".$_POST['phone']."','".$_POST['email']."','".$_POST['dob']."'"."
        );";
        
        if($conn->query($q) === TRUE){
            echo "<br><br>Insertion Sucessful";
            echo "<script>
                window.location.assign('./index.html');
            </script>";
        }
        else{
            echo "Failed to Insert data";
        }

        // $result=$conn->query("select * from customers");

        // while($r=$result->fetch_assoc()){
        //     foreach($r as $k=>$v){
        //         echo "<br>";
        //         echo "$k : $v ";
        //     }
        // }
    }

    $conn->close();
?>