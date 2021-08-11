<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR SANTRI <b class="text-danger">(Notes: Pastikan Data Sudah Benar!)</b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_santri" class="control-label">Nama Santri</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nama_santri" id="nama_santri" data-error="Nama santri harus diisi" placeholder="Nama santri" value="<?php echo $nama_santri; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir" class="control-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="fas fa-map-marker"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <?php echo cmb_dinamis('jenis_kelamin', 'jenis_kelamin', 'gender', 'gender', 'gender', $jenis_kelamin) ?>
                                        <span class="input-group-addon">
                                            <span class="fas fa-users"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="control-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="fas fa-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat" class="control-label">Alamat</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="fas fa-map-marker"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kelompok_id" class="control-label">Kelompok</label>
                                    <div class="input-group">
                                        <?php echo cmb_dinamis('kelompok_id', 'kelompok_id', 'kelompok', 'nama_kelompok', 'id_kelompok', $kelompok_id) ?>
                                        <span class="input-group-addon">
                                            <span class="fas fa-users"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_orang_tua" class="control-label">Nama Orang Tua</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nama_orang_tua" id="nama_orang_tua" placeholder="Nama Orang Tua" value="<?php echo $nama_orang_tua; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="fas fa-user"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="shift_id" class="control-label">Shift</label>
                                    <div class="input-group">
                                        <?php echo cmb_dinamis('shift_id', 'shift_id', 'shift', 'nama_shift', 'id_shift', $shift_id) ?>
                                        <span class="input-group-addon">
                                            <span class="fas fa-retweet"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto" class="control-label">Foto</label>
                                    <div class="input-group">
                                        <div class="col-md-4">
                                            <img src="<?= base_url('assets/images/profile/') . $foto; ?>" class="img-thumbnail">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-file">
                                                <input type="file" class="form-control" id="foto" name="foto" value="<?= $foto; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('santri') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->