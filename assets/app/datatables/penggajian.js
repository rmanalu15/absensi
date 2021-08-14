let table;

$(document).ready(function () {
    table = $("#penggajian").addClass('nowrap').DataTable({
        initComplete: function () {
            let api = this.api();
            $('#penggajian_filter input')
                .off('.DT')
                .on('keyup.DT', function (e) {
                    api.search(this.value).draw();
                });
        },
        responsive: true,
        processing: true,
        serverSide: true,
        colReorder: true,
        oLanguage: {
            sProcessing: "Loading..."
        },
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Show all']
        ],
        "order": [[0, 'asc']],
        ajax: {
            "url": base_url + "penggajian/data/",
            "type": "POST",
        },
        columns:
            [
                { 'data': 'id_absen', defaultContent: '' },
                { "data": "nama_pengajar" },
                { "data": "nama_khd" },
                { "data": null },
            ],
        dom: 'Blfrtip',
        buttons: [
            'colvis',
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
            },
            {
                extend: 'excel',
                title: 'HISTORI ABSENSI',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
            },
            {
                extend: 'copy',
                title: 'HISTORI ABSENSI',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
            },
            {
                extend: 'pdf',
                oriented: 'portrait',
                pageSize: 'legal',
                title: 'HISTORI ABSENSI',
                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyOdd.alignment = 'center';
                },
            },
            {
                extend: 'print',
                oriented: 'portrait',
                pageSize: 'A4',
                title: 'HISTORI ABSENSI',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
            },
        ],
        initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('#exportLink').on('change', function () {
                var btnClass = $(this).find(":selected")[0].id
                    ? '.buttons-' + $(this).find(":selected")[0].id
                    : null;
                if (btnClass) $buttons.find(btnClass).click();
            })
        },
        rowId: function (a) {
            return a;
        },
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
        },
    });
    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
            table.cell(cell).invalidate('dom');
        });
    }).draw();
});
