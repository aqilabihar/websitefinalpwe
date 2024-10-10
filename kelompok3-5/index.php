    <?php
    include 'koneksi.php';

    $response = ['status' => 'error', 'message' => 'Terjadi kesalahan.'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Proses CREATE/UPDATE
        $tanggal_usulan = $_POST['tanggal_usulan'];
        $nama_kegiatan = $_POST['nama_kegiatan'];
        $nama_peminjam = $_POST['nama_peminjam'];
        $waktu_mulai = $_POST['jam_mulai'];
        $waktu_selesai = $_POST['jam_selesai'];
        $upload_dir = 'uploads/';

        // Proses file upload
        $file_name = $_FILES['surat_peminjaman']['name'] ?? '';
        $file_tmp = $_FILES['surat_peminjaman']['tmp_name'] ?? '';
        $file_path = '';

        if (!empty($file_name)) {
            $file_path = $upload_dir . basename($file_name);
            if (!move_uploaded_file($file_tmp, $file_path)) {
                $response = ['status' => 'error', 'message' => 'Gagal mengunggah file.'];
                echo json_encode($response);
                exit();
            }
        }

        if (isset($_POST['id_peminjaman']) && !empty($_POST['id_peminjaman'])) {
            $id = $_POST['id_peminjaman'];

            if (empty($file_name)) {
                $file_name = $_POST['file_lama'];
            } else {
                $file_lama = $upload_dir . $_POST['file_lama'];
                if (file_exists($file_lama)) {
                    unlink($file_lama);
                }
            }

            // Update data
            $sql = "UPDATE peminjaman_advanced SET
                        tanggal_usulan = '$tanggal_usulan',
                        nama_kegiatan = '$nama_kegiatan',
                        nama_peminjam = '$nama_peminjam',
                        waktu_mulai = '$waktu_mulai',
                        waktu_selesai = '$waktu_selesai',
                        surat_peminjaman = '$file_name'
                    WHERE id_peminjaman = $id";
        } else {
            // Insert data baru
            $sql = "INSERT INTO peminjaman_advanced (tanggal_usulan, nama_kegiatan, nama_peminjam, surat_peminjaman, waktu_mulai, waktu_selesai)
                    VALUES ('$tanggal_usulan', '$nama_kegiatan', '$nama_peminjam', '$file_name', '$waktu_mulai', '$waktu_selesai')";
        }

        if ($conn->query($sql) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Data berhasil disimpan!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error: ' . $conn->error];
        }

        echo json_encode($response);
        exit();
    }

    // DELETE handling
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql_file = "SELECT surat_peminjaman FROM peminjaman_advanced WHERE id_peminjaman = $id";
        $result = $conn->query($sql_file);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_path = 'uploads/' . $row['surat_peminjaman'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql = "DELETE FROM peminjaman_advanced WHERE id_peminjaman = $id";
        if ($conn->query($sql) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Data berhasil dihapus!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error: ' . $conn->error];
        }

        echo json_encode($response);
        exit();
    }

    // GET for edit form
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM peminjaman_advanced WHERE id_peminjaman = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        }
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Usulan Kegiatan</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <div class="container-fluid mt-5">
            <h2 class="text-center mb-4">Form Usulan Kegiatan</h2>

            <!-- Form input usulan -->
            <form id="kegiatanForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_peminjaman" id="id_peminjaman">
                <input type="hidden" name="file_lama" id="file_lama">
                <div class="form-group">
                    <label for="tanggal_usulan">Tanggal Usulan Kegiatan:</label>
                    <input type="date" class="form-control" id="tanggal_usulan" name="tanggal_usulan" required>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan:</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                </div>

                <div class="form-group">
                    <label for="nama_peminjam">Nama Peminjam:</label>
                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                </div>

                <div class="form-group">
                    <label for="surat_peminjaman">Upload Surat Peminjaman:</label>
                    <input type="file" class="form-control-file" id="surat_peminjaman" name="surat_peminjaman" accept=".pdf,.doc,.docx">
                    <p id="currentFile"></p>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="jam_mulai">Lama Pelaksanaan (Dari Jam):</label>
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jam_selesai">Lama Pelaksanaan (Sampai Jam):</label>
                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Usulan</button>
                <button type="reset" class="btn btn-danger">bersihkan</button>
            </form>

            <!-- Daftar data usulan -->
            <h4 class="mt-5">Data Usulan Kegiatan:</h4>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Usulan</th>
                        <th>Nama Kegiatan</th>
                        <th>Nama Peminjam</th>
                        <th>Surat Peminjaman</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
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
                                    <td>
                                        <a href='#' class='btn btn-warning btn-sm editBtn' data-id='" . $row['id_peminjaman'] . "'>Edit</a>
                                        <a href='#' class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['id_peminjaman'] . "'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
            $('button[type="reset"]').on('click', function() {
                $('#surat_peminjaman').val(''); // Reset input file secara manual
                $('#currentFile').text(''); // Hapus tampilan file yang sedang diunggah
            });

            // Proses form submit dengan AJAX
            $('#kegiatanForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dari refresh halaman
                var formData = new FormData(this);

                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            alert(data.message);
                            $('#kegiatanForm')[0].reset(); // Membersihkan form setelah submit
                            location.reload(); // Reload halaman
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });

            // Event handler untuk tombol Edit
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: 'index.php',
                    type: 'GET',
                    data: {
                        edit: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#id_peminjaman').val(data.id_peminjaman);
                        $('#tanggal_usulan').val(data.tanggal_usulan);
                        $('#nama_kegiatan').val(data.nama_kegiatan);
                        $('#nama_peminjam').val(data.nama_peminjam);
                        $('#jam_mulai').val(data.waktu_mulai);
                        $('#jam_selesai').val(data.waktu_selesai);
                        $('#file_lama').val(data.surat_peminjaman);
                        $('#currentFile').text('File saat ini: ' + data.surat_peminjaman);
                    }
                });
            });

            // Event handler untuk tombol Delete
            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: 'index.php',
                        type: 'GET',
                        data: {
                            delete: id
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        }
                    });
                }
            });
        </script>
    </body>

    </html>