<?php

namespace App\Controllers;

class ScheduleController {
    private $scheduleModel;

    public function __construct($scheduleModel) {
        $this->scheduleModel = $scheduleModel;
    }

    // Action to fetch schedules
    public function getSchedules() {
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
    }
}
