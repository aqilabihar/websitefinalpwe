<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/public/css/home.css">
</head>  
<body>

    <!-- Header section with Logout button -->
    <header class="main-header">
        <div class="header-container">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <a href="/logout" class="btn btn-logout">Logout</a>
        </div>
    </header>

    <div class="container mt-5">
        <h1>Jadwal Peminjaman Kegiatan</h1>
        <div id="calendar" class="calendar-table my-4"></div>

        <!-- Borrower List Modal -->
        <div class="modal fade" id="borrowerListModal" tabindex="-1" aria-labelledby="borrowerListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="borrowerListModalLabel">Kegiatan pada Tanggal <span id="selectedDate"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="borrower-list" id="borrowerList"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/home.js"></script>

</body>
</html>
