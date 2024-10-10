<?php

namespace App\Controllers;

use App\Database\Koneksi; // Make sure to use the correct namespace for the Koneksi class

class PeminjamanController
{
    public function index()
    {
        // Get the database connection from the Koneksi class
        $conn = Koneksi::getConnection();

        // Check if the connection is valid
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Fetch all peminjaman records
        $sql = "SELECT * FROM peminjaman_advanced";
        $result = $conn->query($sql);  // Use $conn for queries

        include '../app/views/peminjaman.php'; // Load the view and pass data
    }

    public function save()
    {
        $conn = Koneksi::getConnection(); // Ensure connection is established

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Your data processing logic here
            // Process the form data and file uploads as necessary
            $tanggal_usulan = $_POST['tanggal_usulan'];
            $nama_kegiatan = $_POST['nama_kegiatan'];
            $nama_peminjam = $_POST['nama_peminjam'];
            $waktu_mulai = $_POST['jam_mulai'];
            $waktu_selesai = $_POST['jam_selesai'];
            $upload_dir = '../public/uploads/';

            // File upload handling
            $file_name = $_FILES['surat_peminjaman']['name'] ?? '';
            $file_tmp = $_FILES['surat_peminjaman']['tmp_name'] ?? '';
            $file_path = '';

            if (!empty($file_name)) {
                $file_path = $upload_dir . basename($file_name);
                if (!move_uploaded_file($file_tmp, $file_path)) {
                    echo "Failed to upload file.";
                    exit();
                }
            }

            if (isset($_POST['id_peminjaman']) && !empty($_POST['id_peminjaman'])) {
                $id = $_POST['id_peminjaman'];

                // If no new file, keep the old file
                if (empty($file_name)) {
                    $file_name = $_POST['file_lama'];
                } else {
                    // Delete old file
                    $file_lama = $upload_dir . $_POST['file_lama'];
                    if (file_exists($file_lama)) {
                        unlink($file_lama);
                    }
                }

                // Update the record
                $sql = "UPDATE peminjaman_advanced SET
                            tanggal_usulan = '$tanggal_usulan',
                            nama_kegiatan = '$nama_kegiatan',
                            nama_peminjam = '$nama_peminjam',
                            waktu_mulai = '$waktu_mulai',
                            waktu_selesai = '$waktu_selesai',
                            surat_peminjaman = '$file_name'
                        WHERE id_peminjaman = $id";
            } else {
                // Insert new record
                $sql = "INSERT INTO peminjaman_advanced (tanggal_usulan, nama_kegiatan, nama_peminjam, surat_peminjaman, waktu_mulai, waktu_selesai)
                        VALUES ('$tanggal_usulan', '$nama_kegiatan', '$nama_peminjam', '$file_name', '$waktu_mulai', '$waktu_selesai')";
            }

            if ($conn->query($sql) === TRUE) {
                header('Location: /peminjaman');
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }

    public function delete($id)
    {
        $conn = Koneksi::getConnection(); // Ensure connection is established

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Fetch file name to delete it
        $sql_file = "SELECT surat_peminjaman FROM peminjaman_advanced WHERE id_peminjaman = $id";
        $result = $conn->query($sql_file);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_path = '../public/uploads/' . $row['surat_peminjaman'];
            if (file_exists($file_path)) {
                unlink($file_path); // Delete the file
            }
        }

        // Delete the record
        $sql = "DELETE FROM peminjaman_advanced WHERE id_peminjaman = $id";
        if ($conn->query($sql) === TRUE) {
            header('Location: /peminjaman');
        } else {
            echo "Error: " . $conn->error;
        }
    }

    public function edit($id)
    {
        $conn = Koneksi::getConnection(); // Ensure connection is established

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM peminjaman_advanced WHERE id_peminjaman = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        }
        exit();
    }
}
