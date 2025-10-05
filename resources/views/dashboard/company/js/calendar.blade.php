<script>
    function initCalendar(data) {
        const calendarEl = document.getElementById('calendar2')
        // reinit
        let calendar;
        if (calendar != undefined) {
            calendar.destroy();
        }

        calendar = new Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: data,
            plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
            editable: true,
            dayMaxEvents: 2,
            initialDate: new Date(),
            navLinks: true,
            eventClick: function(info) {
                eventClick(info);
            },
        });

        calendar.render();
    }

    function eventClick(info) {
        let name = info.event._def.title.split(" - ")[0];
        dataPayload.data_id_calendar = info.event._def.publicId;
        dataPayload.section = 'get_detail_calendar';

        let modal = $('#modal_detail_jadwal');
        
        loadData(function (res) {
            modal.find('#container_detail_jadwal').html(res.data);
            modal.find('#name_kandidat').text(name);
            modal.modal('show');
        });
    }
</script>
