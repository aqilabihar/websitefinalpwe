<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $format = $_POST['format']; // Menerima format dari request POST

    // Cek apakah format sudah dikirim
    if (!$format) {
        echo 'Format file tidak ditemukan.';
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server email (Gmail SMTP)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'miraenk7@gmail.com'; // Ganti dengan email Gmail Anda
        $mail->Password = 'mufd sauw dxrq nnpv'; // Ganti dengan password aplikasi yang benar (App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan pengirim dan penerima email
        $mail->setFrom('miraenk7@gmail.com', ''); // Nama pengirim
        $mail->addAddress('tegarkalla836@gmail.com', 'Bagas'); // Email penerima
        $mail->addCC('emikabarus13@gmail.com', 'Budi'); 

        // Cek apakah format adalah XLSX atau PDF
        if ($format == 'xlsx') {
            $mail->Subject = 'Data dalam Format XLSX';
            $mail->Body    = 'Berikut adalah file XLSX yang diminta.';
            $mail->addAttachment('uploads/data-list.xlsx'); // Path ke file XLSX
        } elseif ($format == 'pdf') {
            $mail->Subject = 'Data dalam Format PDF';
            $mail->Body    = 'Berikut adalah file PDF yang diminta.';
            $mail->addAttachment('uploads/data-list.pdf'); // Path ke file PDF
        } else {
            echo 'Format file tidak valid.';
            exit;
        }

        // Kirim email
        $mail->send();
        echo 'Email berhasil dikirim';
    } catch (Exception $e) {
        echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
    }
}
?>
