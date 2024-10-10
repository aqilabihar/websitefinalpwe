<?php
include 'koneksi.php';

$response = ['status' => 'error', 'message' => 'Terjadi kesalahan.'];

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <!-- Add a new button to save PDF on the server -->
            <button type="button" class="btn btn-primary" id="savePdfToServerBtn">Save PDF to Server</button>

            <script>
                // Convert table to PDF and send to server
                $('#savePdfToServerBtn').click(function() {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF();

                    // AutoTable plugin to convert the HTML table
                    doc.autoTable({
                        html: '#dataTable',
                        startY: 20,
                        theme: 'grid',
                        headStyles: {
                            fillColor: [0, 123, 255]
                        },
                    });

                    // Generate the PDF as a blob
                    var pdfBlob = doc.output('blob');

                    // Create FormData and append the blob file
                    var formData = new FormData();
                    formData.append('pdfFile', pdfBlob, 'data-list.pdf'); // Append the file as 'data-list.pdf'

                    // Send the blob to the server via AJAX
                    $.ajax({
                        url: 'save_pdf.php', // PHP file to handle the upload
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert(response); // Display response from the server
                        },
                        error: function() {
                            alert('Error saving PDF.');
                        }
                    });
                });
            </script>

        </section>

        <!-- Popup Overlay untuk opsi pengiriman email -->
        <div id="emailPopup" class="overlay" style="display: none;">
            <div class="popup">
                <h2>Select Email Option</h2>
                <a class="close">&times;</a>
                <div class="modal-body">
                    <button id="emailXlsxBtn" class="btn btn-success">Email XLSX</button>
                    <button id="emailPdfBtn" class="btn btn-danger">Email PDF</button>
                </div>
            </div>
        </div>

        <!-- STYLE OVERLAY -->
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

            .popup .btn {
                margin: 10px 0;
                width: 100%;
            }

            .chart-container {
                margin-bottom: 30px;
                padding: 20px;
                border-radius: 10px;
                background-color: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: relative;
                width: 100%;
                height: 400px;
                /* Ensuring both containers have the same height */
                display: flex;
                justify-content: center;
                /* Centering the chart inside the container */
                align-items: center;
            }
        </style>

        <!-- SCRIPT OVERLAY -->
        <script>
            // Show the popup when the Email button is clicked
            document.getElementById("email").addEventListener("click", function() {
                document.getElementById("emailPopup").style.display = "flex";
            });

            // Hide the popup when the close button is clicked
            document.querySelector(".popup .close").addEventListener("click", function() {
                document.getElementById("emailPopup").style.display = "none";
            });

            // Optionally, hide the popup if you click outside the popup content
            window.addEventListener("click", function(event) {
                var popup = document.getElementById("emailPopup");
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            });
        </script>

        <!-- Convert table to XLSX and PDF, and Email Logic -->
        <script>
            // Convert table to PDF
            $('#convertPdfBtn').click(function() {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                // AutoTable plugin to convert the HTML table
                doc.autoTable({
                    html: '#dataTable',
                    startY: 20,
                    theme: 'grid',
                    headStyles: {
                        fillColor: [0, 123, 255]
                    }, // Bootstrap's primary color
                });

                // Save the PDF
                doc.save('data-list.pdf');
            });

            // Convert table to XLSX
            $('#convertXlsBtn').click(function() {
                // Use SheetJS to convert the table to XLSX format
                var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'), {
                    sheet: "Data"
                });
                XLSX.writeFile(wb, 'data-list.xlsx');
            });
            // kirim email ke dosen
            document.getElementById('emailXlsxBtn').addEventListener('click', function() {
                sendEmail('xlsx');
            });

            document.getElementById('emailPdfBtn').addEventListener('click', function() {
                sendEmail('pdf');
            });

            function sendEmail(format) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "send_email.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE) {
                        if (this.status === 200) {
                            alert(this.responseText); // Menampilkan respon dari server
                        } else {
                            alert("Terjadi kesalahan. Email gagal dikirim.");
                        }
                    }
                };
                xhr.send("format=" + format); // Mengirim format file ke server (xlsx/pdf)
            }
        </script>

        <!-- Charts Section ini yang kurang tadi -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="peminjamanByKegiatanChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="monthlyPeminjamanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART SCRIPTS -->
        <script>
            const kegiatanTitles = <?php echo json_encode($kegiatan_titles); ?>;
            const peminjamanCounts = <?php echo json_encode($peminjaman_counts); ?>;

            const peminjamanByKegiatanCtx = document.getElementById('peminjamanByKegiatanChart').getContext('2d');
            new Chart(peminjamanByKegiatanCtx, {
                type: 'bar',
                data: {
                    labels: kegiatanTitles,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: peminjamanCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
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

            const months = <?php echo json_encode($months); ?>;
            const monthlyPeminjamanCounts = <?php echo json_encode($monthly_peminjaman_counts); ?>;

            const monthlyPeminjamanCtx = document.getElementById('monthlyPeminjamanChart').getContext('2d');
            new Chart(monthlyPeminjamanCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Peminjaman Bulanan',
                        data: monthlyPeminjamanCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true
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
        </script>
</body>

</html>