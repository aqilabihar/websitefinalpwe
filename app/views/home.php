<?php
// Pastikan session dimulai
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar with Book Loan Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet" />
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

        .calendar-container {
            max-width: 900px;
            margin: 0 auto;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .borrower-card .actions {
            display: flex;
            gap: 5px;
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
                // Cek apakah 'username' ada di session
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } else {
                    echo 'Guest'; // Tampilkan 'Guest' jika 'username' belum diatur
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
                        <button class="btn btn-primary mt-3" id="addLoanButton">Pinjam pada Tanggal Ini</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [],
                dateClick: function (info) {
                    $('#borrowerListModal').modal('show');
                    $('#selectedDate').text(info.dateStr);
                }
            });
            calendar.render();

            // ID Check Example
            var idCheckResult = document.getElementById('idCheckResult');
            var checkId = function () {
                var id = '12345'; // Example ID to check
                if (id === '12345') {
                    idCheckResult.textContent = 'ID Valid: ' + id;
                } else {
                    idCheckResult.textContent = 'ID Tidak Valid';
                }
            };
            checkId();

            // Form submission for book loan schedule
            $('#scheduleForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                alert('Form submitted with data: ' + formData);
                $('#scheduleModal').modal('hide');
            });
        });
    </script>
</body>

</html>
