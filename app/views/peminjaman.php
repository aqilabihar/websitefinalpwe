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

        <!-- Add button to upload PDF in the top-left corner -->
        <div class="text-left">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="pdfFile" accept=".pdf">
                <button type="submit" class="btn btn-success">Upload PDF</button>
            </form>
        </div>

        <form id="kegiatanForm" method="POST" enctype="multipart/form-data" action="/peminjaman/save">
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
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_peminjaman'] ?></td>
                        <td><?= $row['tanggal_usulan'] ?></td>
                        <td><?= $row['nama_kegiatan'] ?></td>
                        <td><?= $row['nama_peminjam'] ?></td>
                        <td><a href="/public/uploads/<?= $row['surat_peminjaman'] ?>" target="_blank"><?= $row['surat_peminjaman'] ?></a></td>
                        <td><?= $row['waktu_mulai'] ?></td>
                        <td><?= $row['waktu_selesai'] ?></td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm editBtn" data-id="<?= $row['id_peminjaman'] ?>">Edit</a>
                            <a href="/peminjaman/delete/<?= $row['id_peminjaman'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No data found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Additional JavaScript for handling edit and delete operations
    </script>
</body>
</html>

<?php
// PHP code to handle PDF upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['pdfFile'])) {
        $targetDir = "../public/uploads/";  // Adjust the path to the uploads folder
        $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is a PDF
        if ($fileType != "pdf") {
            echo "Only PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check if everything is okay before uploading
        if ($uploadOk == 1) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
                echo "The PDF file has been uploaded successfully.";
            } else {
                echo "There was an error uploading the file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }
}
?>
