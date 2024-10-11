<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar with Book Loan Schedule</title>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        /* Header Styling */
        .main-header {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .main-header h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .main-header .btn-danger {
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .main-header .btn-danger:hover {
            background-color: #c82333;
            color: white;
        }

        /* Container for Calendar and Modals */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 40px;
        }

        /* Calendar Styling */
        #calendar {
            margin-top: 20px;
            margin-bottom: 40px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Event Data Table Styling */
        .event-table {
            width: 100%;
            margin-top: 20px;
            background-color: white;
            border-collapse: collapse;
        }

        .event-table th,
        .event-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .event-table th {
            background-color: #f4f4f9;
        }

        .event-notification {
            text-align: center;
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header section with Logout button -->
    <header class="main-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>
                Welcome, 
                <?php
                // Check if 'username' exists in session
                if (isset($_SESSION['username'])) {
                    echo htmlspecialchars($_SESSION['username']);
                } else {
                    echo 'Guest'; // Display 'Guest' if 'username' isn't set
                }
                ?>!
            </h1>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </header>

    <div class="container mt-5">
        <h1 class="text-center">Jadwal Peminjaman Buku</h1>
        <div id="calendar" class="my-4"></div>

        <!-- Table to display fetched schedules -->
        <h3 class="text-center">Event Data</h3>
        <table class="event-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody id="eventDataBody">
                <!-- Event data will be inserted here via JavaScript -->
            </tbody>
        </table>

        <div class="event-notification" id="noEventsMessage" style="display: none;">
            No events found.
        </div>

        <!-- FullCalendar, jQuery, and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize FullCalendar
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [], // Placeholder, to be replaced with AJAX-loaded events
                    dateClick: function (info) {
                        console.log("Date clicked: " + info.dateStr);
                    }
                });
                calendar.render();

                // Load schedules from the server using Fetch API
                loadSchedules();

                async function loadSchedules() {
                    try {
                        const response = await fetch('/getSchedules'); // Ensure this URL is correct
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }

                        const data = await response.json(); // Parse JSON data

                        console.log("Data from server:", data); // Log to ensure data is received

                        const eventDataBody = document.getElementById('eventDataBody');
                        eventDataBody.innerHTML = ''; // Clear previous data

                        if (Array.isArray(data) && data.length > 0) {
                            // Populate the event data table and add events to the calendar
                            data.forEach(function (event) {
                                // Add the event to the table
                                const row = `<tr>
                                    <td>${event.id}</td>
                                    <td>${event.title}</td>
                                    <td>${event.start}</td>
                                    <td>${event.end}</td>
                                </tr>`;
                                eventDataBody.insertAdjacentHTML('beforeend', row);

                                // Add the event to the calendar
                                calendar.addEvent({
                                    id: event.id,
                                    title: event.title,
                                    start: event.start,
                                    end: event.end
                                });
                            });
                        } else {
                            // No events found
                            document.getElementById('noEventsMessage').style.display = 'block';
                        }
                    } catch (error) {
                        console.error("Error loading schedules:", error);
                        document.getElementById('noEventsMessage').innerText = 'Error loading events.';
                        document.getElementById('noEventsMessage').style.display = 'block';
                    }
                }
            });
        </script>
    </div>
</body>

</html>
