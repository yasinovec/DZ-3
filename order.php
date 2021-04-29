<?php

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $name = $_GET["name"];
    $street = $_GET['street'];
    $home = $_GET['home'];
    $part = $_GET['part'];
    $appt = $_GET['appt'];
    $floor = $_GET['floor'];
}
$connect = mysqli_connect("localhost", "root", "root", "orders");
if ($email) {
    $chkEmail = "SELECT email FROM users WHERE email = '$email'";
    $zap = mysqli_query($connect, $chkEmail);
}
if (!$zap) {
    print_r(mysqli_error($connect));
    die;
}
$res=mysqli_fetch_assoc($zap);
echo '<pre>'. print_r($res). '</pre>';

if ($email==$res['email']) {
    $connect = mysqli_connect("localhost", "root", "root", "orders");
    $query = "INSERT INTO orders (user_id, datas, addess) SELECT id, CURRENT_TIMESTAMP, street FROM users WHERE email='$email'";
    $getId = "SELECT MAX(`no`) FROM orders, users WHERE users.id=orders.user_id AND email='$email'";
    mysqli_query($connect, $query);
    mysqli_query($connect, $getId);
    $idd = mysqli_query($connect, $getId);
    $id = mysqli_fetch_assoc($idd);
    echo 'Спасибо, ваш заказ будет доставлен по адресу: ' . $street . $home . $part . $appt . $floor . '<br>';
    echo 'Номер вашего заказа: ' . $id['MAX(`no`)'];
} else {
    $connect = mysqli_connect("localhost", "root", "root", "orders");
    $query = "INSERT INTO users (`names`, email, street, home, part, appt, floor) VALUES
    ('$name','$email','$street','$home','$part','$appt','$floor')";
    mysqli_query($connect, $query);
    echo 'Спасибо, ваш заказ будет доставлен по адресу: ' . $street . $home . $part . $appt . $floor . '<br>';
    echo 'Номер вашего заказа: ' . $id['MAX(`no`)'];
    $connect->close();
}

//$connect = mysqli_connect("localhost", "root", "root", "orders");
//$query = "INSERT INTO orders (`name`, phone, email, street, home, part, appt, floor) VALUES
//('$name','$phone','$email','$street','$home','$part','$appt','$floor')";
//mysqli_query($connect, $query);
//$connect->close();
//header('location: index.html');