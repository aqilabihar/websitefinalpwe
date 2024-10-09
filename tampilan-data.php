<?php
include 'koneksi.php';

$response = ['status' => 'error', 'message' => 'Terjadi kesalahan.'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
<div class="container-fluid mt-5">
    <h2 class="text-center mb-4">Form Usulan Kegiatan</h2>

    <!-- Daftar data usulan -->
    <h4 class="mt-5">Data Usulan Kegiatan:</h4>
    <table class="table mt-3" id="dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal Usulan</th>
                <th>Nama Kegiatan</th>
                <th>Nama Peminjam</th>
                <th>Surat Peminjaman</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM peminjaman_advanced";
            $result = $conn->query($sql);
            $no = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $no++;
                    echo "<tr>
                            <th scope='row'>" . $no . "</th>
                            <td>" . $row['tanggal_usulan'] . "</td>
                            <td>" . $row['nama_kegiatan'] . "</td>
                            <td>" . $row['nama_peminjam'] . "</td>
                            <td><a href='uploads/" . $row['surat_peminjaman'] . "' target='_blank'>" . $row['surat_peminjaman'] . "</a></td>
                            <td>" . $row['waktu_mulai'] . "</td>
                            <td>" . $row['waktu_selesai'] . "</td>
                            
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada data.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Buttons Conversion + Email MIKA -->
    <section class="text-center mt-4">
    <button type="button" class="btn btn-success" id="convertXlsBtn">Convert XLSX</button>
        <button type="button" class="btn btn-danger" id="convertPdfBtn">Convert PDF</button>
        <button type="button" class="btn btn-warning" id="email" style="color: white;">Email</button>
    </section>

    <!-- Popup Overlay -->
    <div id="emailPopup" class="overlay" style="display: none;">
    <div class="popup">
        <h2>Select Email Option</h2>
        <a class="close">&times;</a>
        <div class="content">
            <button type="button" class="btn btn-success" id="emailXlsBtn">Email XLSX</button>
            <button type="button" class="btn btn-danger" id="emailPdfBtn">Email PDF</button>
        </div>
    </div>
    </div>

    <!-- STYLE OVERLAY -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* The popup overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* The popup content */
        .popup {
            background: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        /* Close button (X) */
        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }

        .popup h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .popup .content {
            margin-top: 20px;
        }

        .popup .btn {
            margin: 10px 0;
            width: 100%;
        }
    </style>
    <!-- SCRIPT OVERLAY -->
    <script>
        // Show the popup when the Email button is clicked
        document.getElementById("email").addEventListener("click", function () {
            document.getElementById("emailPopup").style.display = "flex";
        });

        // Hide the popup when the close button is clicked
        document.querySelector(".popup .close").addEventListener("click", function () {
            document.getElementById("emailPopup").style.display = "none";
        });

        // Optionally, hide the popup if you click outside the popup content
        window.addEventListener("click", function (event) {
            var popup = document.getElementById("emailPopup");
            if (event.target == popup) {
                popup.style.display = "none";
            }
        });
    </script>



    <script>
        // Convert table to PDF
        $('#convertPdfBtn').click(function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // AutoTable plugin to convert the HTML table
            doc.autoTable({
                html: '#dataTable',
                startY: 20,
                theme: 'grid',
                headStyles: { fillColor: [0, 123, 255] }, // Bootstrap's primary color
            });

            // Save the PDF
            doc.save('data-list.pdf');
        });

        // Convert table to XLSX
        $('#convertXlsBtn').click(function() {
            // Use SheetJS to convert the table to XLSX format
            var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'), {sheet: "Data"});
            XLSX.writeFile(wb, 'data-list.xlsx');
        });
    </script>

</div>

<?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'peminjaman_ruangan');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query for the first chart: Group by nama kegiatan
        $query = "SELECT nama_kegiatan, COUNT(id_peminjaman) AS peminjaman_count FROM peminjaman_advanced GROUP BY nama_kegiatan";
        $result = $conn->query($query);

        // Prepare data for the first chart
        $kegiatan_titles = [];
        $peminjaman_counts = [];

        while ($row = $result->fetch_assoc()) {
            $kegiatan_titles[] = $row['nama_kegiatan'];
            $peminjaman_counts[] = $row['peminjaman_count'];
        }

        // Query for the third chart (monthly peminjaman): Group by month
        $query3 = "SELECT MONTH(tanggal_usulan) AS month, COUNT(id_peminjaman) AS peminjaman_count FROM peminjaman_advanced GROUP BY month ORDER BY month";
        $result3 = $conn->query($query3);

        // Prepare data for the third chart
        $months = [];
        $monthly_peminjaman_counts = [];

        while ($row = $result3->fetch_assoc()) {
            $months[] = $row['month'];  // This will be the numeric month (1-12)
            $monthly_peminjaman_counts[] = $row['peminjaman_count'];
        }

        // Close the connection
        $conn->close();
?>
        <!-- CHART SCRIPT -->
         <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Style Chart -->
        <style>
        body {
            background-color: #f8f9fa;
        }
        .chart-container {
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        width: 100%;
        height: 400px; /* Ensuring both containers have the same height */
        display: flex;
        justify-content: center; /* Centering the chart inside the container */
        align-items: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #343a40;
        }
    </style>

         <!-- DIV CHARTS -->
         <div class="container mt-5">
        <h2>Chart Peminjaman</h2>

        <!-- (Bar chart) -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="kegiatanChart"></canvas>
                </div>
            </div>
            <!-- (Pie chart) -->
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get data from PHP for the first chart
        var kegiatanTitles = <?php echo json_encode($kegiatan_titles); ?>;
        var peminjamanCounts = <?php echo json_encode($peminjaman_counts); ?>;

        // Initialize the first chart
        var ctx1 = document.getElementById('kegiatanChart').getContext('2d');
        var kegiatanChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: kegiatanTitles,
                datasets: [{
                    label: 'Jumlah Peminjaman per Kegiatan',
                    data: peminjamanCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Get data from PHP for the third chart (Pie chart)
        var months = <?php echo json_encode($months); ?>;
        var monthlyPeminjamanCounts = <?php echo json_encode($monthly_peminjaman_counts); ?>;

        // Month names array
        var monthNames = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

        // Initialize the third chart (Monthly Peminjaman - Pie chart)
        var ctx3 = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: months.map(month => monthNames[month - 1]), // Map month numbers to names
                datasets: [{
                    label: 'Jumlah Peminjaman per Bulan',
                    data: monthlyPeminjamanCounts,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>

</body>
</html>
