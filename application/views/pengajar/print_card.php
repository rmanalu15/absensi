<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/'); ?>fontawesome/css/all.min.css" />
    <title>PRINT CARD</title>
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

        .container {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            width: 265px;
            height: 365px;
            position: relative;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.315);
        }

        .container .container__profile {
            background-color: #e4f2fd;
            display: flex;
            align-items: center;
            padding: 20px;
            position: absolute;
            right: 0;
            left: 0;
            bottom: 0;
        }

        .container .container__profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-position: center;
            object-fit: cover;
            margin-right: 10px;
        }

        .container .container__profile h2 {
            color: #334454;
            font-size: 1.2rem;
        }

        .container .container__profile p {
            color: #a1b2bc;
            font-size: 0.8rem;
        }

        .container .container__profile p b {
            font-style: italic;
        }
    </style>
</head>

<body>
    <?php
    $params['data'] = $card['nip'];
    $params['level'] = 'H';
    $params['size'] = 4;
    $params['savename'] = FCPATH . "uploads/qr_image/" . $card['nip'] . 'code.png';
    $this->ciqrcode->generate($params);
    ?>

    <div class="container">
        <img style="width: 265px;" src="<?= base_url('uploads/qr_image/') . $card['nip'] . 'code.png'; ?>" />
        <di class="container__profile">
            <img src="<?= base_url('assets/images/profile/') . $card['foto'] ?>" alt="people" />
            <div class="container__profile__text">
                <h2><?= $card['nama_pengajar']; ?></h2>
                <p>By <b>TPQ Al Fatih</b></p>
            </div>
        </di>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>