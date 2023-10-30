<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDPD Thailand Data</title>
    <!-- Include necessary CSS and JS files -->
    <!-- Bootstrap 5.3.2-->
    <link href="<?= base_url('assets/bootstrap-5.3.2/css/bootstrap.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/bootstrap-5.3.2/js/bootstrap.bundle.min.js') ?>"></script>


    <!-- Font Awesome 6.4.0-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JQuery 3.7.0-->
    <script src="<?= base_url('assets/jquery/jquery-3.7.0.min.js') ?>"></script>

    <!-- JQuery Thai Address autocomplete 1.5.3.5 -->
    <!-- Dependencies -->
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>

    <link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>

    <!-- SweetAlert2 v.11 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Data Table 1.13.6-->
    <link href="<?= base_url('assets/DataTables/datatables.min.css') ?> " rel="stylesheet">
    <script src="<?= base_url('assets/DataTables/datatables.min.js') ?> "></script>

    <!-- Pickadate 3.6.2 -->
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/pickadate/lib/themes/default.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/pickadate/lib/themes/default.date.css') ?>">

    <!-- JavaScript -->
    <script src="<?= base_url('assets/pickadate/lib/picker.js') ?>"></script>
    <script src="<?= base_url('assets/pickadate/lib/picker.date.js') ?>"></script>
    <script src="<?= base_url('assets/pickadate/lib/legacy.js') ?>"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>" />



</head>

<nav class="navbar navbar-expand-md" style="background-color: #DFCCFB;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="<?= base_url() ?>/assets/images/icon/globe-2-svgrepo-com.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            CDPDThailand Data
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('home')?>">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ฐานข้อมูล
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('patients')?>">ผู้พิการ</a></li>
                            <!-- <li><a class="dropdown-item" href="\patients\add">เพิ่มผู้พิการ</a></li> -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('caregivers')?>">ผู้ดูแล</a></li>
                            <!-- <li><a class="dropdown-item" href="\caregivers\add">เพิ่มผู้ดูแล</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url('saraban')?>">สารบรรญเอกสาร</a>
                        </li>
                    <?php if (session()->get('role') == 'Root') : ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url('users')?>">ผู้ใช้</a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('logout')?>">ออกจากระบบ</a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>


<body>
    <div id="header">
        <!-- Your header content here -->
    </div>
    <div class="container pt-3">
        <div id="content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <footer class="footer fixed-bottom bg-light mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">Your footer content here</span>
        </div>
    </footer>

</body>

</html>