<?php
// Konfigurasi database
$host    = 'localhost';
$db      = 'barberz_db';  // Ganti dengan nama database Anda
$user    = 'root';        // Ganti sesuai dengan username MySQL Anda
$pass    = '';            // Ganti sesuai dengan password MySQL Anda (jika ada)
$charset = 'utf8mb4';

// Buat DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opsi koneksi
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  // Buat koneksi PDO
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  // Jika koneksi gagal, tampilkan pesan error
  die("Database connection failed: " . $e->getMessage());
}

// Proses data form jika request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan sanitasi data form
    $name    = htmlspecialchars($_POST['name']);
    $phone   = htmlspecialchars($_POST['phone']);
    $date    = htmlspecialchars($_POST['date']);
    $service = htmlspecialchars($_POST['service']);
    $notes   = htmlspecialchars($_POST['notes']);

    try {
        // Siapkan query dengan prepared statement untuk mencegah SQL Injection
        $stmt = $pdo->prepare("INSERT INTO bookings (name, phone, date, service, notes) VALUES (:name, :phone, :date, :service, :notes)");
        $stmt->execute([
          ':name'    => $name,
          ':phone'   => $phone,
          ':date'    => $date,
          ':service' => $service,
          ':notes'   => $notes
        ]);
    } catch (PDOException $e) {
        die("Error inserting data: " . $e->getMessage());
    }

    // Buat pesan konfirmasi sederhana
    $message = "<p style='color: green; margin-top: 20px; text-align: center;'>
                  Thank you, <strong>$name</strong>. Your appointment for 
                  <strong>$service</strong> on <strong>$date</strong> has been booked!
                </p>";
} else {
    // Jika form tidak disubmit dengan metode POST, redirect ke home.html
    header("Location: home.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation - BARBERZ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body, html {
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      margin-top: 50px;
      background-color: #f7f7f7;
    }
    .message {
      font-size: 20px;
      margin-bottom: 30px;
    }
    .btn {
      padding: 12px 30px;
      background-color: #f25f5c;
      border: none;
      border-radius: 30px;
      color: white;
      font-size: 16px;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background-color: #d94b48;
    }
  </style>
</head>
<body>
  <div class="message">
    <?php echo $message; ?>
  </div>
  <!-- Tombol untuk kembali ke halaman Home -->
  <a href="home.html" class="btn">Back to Home</a>
</body>
</html>
