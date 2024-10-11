<?php
class ScheduleModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fungsi untuk mengambil jadwal dari database
    public function getSchedules() {
<<<<<<< Updated upstream
        $query = "SELECT id_peminjaman, tanggal_usulan, nama_kegiatan, waktu_mulai, waktu_selesai FROM loan_schedules";
        $result = mysqli_query($this->db, $query);

        $schedules = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $schedules[] = [
                    'id' => $row['id_peminjaman'], // ID Peminjaman
                    'title' => $row['nama_kegiatan'], // Nama Kegiatan
                    'start' => $row['tanggal_usulan'] . 'T' . $row['waktu_mulai'], // Tanggal Usulan dan Waktu Mulai
                    'end' => $row['tanggal_usulan'] . 'T' . $row['waktu_selesai'] // Tanggal Usulan dan Waktu Selesai
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
?>
