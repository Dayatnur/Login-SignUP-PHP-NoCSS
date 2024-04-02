<?php
    include "service/database.php";
    session_start();

    $register_message = "";
    
    if (isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        
    
        try {
            // Cek apakah username sudah ada dalam database
            $check_sql = "SELECT * FROM users WHERE username = '$username'";
            $check_result = $db->query($check_sql);
    
            if ($check_result->num_rows > 0) {
                $register_message = "Username sudah digunakan. Silakan pilih username lain.";
            } else {
                $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')"; 
    
                if($db->query($sql)){
                    $register_message = "Daftar akun berhasil, silahkan login";
                } else {
                    $register_message = "Daftar akun gagal, silahkan daftar ulang";
                }
            }
        } catch (Exception $e) {
            $register_message = "Terjadi kesalahan: " . $e->getMessage();
        }
        $db->close();
    }
?>
       



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initi  al-scale=1.0">
    <title>Register</title>
</head>
<body>
    <?php include "layout/header.html" ?>
    <h3>DAFTAR AKUN </h3>
    <i><?= $register_message ?></i>
    <form action="register.php" method="POST" >
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit" name="register">daftar</button>
    </form>
    <?php include "layout/footer.html" ?>
</body>
</html>
