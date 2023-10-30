<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDPD Thailand Data</title>
    <!-- Bootstrap 5.3.2-->
    <link href="<?= base_url('assets/bootstrap-5.3.2/css/bootstrap.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/bootstrap-5.3.2/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.3.2/js/bootstrap.min.js') ?>"></script>

    <!-- Font Awesome 6.4.0-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="header">
        <!-- Your header content here -->
    </div>
    <div class="container">
        <div id="content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>



</body>

</html>