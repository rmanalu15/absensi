let table;

$(document).ready(function () {
    table = $("#mytable").addClass('nowrap').DataTable({
        initComplete: function () {
            let api = this.api();
            $('#pengajar_filter input')
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
            sProcessing: "loading..."
        },
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Show all']
        ],
        "order": [[0, 'asc']],
        ajax: {
            "url": base_url + "pengajar/data",
            "type": "POST",
        },
        columns:
            [
                { 'data': 'id', defaultContent: '' },
                { 'data': "nip" },
                { "data": "nama_pengajar" },
                { "data": "jenis_kelamin" },
                { "data": "tanggal_lahir" },
                { "data": "nama_shift" },
                { "data": "alamat" },
                {
                    "data": null,
                },
            ],
        "columnDefs": [
            {
                "data": {
                    "id": "id",
                },
                "targets": 7,
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    let btn;
                    if (checkLogin == 1) {
                        return `<a href="${base_url}pengajar/update/${data.id}" title="edit" class="btn btn-md btn-warning  btn-edit-data">
                        <i class="fa fa-pencil-square-o"></i> Edit
                        </a>
                        <a href="${base_url}pengajar/delete/${data.id}" title="hapus" class="btn btn-md btn-danger btn3d btn-remove-data">
                        <i class="fa fa-trash"></i> Hapus
                        </a>
                        <a href="${base_url}pengajar/delete/${data.id}" title="hapus" class="btn btn-md btn-danger btn3d btn-remove-data">
                        <i class="fa fa-trash"></i> Cetak
                        </a>`;
                    }
                    else {
                        return `<a href="#" title="edit" class="btn btn-md btn-success btn3d btn-view-data">
                        <i class="fa fa-eye"></i> Action
                        </a>`;
                    }
                }
            },
        ],
        dom: 'Blfrtip',
        buttons: [
            'colvis',
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'excel',
                title: 'Data Pengajar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'copy',
                title: 'Data Pengajar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: 'pdf',
                oriented: 'portrait',
                pageSize: 'legal',
                title: 'Data Pengajar',
                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
                title: 'Data Pengajar',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
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

    if (checkLogin == 0) {
        $('.btn-create-data').hide();
        $('.btn-warning').css("display", "none");
    }
});