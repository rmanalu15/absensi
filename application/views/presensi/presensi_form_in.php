<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">

<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>PRESENSI</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="nomor_induk" class="control-label">Nama User</label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="Nama user harus diisi" name="nomor_induk" id="nomor_induk" placeholder="Nama" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="jam_msk" class="control-label">Jam Masuk <?php echo form_error('jam_msk') ?></label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" data-error="Jam Masuk harus diisi" name="jam_msk" id="jam_msk" placeholder="Jam Masuk" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="jam_klr" class="control-label">Jam Pulang <?php echo form_error('jam_klr') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="jam_klr" id="jam_klr" placeholder="Jam selesai" readonly />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('presensi') ?>" class="btn btn-default">Cancel</a>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<script src="<?php echo base_url() ?>assets/plugins/jQueryUI/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css">
<script src="<?php echo base_url() ?>assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker({
        donetext: 'Selesai',
        autoclose: true,
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#nomor_induk').autocomplete({
            source: "<?php echo site_url('presensi/get_autocomplete'); ?>",
            select: function(event, ui) {
                $('[name="nomor_induk"]').val(ui.item.label);
            }
        });
    });
</script>