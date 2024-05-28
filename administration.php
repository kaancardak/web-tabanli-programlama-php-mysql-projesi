<?php
session_start();

if (!isset($_SESSION['a_no'])) {
    header("Location: index.php");
    exit();
}

$mysqli = new mysqli("127.0.0.1", "root", "", "fotografcilik_kulubu");

if ($mysqli->connect_error) {
    die("Bağlantı hatası: " . $mysqli->connect_error);
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $sname = $_POST['sname'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins (a_username, a_name, a_sname, a_mail, a_password) VALUES ('$username', '$name', '$sname', '$mail', '$hashed_password')";

    if ($mysqli->query($sql) === TRUE) {
        $message = "Yeni yönetici başarıyla kaydedildi.";
    } else {
        $error = "Hata: " . $sql . "<br>" . $mysqli->error;
    }
}

if (isset($_POST['submit_data'])) {
    $table = $_POST['table'];
    if ($table == 'members') {
        $name = $_POST['m_name'];
        $sname = $_POST['m_sname'];
        $dob = $_POST['m_dob'];
        $gsm = $_POST['m_gsm'];
        $mail = $_POST['m_mail'];
        $dojoin = $_POST['m_dojoin'];
        $type = $_POST['type'];
        $camera = $_POST['m_camera'];
        $lens1 = $_POST['m_lens1'];
        $lens2 = $_POST['m_lens2'];
        $lens3 = $_POST['m_lens3'];

        $sql = "INSERT INTO members (m_name, m_sname, m_dob, m_gsm, m_mail, m_dojoin, type, m_camera, m_lens1, m_lens2, m_lens3) VALUES ('$name', '$sname', '$dob', '$gsm', '$mail', '$dojoin', '$type', '$camera', '$lens1', '$lens2', '$lens3')";
    } elseif ($table == 'equipments') {
        $type = $_POST['eq_type'];
        $manufacturer = $_POST['eq_manufacturer'];
        $producedate = $_POST['eq_producedate'];
        $condition = $_POST['eq_condition'];
        $owner_no = $_POST['m_no'];

        $sql = "INSERT INTO equipments (eq_type, eq_manufacturer, eq_producedate, eq_condition, m_no) VALUES ('$type', '$manufacturer', '$producedate', '$condition', '$owner_no')";
    } elseif ($table == 'events') {
        $date = $_POST['ev_date'];
        $location = $_POST['ev_location'];
        $theme = $_POST['ev_theme'];

        $sql = "INSERT INTO events (ev_date, ev_location, ev_theme) VALUES ('$date', '$location', '$theme')";
    } elseif ($table == 'participants') {
        $ev_no = $_POST['ev_no'];
        $m_no = $_POST['m_no'];
        $pa_date = $_POST['pa_date'];
        $camera = $_POST['m_camera'];
        $lens1 = $_POST['m_lens1'];
        $lens2 = $_POST['m_lens2'];
        $lens3 = $_POST['m_lens3'];

        $sql = "INSERT INTO participants (ev_no, m_no, pa_date, m_camera, m_lens1, m_lens2, m_lens3) VALUES ('$ev_no', '$m_no', '$pa_date', '$camera', '$lens1', '$lens2', '$lens3')";
    } elseif ($table == 'admins') {
        $username = $_POST['a_username'];
        $name = $_POST['a_name'];
        $sname = $_POST['a_sname'];
        $mail = $_POST['a_mail'];
        $password = $_POST['a_password'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO admins (a_username, a_name, a_sname, a_mail, a_password) VALUES ('$username', '$name', '$sname', '$mail', '$hashed_password')";
    }

    if ($mysqli->query($sql) === TRUE) {
        $message = "Veri başarıyla kaydedildi.";
    } else {
        $error = "Hata: " . $sql . "<br>" . $mysqli->error;
    }
}

if (isset($_POST['delete_data'])) {
    $table = $_POST['table'];
    $primaryKey = $_POST['primary_key'];

    if ($table == 'members') {
        $sql = "DELETE FROM members WHERE m_no='$primaryKey'";
    } elseif ($table == 'equipments') {
        $sql = "DELETE FROM equipments WHERE eq_no='$primaryKey'";
    } elseif ($table == 'events') {
        $sql = "DELETE FROM events WHERE ev_no='$primaryKey'";
    } elseif ($table == 'participants') {
        $sql = "DELETE FROM participants WHERE ev_no='$primaryKey' AND m_no='$primaryKey'";
    } elseif ($table == 'admins') {
        $sql = "DELETE FROM admins WHERE a_no='$primaryKey'";
    }

    if ($mysqli->query($sql) === TRUE) {
        $message = "Veri başarıyla silindi.";
    } else {
        $error = "Hata: " . $sql . "<br>" . $mysqli->error;
    }
}

if (isset($_POST['update_data'])) {
    $table = $_POST['table'];
    $primaryKey = $_POST['primary_key'];

    if ($table == 'members') {
        $name = $_POST['m_name'];
        $sname = $_POST['m_sname'];
        $dob = $_POST['m_dob'];
        $gsm = $_POST['m_gsm'];
        $mail = $_POST['m_mail'];
        $dojoin = $_POST['m_dojoin'];
        $type = $_POST['type'];
        $camera = $_POST['m_camera'];
        $lens1 = $_POST['m_lens1'];
        $lens2 = $_POST['m_lens2'];
        $lens3 = $_POST['m_lens3'];

        $sql = "UPDATE members SET m_name='$name', m_sname='$sname', m_dob='$dob', m_gsm='$gsm', m_mail='$mail', m_dojoin='$dojoin', type='$type', m_camera='$camera', m_lens1='$lens1', m_lens2='$lens2', m_lens3='$lens3' WHERE m_no='$primaryKey'";
    } elseif ($table == 'equipments') {
        $type = $_POST['eq_type'];
        $manufacturer = $_POST['eq_manufacturer'];
        $producedate = $_POST['eq_producedate'];
        $condition = $_POST['eq_condition'];
        $owner_no = $_POST['m_no'];

        $sql = "UPDATE equipments SET eq_type='$type', eq_manufacturer='$manufacturer', eq_producedate='$producedate', eq_condition='$condition', m_no='$owner_no' WHERE eq_no='$primaryKey'";
    } elseif ($table == 'events') {
        $date = $_POST['ev_date'];
        $location = $_POST['ev_location'];
        $theme = $_POST['ev_theme'];

        $sql = "UPDATE events SET ev_date='$date', ev_location='$location', ev_theme='$theme' WHERE ev_no='$primaryKey'";
    } elseif ($table == 'participants') {
        $ev_no = $_POST['ev_no'];
        $m_no = $_POST['m_no'];
        $pa_date = $_POST['pa_date'];
        $camera = $_POST['m_camera'];
        $lens1 = $_POST['m_lens1'];
        $lens2 = $_POST['m_lens2'];
        $lens3 = $_POST['m_lens3'];

        $sql = "UPDATE participants SET ev_no='$ev_no', m_no='$m_no', pa_date='$pa_date', m_camera='$camera', m_lens1='$lens1', m_lens2='$lens2', m_lens3='$lens3' WHERE ev_no='$primaryKey' AND m_no='$primaryKey'";
    } elseif ($table == 'admins') {
        $username = $_POST['a_username'];
        $name = $_POST['a_name'];
        $sname = $_POST['a_sname'];
        $mail = $_POST['a_mail'];
        $password = $_POST['a_password'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "UPDATE admins SET a_username='$username', a_name='$name', a_sname='$sname', a_mail='$mail', a_password='$hashed_password' WHERE a_no='$primaryKey'";
    }

    if ($mysqli->query($sql) === TRUE) {
        $message = "Veri başarıyla güncellendi.";
    } else {
        $error = "Hata: " . $sql . "<br>" . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Paneli</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .container {
            margin-top: 50px;
            max-width: 800px;
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
        .table-responsive {
            overflow-x: auto;
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
        <h2 class="my-4">Yönetim Paneli</h2>
        <h4>Hoşgeldiniz, <?php echo $_SESSION['a_name']; ?>!</h4>
        <div class="mt-4">
            <button id="addAdminBtn" class="btn btn-secondary">Yönetici Ekle</button>
            <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
        </div>
        <div id="adminForm" class="mt-4" style="display: none;">
            <h3>Yeni Yönetici Ekle</h3>
            <?php if(isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
            <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
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
        <div class="mt-4">
            <h5>Tablolar ve İşlemler</h5>
            <form method="POST" action="">
                <div class="form-group">
                    <select class="form-control" id="table" name="table" required>
                        <option value="">Tablo Seçin</option>
                        <option value="members">Üyeler</option>
                        <option value="equipments">Ekipmanlar</option>
                        <option value="events">Etkinlikler</option>
                        <option value="participants">Katılımcılar</option>
                        <option value="admins">Yöneticiler</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="action" name="action" required>
                        <option value="">İşlem Seçin</option>
                        <option value="insert">Bilgi giriş ve kaydetme</option>
                        <option value="list">Girilen bilgileri listeleme</option>
                        <option value="delete">Girilen bilgileri silme</option>
                        <option value="update">Girilen bilgileri düzenleme</option>
                    </select>
                </div>
                <button type="submit" name="select" class="btn btn-primary btn-block">Seç</button>
            </form>
        </div>

        <?php
        if (isset($_POST['select'])) {
            $table = $_POST['table'];
            $action = $_POST['action'];

            if ($action == 'insert') {
                echo '<div class="mt-4">';
                echo '<h3>Yeni Veri Girişi: ' . ucfirst($table) . '</h3>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="table" value="' . $table . '">';
                
                if ($table == 'members') {
                    echo '<div class="form-group"><label for="m_name">Adı:</label><input type="text" class="form-control" id="m_name" name="m_name" required></div>';
                    echo '<div class="form-group"><label for="m_sname">Soyadı:</label><input type="text" class="form-control" id="m_sname" name="m_sname" required></div>';
                    echo '<div class="form-group"><label for="m_dob">Doğum Tarihi:</label><input type="date" class="form-control" id="m_dob" name="m_dob" required></div>';
                    echo '<div class="form-group"><label for="m_gsm">Telefon:</label><input type="text" class="form-control" id="m_gsm" name="m_gsm" required></div>';
                    echo '<div class="form-group"><label for="m_mail">E-posta:</label><input type="email" class="form-control" id="m_mail" name="m_mail" required></div>';
                    echo '<div class="form-group"><label for="m_dojoin">Katılım Tarihi:</label><input type="date" class="form-control" id="m_dojoin" name="m_dojoin" required></div>';
                    echo '<div class="form-group"><label for="type">Dal:</label><select class="form-control" id="type" name="type" required>';
                    echo '<option value="sokak">Sokak</option>';
                    echo '<option value="doğa">Doğa</option>';
                    echo '<option value="portre">Portre</option>';
                    echo '<option value="astro">Astro</option>';
                    echo '<option value="reklam">Reklam</option>';
                    echo '<option value="makro">Makro</option>';
                    echo '<option value="düğün">Düğün</option>';
                    echo '</select></div>';
                    echo '<div class="form-group"><label for="m_camera">Fotoğraf Makinesi:</label><input type="text" class="form-control" id="m_camera" name="m_camera"></div>';
                    echo '<div class="form-group"><label for="m_lens1">Lens 1:</label><input type="text" class="form-control" id="m_lens1" name="m_lens1"></div>';
                    echo '<div class="form-group"><label for="m_lens2">Lens 2:</label><input type="text" class="form-control" id="m_lens2" name="m_lens2"></div>';
                    echo '<div class="form-group"><label for="m_lens3">Lens 3:</label><input type="text" class="form-control" id="m_lens3" name="m_lens3"></div>';
                } elseif ($table == 'equipments') {
                    echo '<div class="form-group"><label for="eq_type">Ekipman Türü:</label><input type="text" class="form-control" id="eq_type" name="eq_type" required></div>';
                    echo '<div class="form-group"><label for="eq_manufacturer">Üretici Firma:</label><input type="text" class="form-control" id="eq_manufacturer" name="eq_manufacturer" required></div>';
                    echo '<div class="form-group"><label for="eq_producedate">Üretim Yılı:</label><input type="text" class="form-control" id="eq_producedate" name="eq_producedate" required></div>';
                    echo '<div class="form-group"><label for="eq_condition">Güncel Kondisyon:</label><input type="text" class="form-control" id="eq_condition" name="eq_condition" required></div>';
                    echo '<div class="form-group"><label for="m_no">Sahibi Olan Üye No:</label><input type="text" class="form-control" id="m_no" name="m_no" required></div>';
                } elseif ($table == 'events') {
                    echo '<div class="form-group"><label for="ev_date">Etkinlik Tarihi:</label><input type="date" class="form-control" id="ev_date" name="ev_date" required></div>';
                    echo '<div class="form-group"><label for="ev_location">Etkinlik Yeri:</label><input type="text" class="form-control" id="ev_location" name="ev_location" required></div>';
                    echo '<div class="form-group"><label for="ev_theme">Etkinlik Konusu:</label><input type="text" class="form-control" id="ev_theme" name="ev_theme" required></div>';
                } elseif ($table == 'participants') {
                    echo '<div class="form-group"><label for="ev_no">Etkinlik No:</label><input type="text" class="form-control" id="ev_no" name="ev_no" required></div>';
                    echo '<div class="form-group"><label for="m_no">Üye No:</label><input type="text" class="form-control" id="m_no" name="m_no" required></div>';
                    echo '<div class="form-group"><label for="pa_date">Katılım Tarihi:</label><input type="date" class="form-control" id="pa_date" name="pa_date" required></div>';
                    echo '<div class="form-group"><label for="m_camera">Fotoğraf Makinesi:</label><input type="text" class="form-control" id="m_camera" name="m_camera"></div>';
                    echo '<div class="form-group"><label for="m_lens1">Lens 1:</label><input type="text" class="form-control" id="m_lens1" name="m_lens1"></div>';
                    echo '<div class="form-group"><label for="m_lens2">Lens 2:</label><input type="text" class="form-control" id="m_lens2" name="m_lens2"></div>';
                    echo '<div class="form-group"><label for="m_lens3">Lens 3:</label><input type="text" class="form-control" id="m_lens3" name="m_lens3"></div>';
                } elseif ($table == 'admins') {
                    echo '<div class="form-group"><label for="a_username">Kullanıcı Adı:</label><input type="text" class="form-control" id="a_username" name="a_username" required></div>';
                    echo '<div class="form-group"><label for="a_name">Ad:</label><input type="text" class="form-control" id="a_name" name="a_name" required></div>';
                    echo '<div class="form-group"><label for="a_sname">Soyad:</label><input type="text" class="form-control" id="a_sname" name="a_sname" required></div>';
                    echo '<div class="form-group"><label for="a_mail">E-posta:</label><input type="email" class="form-control" id="a_mail" name="a_mail" required></div>';
                    echo '<div class="form-group"><label for="a_password">Şifre:</label><input type="password" class="form-control" id="a_password" name="a_password" required></div>';
                }

                echo '<button type="submit" name="submit_data" class="btn btn-primary btn-block">Kaydet</button>';
                echo '</form>';
                echo '</div>';
            } elseif ($action == 'list') {
                $sql = "SELECT * FROM $table";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="mt-4">';
                    echo '<h3>' . ucfirst($table) . ' Tablosu</h3>';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-dark table-striped">';
                    echo '<thead><tr>';

                    if ($table == 'members') {
                        echo '<th>Üye No</th><th>Adı</th><th>Soyadı</th><th>Doğum Tarihi</th><th>Telefon</th><th>E-posta</th><th>Katılım Tarihi</th><th>Dal</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'equipments') {
                        echo '<th>Ekipman No</th><th>Ekipman Türü</th><th>Üretici Firma</th><th>Üretim Yılı</th><th>Güncel Kondisyon</th><th>Sahibi Olan Üye No</th>';
                    } elseif ($table == 'events') {
                        echo '<th>Etkinlik No</th><th>Etkinlik Tarihi</th><th>Etkinlik Yeri</th><th>Etkinlik Konusu</th>';
                    } elseif ($table == 'participants') {
                        echo '<th>Etkinlik No</th><th>Üye No</th><th>Katılım Tarihi</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'admins') {
                        echo '<th>Yönetici No</th><th>Kullanıcı Adı</th><th>Adı</th><th>Soyadı</th><th>E-posta</th>';
                    }

                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="mt-4 alert alert-info">Tabloda veri bulunmamaktadır.</div>';
                }
            } elseif ($action == 'delete') {
                $sql = "SELECT * FROM $table";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="mt-4">';
                    echo '<h3>' . ucfirst($table) . ' Tablosu</h3>';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-dark table-striped">';
                    echo '<thead><tr>';

                    if ($table == 'members') {
                        echo '<th>Üye No</th><th>Adı</th><th>Soyadı</th><th>Doğum Tarihi</th><th>Telefon</th><th>E-posta</th><th>Katılım Tarihi</th><th>Dal</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'equipments') {
                        echo '<th>Ekipman No</th><th>Ekipman Türü</th><th>Üretici Firma</th><th>Üretim Yılı</th><th>Güncel Kondisyon</th><th>Sahibi Olan Üye No</th>';
                    } elseif ($table == 'events') {
                        echo '<th>Etkinlik No</th><th>Etkinlik Tarihi</th><th>Etkinlik Yeri</th><th>Etkinlik Konusu</th>';
                    } elseif ($table == 'participants') {
                        echo '<th>Etkinlik No</th><th>Üye No</th><th>Katılım Tarihi</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'admins') {
                        echo '<th>Yönetici No</th><th>Kullanıcı Adı</th><th>Adı</th><th>Soyadı</th><th>E-posta</th>';
                    }

                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="mt-4 alert alert-info">Tabloda veri bulunmamaktadır.</div>';
                }

                echo '<div class="mt-4">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="table" value="' . $table . '">';
                echo '<div class="form-group"><label for="primary_key">Silmek İstediğiniz ' . ucfirst($table) . ' No:</label><input type="text" class="form-control" id="primary_key" name="primary_key" required></div>';
                echo '<button type="submit" name="delete_data" class="btn btn-danger btn-block">Sil</button>';
                echo '</form>';
                echo '</div>';
            } elseif ($action == 'update') {
                $sql = "SELECT * FROM $table";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="mt-4">';
                    echo '<h3>' . ucfirst($table) . ' Tablosu</h3>';
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-dark table-striped">';
                    echo '<thead><tr>';

                    if ($table == 'members') {
                        echo '<th>Üye No</th><th>Adı</th><th>Soyadı</th><th>Doğum Tarihi</th><th>Telefon</th><th>E-posta</th><th>Katılım Tarihi</th><th>Dal</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'equipments') {
                        echo '<th>Ekipman No</th><th>Ekipman Türü</th><th>Üretici Firma</th><th>Üretim Yılı</th><th>Güncel Kondisyon</th><th>Sahibi Olan Üye No</th>';
                    } elseif ($table == 'events') {
                        echo '<th>Etkinlik No</th><th>Etkinlik Tarihi</th><th>Etkinlik Yeri</th><th>Etkinlik Konusu</th>';
                    } elseif ($table == 'participants') {
                        echo '<th>Etkinlik No</th><th>Üye No</th><th>Katılım Tarihi</th><th>Fotoğraf Makinesi</th><th>Lens 1</th><th>Lens 2</th><th>Lens 3</th>';
                    } elseif ($table == 'admins') {
                        echo '<th>Yönetici No</th><th>Kullanıcı Adı</th><th>Adı</th><th>Soyadı</th><th>E-posta</th>';
                    }

                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="mt-4 alert alert-info">Tabloda veri bulunmamaktadır.</div>';
                }

                echo '<div class="mt-4">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="table" value="' . $table . '">';
                echo '<div class="form-group"><label for="primary_key">Düzenlemek İstediğiniz ' . ucfirst($table) . ' No:</label><input type="text" class="form-control" id="primary_key" name="primary_key" required></div>';
                echo '<button type="submit" name="edit_data" class="btn btn-warning btn-block">Düzenle</button>';
                echo '</form>';
                echo '</div>';
            }
        }

        if (isset($_POST['edit_data'])) {
            $table = $_POST['table'];
            $primaryKey = $_POST['primary_key'];
            $sql = "SELECT * FROM $table WHERE ";

            if ($table == 'members') {
                $sql .= "m_no='$primaryKey'";
            } elseif ($table == 'equipments') {
                $sql .= "eq_no='$primaryKey'";
            } elseif ($table == 'events') {
                $sql .= "ev_no='$primaryKey'";
            } elseif ($table == 'participants') {
                $sql .= "ev_no='$primaryKey' AND m_no='$primaryKey'";
            } elseif ($table == 'admins') {
                $sql .= "a_no='$primaryKey'";
            }

            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo '<div class="mt-4">';
                echo '<h3>Veri Düzenleme: ' . ucfirst($table) . '</h3>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="table" value="' . $table . '">';
                echo '<input type="hidden" name="primary_key" value="' . $primaryKey . '">';

                if ($table == 'members') {
                    echo '<div class="form-group"><label for="m_name">Adı:</label><input type="text" class="form-control" id="m_name" name="m_name" value="' . $row['m_name'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_sname">Soyadı:</label><input type="text" class="form-control" id="m_sname" name="m_sname" value="' . $row['m_sname'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_dob">Doğum Tarihi:</label><input type="date" class="form-control" id="m_dob" name="m_dob" value="' . $row['m_dob'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_gsm">Telefon:</label><input type="text" class="form-control" id="m_gsm" name="m_gsm" value="' . $row['m_gsm'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_mail">E-posta:</label><input type="email" class="form-control" id="m_mail" name="m_mail" value="' . $row['m_mail'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_dojoin">Katılım Tarihi:</label><input type="date" class="form-control" id="m_dojoin" name="m_dojoin" value="' . $row['m_dojoin'] . '" required></div>';
                    echo '<div class="form-group"><label for="type">Dal:</label><select class="form-control" id="type" name="type" required>';
                    echo '<option value="sokak" ' . ($row['type'] == 'sokak' ? 'selected' : '') . '>Sokak</option>';
                    echo '<option value="doğa" ' . ($row['type'] == 'doğa' ? 'selected' : '') . '>Doğa</option>';
                    echo '<option value="portre" ' . ($row['type'] == 'portre' ? 'selected' : '') . '>Portre</option>';
                    echo '<option value="astro" ' . ($row['type'] == 'astro' ? 'selected' : '') . '>Astro</option>';
                    echo '<option value="reklam" ' . ($row['type'] == 'reklam' ? 'selected' : '') . '>Reklam</option>';
                    echo '<option value="makro" ' . ($row['type'] == 'makro' ? 'selected' : '') . '>Makro</option>';
                    echo '<option value="düğün" ' . ($row['type'] == 'düğün' ? 'selected' : '') . '>Düğün</option>';
                    echo '</select></div>';
                    echo '<div class="form-group"><label for="m_camera">Fotoğraf Makinesi:</label><input type="text" class="form-control" id="m_camera" name="m_camera" value="' . $row['m_camera'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens1">Lens 1:</label><input type="text" class="form-control" id="m_lens1" name="m_lens1" value="' . $row['m_lens1'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens2">Lens 2:</label><input type="text" class="form-control" id="m_lens2" name="m_lens2" value="' . $row['m_lens2'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens3">Lens 3:</label><input type="text" class="form-control" id="m_lens3" name="m_lens3" value="' . $row['m_lens3'] . '"></div>';
                } elseif ($table == 'equipments') {
                    echo '<div class="form-group"><label for="eq_type">Ekipman Türü:</label><input type="text" class="form-control" id="eq_type" name="eq_type" value="' . $row['eq_type'] . '" required></div>';
                    echo '<div class="form-group"><label for="eq_manufacturer">Üretici Firma:</label><input type="text" class="form-control" id="eq_manufacturer" name="eq_manufacturer" value="' . $row['eq_manufacturer'] . '" required></div>';
                    echo '<div class="form-group"><label for="eq_producedate">Üretim Yılı:</label><input type="text" class="form-control" id="eq_producedate" name="eq_producedate" value="' . $row['eq_producedate'] . '" required></div>';
                    echo '<div class="form-group"><label for="eq_condition">Güncel Kondisyon:</label><input type="text" class="form-control" id="eq_condition" name="eq_condition" value="' . $row['eq_condition'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_no">Sahibi Olan Üye No:</label><input type="text" class="form-control" id="m_no" name="m_no" value="' . $row['m_no'] . '" required></div>';
                } elseif ($table == 'events') {
                    echo '<div class="form-group"><label for="ev_date">Etkinlik Tarihi:</label><input type="date" class="form-control" id="ev_date" name="ev_date" value="' . $row['ev_date'] . '" required></div>';
                    echo '<div class="form-group"><label for="ev_location">Etkinlik Yeri:</label><input type="text" class="form-control" id="ev_location" name="ev_location" value="' . $row['ev_location'] . '" required></div>';
                    echo '<div class="form-group"><label for="ev_theme">Etkinlik Konusu:</label><input type="text" class="form-control" id="ev_theme" name="ev_theme" value="' . $row['ev_theme'] . '" required></div>';
                } elseif ($table == 'participants') {
                    echo '<div class="form-group"><label for="ev_no">Etkinlik No:</label><input type="text" class="form-control" id="ev_no" name="ev_no" value="' . $row['ev_no'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_no">Üye No:</label><input type="text" class="form-control" id="m_no" name="m_no" value="' . $row['m_no'] . '" required></div>';
                    echo '<div class="form-group"><label for="pa_date">Katılım Tarihi:</label><input type="date" class="form-control" id="pa_date" name="pa_date" value="' . $row['pa_date'] . '" required></div>';
                    echo '<div class="form-group"><label for="m_camera">Fotoğraf Makinesi:</label><input type="text" class="form-control" id="m_camera" name="m_camera" value="' . $row['m_camera'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens1">Lens 1:</label><input type="text" class="form-control" id="m_lens1" name="m_lens1" value="' . $row['m_lens1'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens2">Lens 2:</label><input type="text" class="form-control" id="m_lens2" name="m_lens2" value="' . $row['m_lens2'] . '"></div>';
                    echo '<div class="form-group"><label for="m_lens3">Lens 3:</label><input type="text" class="form-control" id="m_lens3" name="m_lens3" value="' . $row['m_lens3'] . '"></div>';
                } elseif ($table == 'admins') {
                    echo '<div class="form-group"><label for="a_username">Kullanıcı Adı:</label><input type="text" class="form-control" id="a_username" name="a_username" value="' . $row['a_username'] . '" required></div>';
                    echo '<div class="form-group"><label for="a_name">Ad:</label><input type="text" class="form-control" id="a_name" name="a_name" value="' . $row['a_name'] . '" required></div>';
                    echo '<div class="form-group"><label for="a_sname">Soyad:</label><input type="text" class="form-control" id="a_sname" name="a_sname" value="' . $row['a_sname'] . '" required></div>';
                    echo '<div class="form-group"><label for="a_mail">E-posta:</label><input type="email" class="form-control" id="a_mail" name="a_mail" value="' . $row['a_mail'] . '" required></div>';
                    echo '<div class="form-group"><label for="a_password">Şifre:</label><input type="password" class="form-control" id="a_password" name="a_password" required></div>';
                }

                echo '<button type="submit" name="update_data" class="btn btn-primary btn-block">Güncelle</button>';
                echo '</form>';
                echo '</div>';
            }
        }
        ?>
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

<?php
$mysqli->close();
?>