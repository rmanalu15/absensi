<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-warning'>
                <div class='box-header with-border'>
                    <h3 class='box-title'>PRESENSI</h3>
                </div>
                <div class='box-body'>
                    <form id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <input type="hidden" class="form-control" name="nomor_induk" id="nomor_induk" placeholder="Id santri" value="<?php echo $nomor_induk; ?>" />
                        <div class="form-group">
                            <label for="nama_user" class="control-label">Nama User</label>
                            <div class="input-group">
                                <?php if ($nama_user_1) {
                                    $nama_user = $nama_user_1;
                                } else {
                                    $nama_user = $nama_user_2;
                                }
                                ?>
                                <input type="text" name="nama_user" class="form-control" placeholder="Nama User" value="<?= $nama_user; ?>" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="tgl" class="control-label">Tanggal Masuk</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="tgl" id="tgl" placeholder="Tanggal Masuk" value="<?php echo $tgl; ?>" readonly />
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="jam_msk" class="control-label">Jam Masuk</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="jam_msk" id="jam_msk" placeholder="Jam Msk" value="<?php echo $jam_msk; ?> " readonly />
                                <span class="input-group-addon">
                                    <span class="fa fa-clock"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <?php if ($id_khd == 1) : ?>
                            <div class="form-group">
                                <label for="jam_klr" class="control-label">Jam Keluar</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control" name="jam_klr" id="jam_klr" placeholder="Jam Msk" value="<?php echo $jam_klr; ?>" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        <?php else : ?>
                            <div class="form-group">
                                <label for="jam_klr" class="control-label">Jam Pulang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jam_klr" id="jam_klr" placeholder="Jam Msk" value="<?php echo $jam_klr; ?>" readonly />
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="id_shift" class="control-label">Kehadiran</label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('id_khd', 'id_khd', 'kehadiran', 'nama_khd', 'id_khd', $id_khd) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-list"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_shift" class="control-label">Keterangan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ket" id="ket" placeholder="Ket" value="<?php echo $ket; ?>" />
                                <span class="input-group-addon">
                                    <span class="fas fa-book-open"></span>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="id_absen" value="<?php echo $id_absen; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('presensi') ?>" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css">
<script src="<?php echo base_url() ?>assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker({
        donetext: 'Selesai',
        autoclose: true,
    });
</script>