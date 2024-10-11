<?php

namespace App\Models;

class ScheduleModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;  // Store the mysqli connection object
    }

    public function getSchedules() {
<<<<<<< HEAD
        $query = "SELECT id_peminjaman, tanggal_usulan, nama_kegiatan, waktu_mulai, waktu_selesai FROM peminjaman_advanced";
        $result = mysqli_query($this->db, $query);  // Use the $db (mysqli object)
=======
<<<<<<< Updated upstream
        $query = "SELECT id_peminjaman, tanggal_usulan, nama_kegiatan, waktu_mulai, waktu_selesai FROM loan_schedules";
        $result = mysqli_query($this->db, $query);
>>>>>>> MVC-Integration

        $schedules = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $schedules[] = [
                    'id' => $row['id_peminjaman'],
                    'title' => $row['nama_kegiatan'],
                    'start' => $row['tanggal_usulan'] . 'T' . $row['waktu_mulai'],
                    'end' => $row['tanggal_usulan'] . 'T' . $row['waktu_selesai']
                ];
            }
=======
        $query = "SELECT id_peminjaman AS id, nama_kegiatan AS title, waktu_mulai AS start, waktu_selesai AS end FROM peminjaman_advanced";
        $result = mysqli_query($this->db, $query);

        $schedules = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $schedules[] = $row;
>>>>>>> Stashed changes
        }

        return $schedules;
    }
}
