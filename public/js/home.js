document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [], // Events will be loaded dynamically via AJAX
        dateClick: function(info) {
            $('#selectedDate').text(info.dateStr);
            showBorrowerList(info.dateStr); // Show borrower list for clicked date
        }
    });
    calendar.render();

    // Load schedules from the database once on page load
    loadSchedules();

    async function loadSchedules() {
        try {
            const response = await $.ajax({
                url: 'get_schedules.php',
                method: 'GET',
                dataType: 'json'
            });

            // Tambahkan data dengan ID yang didapatkan dari server
            response.forEach(function(event) {
                calendar.addEvent({
                    id: event.id, // Menambahkan ID ke setiap event
                    title: event.title,
                    start: event.start,
                    end: event.end
                });
            });
        } catch (error) {
            console.error("Error loading schedules:", error);
        }
    }

    function showBorrowerList(date) {
        const borrowers = calendar.getEvents().filter(event => event.startStr === date);
        $('#borrowerList').empty(); // Clear existing list

        if (borrowers.length === 0) {
            $('#borrowerList').append('<p>No borrowers found for this date.</p>');
        } else {
            borrowers.forEach(function(borrower) {
                const card = $('<div class="borrower-card"></div>').append(
                    `<span>${borrower.title}</span>`
                );
                const actions = $('<div class="actions"></div>').append(
                    `<button class="btn btn-warning btn-sm edit-button" data-id="${borrower.id}" data-title="${borrower.title}">Edit</button>`,
                    `<button class="btn btn-danger btn-sm delete-button" data-id="${borrower.id}">Delete</button>`,
                    `<button class="btn btn-info btn-sm check-id-button" data-id="${borrower.id}">Check ID</button>` // Tombol baru untuk cek ID
                );
                card.append(actions);
                $('#borrowerList').append(card);
            });
        }

        $('#borrowerListModal').modal('show');
    }

    // Handle form submission using AJAX for adding/editing schedules
    $('#scheduleForm').on('submit', async function(event) {
        event.preventDefault();

        const formData = {
            id: $('#id').val(), // Mendapatkan ID dari input hidden
            bookTitle: $('#bookTitle').val(),
            borrowerName: $('#borrowerName').val(),
            startDate: $('#startDate').val(),
            endDate: $('#endDate').val()
        };

        console.log("Form submitted with ID:", formData.id); // Debug output untuk memeriksa ID

        const url = formData.id ? 'update_schedule.php' : 'save_schedule.php'; // Tentukan URL berdasarkan apakah ID ada

        try {
            const response = await $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'json' // Pastikan response dalam format JSON
            });

            if (response.status === "Success") {
                console.log("Operation successful for ID:", response.id); // Menampilkan ID yang diproses
                if (formData.id) {
                    // Update event in calendar
                    const event = calendar.getEventById(response.id);
                    if (event) {
                        console.log("Updating event with ID:", formData.id);
                        event.setProp('title', `${formData.bookTitle} - ${formData.borrowerName}`);
                        event.setDates(formData.startDate, formData.endDate);
                    }
                } else {
                    // Menambahkan event baru jika tidak ada ID
                    calendar.addEvent({
                        id: response.id, // Menggunakan ID dari server untuk event baru
                        title: `${formData.bookTitle} - ${formData.borrowerName}`,
                        start: formData.startDate,
                        end: formData.endDate
                    });
                }
            } else {
                alert("Error saving: " + response.message + " for ID: " + response.id);
            }
        } catch (error) {
            console.error("Error saving schedule:", error);
        }

        // Tutup modal dan reset form
        $('#scheduleModal').modal('hide');
        $('#scheduleForm')[0].reset();
        showBorrowerList(formData.startDate);
    });

    // Event handling for delete
    $(document).on('click', '.delete-button', async function() {
        const id = $(this).data('id');
        const date = $('#selectedDate').text();
        console.log("Attempting to delete ID:", id); // Debug output untuk memeriksa ID

        try {
            const response = await $.ajax({
                url: 'delete_schedule.php',
                method: 'POST',
                data: { id: id }, // Kirim id ke PHP
                dataType: 'json' // Pastikan response dalam format JSON
            });

            if (response.status === "Success") {
                console.log("Deleted ID:", response.id); // Menampilkan ID yang dihapus
                const event = calendar.getEventById(response.id); // Hapus event dari kalender berdasarkan id
                if (event) event.remove();
                showBorrowerList(date);
            } else {
                alert("Error deleting: " + response.message + " for ID: " + response.id);
            }
        } catch (error) {
            console.error("Error deleting schedule:", error);
        }
    });

    // Event handling for check ID
    $(document).on('click', '.check-id-button', async function() {
        const id = $(this).data('id');
        console.log("Checking ID:", id); // Debug output untuk memeriksa ID

        try {
            const response = await $.ajax({
                url: 'check_id.php', // Handler untuk memeriksa ID
                method: 'POST',
                data: { id: id }, // Kirim ID ke PHP
                dataType: 'json'
            });

            // Update bagian HTML dengan hasil pengecekan ID
            if (response.status === "Success") {
                // Hapus baris kosong dan tambahkan baris baru
                $('#idCheckResultTable').empty();
                $('#idCheckResultTable').append(`
                    <tr>
                        <td>${response.id}</td>
                        <td>${response.bookTitle}</td>
                        <td>${response.borrowerName}</td>
                        <td>${response.startDate}</td>
                        <td>${response.endDate}</td>
                    </tr>
                `);
            } else {
                $('#idCheckResultTable').html(`<tr><td colspan="4">ID ${response.id} tidak ditemukan.</td></tr>`);
            }

        } catch (error) {
            console.error("Error checking ID:", error);
            $('#idCheckResultTable').html(`<tr><td colspan="4">Terjadi kesalahan saat memeriksa ID.</td></tr>`);
        }
    });

    // Event handling for edit
    $(document).on('click', '.edit-button', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        console.log("Editing ID:", id); // Debug output untuk memeriksa ID

        const selectedSchedule = calendar.getEventById(id);

        if (selectedSchedule) {
            const [bookTitle, borrowerName] = title.split(' - ');
            $('#bookTitle').val(bookTitle);
            $('#borrowerName').val(borrowerName);
            $('#startDate').val(selectedSchedule.startStr);
            $('#endDate').val(selectedSchedule.endStr);
            $('#id').val(id); // Set the ID in the hidden input field
            $('#displayId').text(id); // Tampilkan ID di form

            $('#scheduleModal').modal('show');
        }
    });

    // Show the schedule modal when adding a new schedule
    $('#addLoanButton').on('click', function() {
        $('#scheduleModal').modal('show');
        $('#scheduleForm')[0].reset(); // Reset form fields for a new entry
        $('#id').val(''); // Clear hidden input for ID
    });
});