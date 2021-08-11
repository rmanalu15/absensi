<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?= $box ?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORMULIR KELOMPOK</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="form-group has-feedback">
                            <label for="nama_kelompok"> Nama Kelompok <?php echo form_error('nama_kelompok') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="Nama kelompok harus diisi" name="nama_kelompok" id="nama_kelompok" placeholder="Nama kelompok" value="<?php echo $nama_kelompok; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <input type="hidden" name="id_kelompok" value="<?php echo $id_kelompok; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('kelompok') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->