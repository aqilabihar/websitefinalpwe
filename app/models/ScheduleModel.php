<?php

namespace App\Models;

class ScheduleModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;  // Store the mysqli connection object
    }

    public function getSchedules() {
        $query = "SELECT id_peminjaman, tanggal_usulan, nama_kegiatan, waktu_mulai, waktu_selesai FROM peminjaman_advanced";
        $result = mysqli_query($this->db, $query);  // Use the $db (mysqli object)

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
        }

        return $schedules;
    }
}
