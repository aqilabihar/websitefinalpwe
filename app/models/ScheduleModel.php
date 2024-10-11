<?php

namespace App\Models;

use App\Database\Koneksi;

class ScheduleModel {
    private $db;

    public function __construct() {
        $this->db = Koneksi::getConnection(); // Menggunakan Koneksi database
    }

    // Method untuk mendapatkan jadwal peminjaman
    public function getSchedules() {
        // Menyusun query untuk mengambil data
        $query = "SELECT id_peminjaman AS id, nama_kegiatan AS title, waktu_mulai AS start, waktu_selesai AS end FROM peminjaman_advanced";
        $result = mysqli_query($this->db, $query);

        $schedules = [];

        // Menyimpan hasil query dalam array
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $schedules[] = $row; // Tambahkan setiap baris ke array
            }
        } else {
            // Jika query gagal, bisa ditangani di sini
            error_log('Query failed: ' . mysqli_error($this->db)); // Log error
        }

        return $schedules; // Mengembalikan array jadwal
    }
}
