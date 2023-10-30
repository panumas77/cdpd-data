<?= $this->extend('layout/no_nav.php') ?>

<?= $this->section('content') ?>
<div class="text-center pt-5">
    <img src="<?= base_url('assets/images/icon/sign.png') ?>" width="200px">

    <p class="fs-2">ขออภัย คุณไม่ได้รับสิทธิในการเข้าถึงเมนูนี้</p>
</div>
<div class="d-grid gap-2 col-lg-3 mx-auto">
<a href="<?= previous_url() ?>" class="btn btn-secondary">กลับไปก่อนหน้า</a>
</div>
<?= $this->endSection() ?>