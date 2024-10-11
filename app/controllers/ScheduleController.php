<?php
<<<<<<< Updated upstream
class ScheduleController {
    private $scheduleModel;

    public function __construct($db) {
        $this->scheduleModel = new ScheduleModel($db);
    }

    // Fungsi untuk menampilkan halaman kalender
    public function index() {
        include_once "../app/views/calendar.php"; // Tampilkan halaman kalender
    }

    // Fungsi untuk mendapatkan data jadwal dan mengirimkannya dalam format JSON
    public function getSchedules() {
        $schedules = $this->scheduleModel->getSchedules();
        echo json_encode($schedules); // Kirim data dalam format JSON
=======

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Database\Koneksi;

class ScheduleController {
    public function getSchedules() {
        // Allow CORS requests
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');

        $dbConnection = Koneksi::getConnection();  // Ambil koneksi ke database
        $scheduleModel = new ScheduleModel($dbConnection);
        $schedules = $scheduleModel->getSchedules();  // Ambil jadwal dari database

        echo json_encode($schedules);
        exit();
>>>>>>> Stashed changes
    }
}
?>
