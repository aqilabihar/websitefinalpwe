<?php
<<<<<<< HEAD

namespace App\Controllers;

=======
<<<<<<< Updated upstream
>>>>>>> MVC-Integration
class ScheduleController {
    private $scheduleModel;

    public function __construct($scheduleModel) {
        $this->scheduleModel = $scheduleModel;
    }

    // Action to fetch schedules
    public function getSchedules() {
<<<<<<< HEAD
        try {
            // Fetch schedules from the model
            $schedules = $this->scheduleModel->getSchedules();

            // Check if schedules are found
            if ($schedules) {
                // Return the data as a JSON response
                header('Content-Type: application/json');
                echo json_encode($schedules);
            } else {
                // Return an empty array if no schedules are found
                header('Content-Type: application/json');
                echo json_encode([]);
            }
        } catch (\Exception $e) {  // Add the backslash here to refer to the global Exception class
            // Log the error and return a failure response
            error_log($e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Failed to retrieve schedules.']);
        }
=======
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
>>>>>>> MVC-Integration
    }
}
