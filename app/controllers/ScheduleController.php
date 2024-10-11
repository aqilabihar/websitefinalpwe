<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Database\Koneksi;

class ScheduleController {
    private $scheduleModel;

    public function __construct($scheduleModel = null) {
        if ($scheduleModel) {
            $this->scheduleModel = $scheduleModel;
        } else {
            // Use the database connection if no model is passed in the constructor
            $dbConnection = Koneksi::getConnection();
            $this->scheduleModel = new ScheduleModel($dbConnection);
        }
    }

    // Action to fetch schedules
    public function getSchedules() {
        // Allow CORS requests
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');

        try {
            // Fetch schedules from the model
            $schedules = $this->scheduleModel->getSchedules();

            // Check if schedules are found
            if ($schedules) {
                // Return the data as a JSON response
                echo json_encode($schedules);
            } else {
                // Return an empty array if no schedules are found
                echo json_encode([]);
            }
        } catch (\Exception $e) {
            // Log the error and return a failure response
            error_log($e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Failed to retrieve schedules.']);
        }
        exit();
    }
}
