        <!-- Main content -->
        <section class='content'>
            <div class='row'>
                <div class='col-xs-12'>
                    <div class='box box-danger'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>DATA REKAP ABSENSI
                        </div><!-- /.box-header -->
                        <div class='box-body'>
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style='text-align:center;'>History User</th>
                                        <th width="10%" style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='text-align:center;'>1</td>
                                        <td style='text-align:center;'>Pengajar</td>
                                        <td style="text-align:center" width="140px">
                                            <?php echo anchor(site_url('presensi/read/P'), '<i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;Lihat', array('title' => 'detail', 'class' => 'btn btn-mdb-color ')); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='text-align:center;'>2</td>
                                        <td style='text-align:center;'>Santri</td>
                                        <td style="text-align:center" width="140px">
                                            <?php echo anchor(site_url('presensi/read/S'), '<i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;Lihat', array('title' => 'detail', 'class' => 'btn btn-mdb-color ')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
                            <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
                            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#mytable").dataTable();
                                });
                            </script>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->