<?php

//DZ#3.1

$names = ['Anna', 'Boris', 'Max', 'Olga', 'Alex'];
$users = [];


for ($i = 0; $i <= 50; $i++) {
    $name = $names[array_rand($names, 1)];
    $user = [
        'id' => $i,
        'name' => $name,
        'age' => mt_rand(18, 45)
    ];
    $users[] = $user;
}

foreach ($users as $user) {
    $usNames[] = $user['name'];
    $usAges[] = $user['age'];
}
echo '<pre>';
print_r(array_count_values($usNames));
print_r(array_sum($usAges)/count($usAges));
$json = json_encode($users);
file_put_contents('src/users.json', $json);
$php = json_decode(file_get_contents('src/users.json'), true);

//DZ#3.2

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
