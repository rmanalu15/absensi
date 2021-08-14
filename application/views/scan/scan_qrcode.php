<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi TPQ Al Fatih</title>
    <link rel="stylesheet" href="<?= base_url('assets/plugins/'); ?>fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/bootstrap/css/custom-button.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/ionicons-2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/morris/morris.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fapicker/dist/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css.css">
    <link rel="icon" href="<?= base_url('assets/'); ?>images/favicon.png" type="image/gif">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>app/css/print.css">
    <script src="<?= base_url('assets/'); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #80afcd;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.4;
        }

        .btn-md {
            padding: 1rem 2.4rem;
            font-size: .94rem;
            display: none;
        }

        .swal2-popup {
            font-family: inherit;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <section class='content' id="demo-content">
        <div class='row'>
            <div class='col-xs-12'>
                <div class='box'>
                    <div class='box-header'></div>
                    <div class='box-body'>
                        <?php
                        $attributes = array('id' => 'button');
                        echo form_open('scan/cek_id', $attributes); ?>
                        <div id="sourceSelectPanel" style="display:none">
                            <label for="sourceSelect">Change Camera Sources:</label>
                            <select id="sourceSelect" style="max-width:400px"></select>
                        </div>
                        <div>
                            <video id="video" width="500" height="400" style="border: 1px solid gray"></video>
                        </div>
                        <textarea hidden="" name="nomor_induk" id="result" readonly></textarea>
                        <span> <input type="submit" id="button" class="btn btn-success btn-md" value="Cek Kehadiran"></span>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/zxing/zxing.min.js"></script>
    <script type="text/javascript">
        window.addEventListener('load', function() {
            let selectedDeviceId;
            let audio = new Audio("assets/audio/beep.mp3");
            const codeReader = new ZXing.BrowserQRCodeReader()
            console.log('ZXing code reader initialized')
            codeReader.getVideoInputDevices()
                .then((videoInputDevices) => {
                    const sourceSelect = document.getElementById('sourceSelect')
                    selectedDeviceId = videoInputDevices[0].deviceId
                    if (videoInputDevices.length >= 1) {
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option')
                            sourceOption.text = element.label
                            sourceOption.value = element.deviceId
                            sourceSelect.appendChild(sourceOption)
                        })
                        sourceSelect.onchange = () => {
                            selectedDeviceId = sourceSelect.value;
                        };
                        const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                        sourceSelectPanel.style.display = 'block'
                    }
                    codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
                        console.log(result)
                        document.getElementById('result').textContent = result.text
                        if (result != null) {
                            audio.play();
                        }
                        $('#button').submit();
                    }).catch((err) => {
                        console.error(err)
                        document.getElementById('result').textContent = err
                    })
                    console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
                })
                .catch((err) => {
                    console.error(err)
                })
        })
    </script>

    <script src="<?= base_url('assets/'); ?>plugins/morris/morris.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <!-- SlimScroll -->
    <script src="<?= base_url('assets/'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url('assets/'); ?>plugins/fastclick/fastclick.min.js"></script>
    <!-- page script -->
    <script src="<?= base_url('assets/'); ?>plugins/raphael/raphael-min.js"></script>
    <!-- sweetalert -->
    <script src="<?= base_url('assets/'); ?>plugins/sweetalert/sweetalert.min.js"></script>
    <!-- font awesome picker -->

    <script src="<?= base_url('assets/'); ?>plugins/fapicker/dist/js/fontawesome-iconpicker.js"></script>
    <script src="<?= base_url('assets/'); ?>plugins/sweetalert/sweetalert2.min.js"></script>
    <script src="<?= base_url('assets/'); ?>plugins/Bootstrap-validator/validator.js"></script>
    <script src="<?= base_url('assets/'); ?>app/core/alert.js"></script>
    <script src="<?= base_url('assets/'); ?>app/core/iconpicker.js"></script>
    <script>
        <?= $this->session->flashdata('messageAlert'); ?>
    </script>
</body>

</html>