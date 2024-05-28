<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "root", "", "fotografcilik_kulubu");

if ($mysqli->connect_error) {
    die("Bağlantı hatası: " . $mysqli->connect_error);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement kullanarak SQL sorgusu
    $stmt = $mysqli->prepare("SELECT * FROM admins WHERE a_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['a_password'])) {
            $_SESSION['a_no'] = $row['a_no'];
            $_SESSION['a_name'] = $row['a_name'];
            $_SESSION['a_sname'] = $row['a_sname'];
            $_SESSION['a_mail'] = $row['a_mail'];
            header("Location: administration.php");
            exit();
        } else {
            $error = "Hatalı kullanıcı adı veya şifre!";
        }
    } else {
        $error = "Kullanıcı bulunamadı.";
    }

    $stmt->close();
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $sname = $_POST['sname'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $mysqli->prepare("INSERT INTO admins (a_username, a_name, a_sname, a_mail, a_password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $name, $sname, $mail, $hashed_password);

    if ($stmt->execute()) {
        $message = "Yeni yönetici başarıyla kaydedildi.";
    } else {
        $error = "Hata: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotoğrafçılık Kulübü - Giriş</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .container {
            margin-top: 100px;
            max-width: 400px;
            background-color: #495057;
            padding: 20px;
            border-radius: 10px;
        }
        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 200px;
            height: 200px;
        }
        .well {
            background-color: #495057;
            padding: 10px;
            margin-top: 20px;
            width: 100%;
            bottom: 0;
        }
        .well img {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <img src="logo.png" class="logo" alt="Logo">
        <h2 class="my-4">Fotoğrafçılık Kulübü Giriş</h2>
        <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <?php if(isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Giriş Yap</button>
        </form>
        <div class="mt-4">
            <button id="addAdminBtn" class="btn btn-secondary">Yönetici Ekle</button>
        </div>
        <div id="adminForm" class="mt-4" style="display: none;">
            <h3>Yeni Yönetici Ekle</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Kullanıcı Adı:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="name">Ad:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="sname">Soyad:</label>
                    <input type="text" class="form-control" id="sname" name="sname" required>
                </div>
                <div class="form-group">
                    <label for="mail">E-posta:</label>
                    <input type="email" class="form-control" id="mail" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="password">Şifre:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary btn-block">Kaydet</button>
            </form>
        </div>
    </div>
    <div class="well well-sm">
        <p align="center">BTU Fotoğrafçılık Kulubü. <br> Her Hakkı Saklıdır. Copyright &copy; 2024</p>
        <p align="center">
            <a href="https://github.com/kaancardak"><img src="github.png" alt="GitHub" width="60" height="60"></a>
            <a href="https://www.instagram.com/btufotografcilik/"><img src="instagram.png" alt="Instagram" width="60" height="60"></a>
        </p>
    </div>
    <script>
        document.getElementById('addAdminBtn').addEventListener('click', function() {
            var form = document.getElementById('adminForm');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });
    </script>
</body>
</html>
