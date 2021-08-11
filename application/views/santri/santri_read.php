<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Santri Read</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Kode Santri</td>
                            <td><?php echo $nis; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Santri</td>
                            <td><?php echo $nama_santri; ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td><?php echo $nama_jabatan; ?></td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td><?php echo $nama_shift; ?></td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td><?php echo $nama_gedung; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('santri') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->