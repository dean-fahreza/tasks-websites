<?php
if(empty($_POST["name"])) {
    die("Harap menuliskan Nama terlebih dahulu!");
}
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Harap menuliskan kembali E-Mail secara valid");
}
if(strlen($_POST["password"]) < 8) {
    die("Minimal karakter Password adalah 8 karakter");
} 
if(!preg_match("/[a-z]/i", $_POST['password'])) {
    die("Password harus berisikan satu kata");
}
if(!preg_match("/[0-9]/i", $_POST['password'])) {
    die("Password harus berisikan satu angka");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";
$sql = "INSERT INTO data (name, email, password_hash)
        VALUES (?, ?, ?)";
$stmt = $mysqli->stmt_init();
if(!$stmt -> prepare($sql)) {
    die("SQL Error : ". $mysqli -> error);
}
$stmt->bind_param("sss", 
                  $_POST['name'],
                  $_POST['email'],
                  $password_hash);
$stmt -> execute();
echo "Sign Up Successful!";
