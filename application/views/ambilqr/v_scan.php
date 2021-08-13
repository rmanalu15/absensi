<div class="box box-widget">
    <?php
    $params['data'] = $nis;
    $params['level'] = 'H';
    $params['size'] = 4;
    $params['savename'] = FCPATH . "uploads/qr_image/" . $nis . 'code.png';
    $this->ciqrcode->generate($params);
    ?>

    <div id="print-area">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-primary">
                <div class="widget-user-image">
                    <img class="img-responsive" src="<?php echo base_url('uploads/qr_image/') . $nis . 'code.png'; ?>" />
                </div>
                <h3 class="widget-user-username"><?php echo $nis ?></h3>
                <h5 class="widget-user-desc"><?php echo $nama_santri; ?></h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><button onclick="printDiv('print-area')" class='pull-right'><i class='fa fa-print'></i>PRINT</button></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>