<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box; ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR PENGAJAR <b class="text-danger">(Notes: Pastikan Data Sudah Benar!)</b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pengajar" class="control-label">Nama Pengajar</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nama_pengajar" id="nama_pengajar" data-error="Nama pengajar harus diisi" placeholder="Nama pengajar" value="<?php echo $nama_pengajar; ?>" required />
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
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
                                        <span class="input-group-addon">
                                            <span class="fas fa-genderless"></span>
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
                                        <input type="file" class="form-control" name="foto" id="foto" value="<?php echo $foto; ?>" required />
                                        <span class="input-group-addon">
                                            <span class="fas fa-user"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    <div class="text-right py-2">
                                        <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                                        <a href="<?php echo site_url('pengajar') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->