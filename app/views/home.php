<<<<<<< Updated upstream

=======
<?php
<<<<<<< HEAD
// Start session at the very top to ensure it's initialized before any output
=======
<<<<<<< Updated upstream
// Pastikan session dimulai
>>>>>>> MVC-Integration
session_start();
=======
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
>>>>>>> Stashed changes
?>
>>>>>>> Stashed changes

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

<<<<<<< HEAD
=======
<<<<<<< Updated upstream
        .calendar-container {
            max-width: 900px;
            margin: 0 auto;
        }

>>>>>>> MVC-Integration
        .borrower-list {
            max-height: 300px;
            overflow-y: auto;
=======
        /* Event Data Table Styling */
        .event-table {
            width: 100%;
            margin-top: 20px;
            background-color: white;
            border-collapse: collapse;
        }

        .event-table th,
        .event-table td {
>>>>>>> Stashed changes
            padding: 10px;
            border: 1px solid #ddd;
        }

<<<<<<< Updated upstream
        /* Borrower Card Styling */
        .borrower-card {
            padding: 10px;
            background-color: #e9ecef;
            margin-bottom: 10px;
            border-radius: 4px;
<<<<<<< HEAD
=======
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .borrower-card .actions {
            display: flex;
            gap: 5px;
=======
        .event-table th {
            background-color: #f4f4f9;
>>>>>>> Stashed changes
>>>>>>> MVC-Integration
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

<<<<<<< Updated upstream
        <!-- Borrower List Modal -->
        <div class="modal fade" id="borrowerListModal" tabindex="-1" aria-labelledby="borrowerListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="borrowerListModalLabel">Peminjam pada Tanggal <span id="selectedDate"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="borrowerList" class="borrower-list"></div>
                    </div>
                </div>
            </div>
=======
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
>>>>>>> Stashed changes
        </div>

        <!-- FullCalendar, jQuery, and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<<<<<<< HEAD
    <!-- FullCalendar, jQuery, and Bootstrap JS -->
=======
<<<<<<< Updated upstream
    <!-- Modal Form for Book Loan Schedule -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Tambah / Edit Jadwal Peminjaman Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="bookTitle" name="bookTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="borrowerName" class="form-label">Nama Peminjam</label>
                            <input type="text" class="form-control" id="borrowerName" name="borrowerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Tanggal Mulai Peminjaman</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Tanggal Akhir Peminjaman</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

>>>>>>> MVC-Integration
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
                    $('#selectedDate').text(info.dateStr);
                    showBorrowerList(info.dateStr);
                }
            });
            calendar.render();

            // Load events from controller via AJAX
            loadSchedules();

            async function loadSchedules() {
                try {
                    const response = await $.ajax({
                        url: '/websitefinalpwe/public/index.php?action=getSchedules',  // Ensure the URL is correct
                        method: 'GET',
                        dataType: 'json'
                    });

                    console.log(response);  // Check response in the browser console

                    if (Array.isArray(response)) {
                        // Add the fetched events to the calendar
                        response.forEach(function (event) {
                            calendar.addEvent({
                                id: event.id,
                                title: event.title,
                                start: event.start,  // YYYY-MM-DD
                                end: event.end      // YYYY-MM-DD
                            });
                        });
                    } else {
                        console.error("Response is not an array", response);
                    }
                } catch (error) {
                    console.error("Error loading schedules:", error);
                }
            }

            // Show borrowers based on the selected date
            function showBorrowerList(date) {
                const borrowers = calendar.getEvents().filter(event => event.startStr.split('T')[0] === date);
                $('#borrowerList').empty();

                if (borrowers.length === 0) {
                    $('#borrowerList').append('<p>No activities found for this date.</p>');
                } else {
                    borrowers.forEach(function (borrower) {
                        const card = $('<div class="borrower-card"></div>').append(
                            `<span>${borrower.title}</span>`  // Only display the title of the event
                        );
                        $('#borrowerList').append(card);
                    });
                }

                // Show the modal for borrower list
                $('#borrowerListModal').modal('show');
            }
        });
    </script>
=======
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize FullCalendar
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [], // Placeholder, will be replaced with AJAX-loaded events
                    dateClick: function (info) {
                        console.log("Date clicked: " + info.dateStr);
                    }
                });
                calendar.render();

                // Load schedules from the server using Fetch API
                loadSchedules();

                async function loadSchedules() {
                    try {
                        const response = await fetch('/getSchedules'); // Ganti dengan URL yang sesuai
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }

                        const data = await response.json(); // Parse JSON data

                        console.log("Data dari server:", data); // Log untuk memastikan data sudah diterima

                        const eventDataBody = document.getElementById('eventDataBody');
                        eventDataBody.innerHTML = ''; // Kosongkan data lama

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
                                    start: event.start,  // Pastikan ini format yang sesuai
                                    end: event.end       // Pastikan formatnya sesuai
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
>>>>>>> Stashed changes
</body>

</html>
