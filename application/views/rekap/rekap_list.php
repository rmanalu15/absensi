<style>
    table,
    th,
    td {
        text-align: center;
    }
</style>
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>REKAP ABSENSI</h3>
                </div>
                <div class="box-body">
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rekap User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pengajar</td>
                                <td>
                                    <a class="btn btn-lg btn-info btn3d" href="#" title="Rekap Absensi Pengajar" onclick="absen('P')"><i class="fa fa-check-square"></i> Absensi</a>
                                    <a class="btn btn-lg btn-primary btn3d" href="#" title="Laporan Absensi Pengajar" onclick="laporan('P')"><i class="glyphicon glyphicon-pencil"></i> Laporan</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Santri</td>
                                <td>
                                    <a class="btn btn-lg btn-info btn3d" href="#" title="Rekap Absensi Santri" onclick="absen('S')"><i class="fa fa-check-square"></i> Absensi</a>
                                    <a class="btn btn-lg btn-primary btn3d" href="#" title="Laporan Absensi Santri" onclick="laporan('S')"><i class="glyphicon glyphicon-pencil"></i> Laporan</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="modalAbsen" role="dialog" style="min-width: 100%;margin-left:10px">
                        <div class="modal-dialog" style="min-width: 100%;">
                            <div id="datakar"> </div>
                        </div><!-- /.modal-dialog -->
                    </div>
                </div><!-- /.modal -->
                <div class="modal fade" id="ModalLaporan" role="dialog" style="min-width: 100%;margin-left:10px">
                    <div class="modal-dialog" style="min-width: 100%;">
                        <div id="dataLap"></div>
                    </div><!-- /.modal-dialog -->
                </div>
            </div><!-- /.modal -->
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->
<script src="<?php echo base_url() ?>assets/app/core/rekaplist.js"></script>
<script src="<?php echo base_url() ?>assets/app/core/modalAbsen.js"></script>