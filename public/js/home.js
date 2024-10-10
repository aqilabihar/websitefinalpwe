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

    // Load schedules from the controller via AJAX
    loadSchedules();

    async function loadSchedules() {
        try {
            const response = await $.ajax({
                url: '/index.php?action=getSchedules',
                method: 'GET',
                dataType: 'json'
            });

            response.forEach(function(event) {
                calendar.addEvent({
                    id: event.id, // Menambahkan ID ke setiap event
                    title: event.title, // Nama Kegiatan
                    start: event.start, // Tanggal Usulan + Waktu Mulai
                    end: event.end // Tanggal Usulan + Waktu Selesai
                });
            });
        } catch (error) {
            console.error("Error loading schedules:", error);
        }
    }

    function showBorrowerList(date) {
        const borrowers = calendar.getEvents().filter(event => event.startStr.split('T')[0] === date);
        $('#borrowerList').empty(); // Clear existing list

        if (borrowers.length === 0) {
            $('#borrowerList').append('<p>No activities found for this date.</p>');
        } else {
            borrowers.forEach(function(borrower) {
                const card = $('<div class="borrower-card"></div>').append(
                    `<span>${borrower.title}</span>` // Nama Kegiatan
                );
                const actions = $('<div class="actions"></div>').append(
                    `<button class="btn btn-warning btn-sm edit-button" data-id="${borrower.id}" data-title="${borrower.title}">Edit</button>`,
                    `<button class="btn btn-danger btn-sm delete-button" data-id="${borrower.id}">Delete</button>`,
                    `<button class="btn btn-info btn-sm check-id-button" data-id="${borrower.id}">Check ID</button>` // Tombol untuk cek ID
                );
                card.append(actions);
                $('#borrowerList').append(card);
            });
        }

        $('#borrowerListModal').modal('show');
    }
});
