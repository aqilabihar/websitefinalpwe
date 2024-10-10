<<<<<<< Updated upstream

=======
<?php
// Start session at the very top to ensure it's initialized before any output
session_start();
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

        .borrower-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        /* Borrower Card Styling */
        .borrower-card {
            padding: 10px;
            background-color: #e9ecef;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        /* Button Styling */
        .btn {
            padding: 8px 12px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }

            #calendar {
                padding: 10px;
            }
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
        </div>

        <!-- Section for displaying ID check result -->
        <div class="mt-4">
            <h3>Hasil Pengecekan ID</h3>
            <p id="idCheckResult"><em>ID belum dicek.</em></p>
        </div>
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
</body>

</html>
