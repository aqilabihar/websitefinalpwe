<?php
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
    }
}
?>
