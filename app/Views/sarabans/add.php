<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5">เพิ่มข้อมูลผู้พิการ</h1>
<hr>
<?php if (session()->getFlashdata('success')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?= form_open_multipart('saraban/add', ['class' => 'needs-validation', 'novalidate' => true, 'autocomplete' => 'off', 'accept-charset' => 'UTF-8']) ?>

<div class="row mb-3">
    <div class="col-lg-2">
        <label for="doc_id" class="form-label"><strong>เลขที่เอกสาร <span class="text-danger">*</span></strong></label>
        <input type="text" name="doc_id" id="doc_id" class="form-control" maxlength="15" value="<?= set_value('doc_id') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก เลขที่เอกสาร.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="doc_cat" class="form-label"><strong>เอกสาร <span class="text-danger">*</span></strong></label>
        <select name="doc_cat" id="doc_cat" class="form-select" required>
            <option value="">-- เลือก --</option>
            <option value="เอกสารราชการ" <?= set_value('doc_cat') == 'เอกสารราชการ' ? 'selected' : '' ?>>เอกสารราชการ</option>
            <option value="เอกสารโรงพยาบาล" <?= set_value('doc_cat') == 'เอกสารโรงพยาบาล' ? 'selected' : '' ?>>เอกสารโรงพยาบาล</option>
            <option value="เอกสารพัฒนาวิชาชีพ" <?= set_value('doc_cat') == 'เอกสารพัฒนาวิชาชีพ' ? 'selected' : '' ?>>เอกสารพัฒนาวิชาชีพ</option>
            <option value="เอกสารับบริการ" <?= set_value('doc_cat') == 'เอกสารับบริการ' ? 'selected' : '' ?>>เอกสารับบริการ</option>
        </select>
        <div class="invalid-feedback">
            กรุณากรอก เอกสาร.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="date_add" class="form-label"><strong>ลงวันที่ <span class="text-danger">*</span></strong></label>
        <div class="input-group">
            <input type="text" name="date_add" id="date_add" class="form-control datepicker" value="<?= set_value('date_add') ?>" placeholder="วว-ดด-ปปปป" required>
            <div class="invalid-feedback">
                กรุณากรอก ลงวันที่.
            </div>
            <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
        </div>
    </div>
    <div class="col-lg-6">
        <label for="doc_object" class="form-label"><strong>เรื่อง</strong></label>
        <input type="text" name="doc_object" id="doc_object" class="form-control" maxlength="70" value="<?= set_value('doc_object') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก เรื่อง.
        </div>
    </div>

</div>
<div class="row mb-3">
    <div class="col-lg-3">
        <label for="doc_from" class="form-label"><strong>จาก <span class="text-danger">*</span></strong></label>
        <input type="text" name="doc_from" id="doc_from" class="form-control" maxlength="50" value="<?= set_value('doc_from') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก จาก.
        </div>
    </div>
    <div class="col-lg-3">
        <label for="doc_to" class="form-label"><strong>ถึง <span class="text-danger">*</span></strong></label>
        <input type="text" name="doc_to" id="doc_to" class="form-control" maxlength="50" value="<?= set_value('doc_to') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก ถึง.
        </div>
    </div>


</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <label for="doc_pdf" class="form-label">เอกสาร PDF (ไฟล์ไม่เกิน 10Mb)</label>
        <input type="file" class="form-control" id="doc_pdf" name="doc_pdf" required>
        <div class="invalid-feedback">กรุณาเลือกเอกสาร PDF</div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">บันทึก</button>
    <a href="<?= previous_url() ?>" class="btn btn-secondary">ยกเลิก</a>
</div>
<?= form_close() ?>
<br>
<br>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
    })();

    // Initialize the datepicker Buddhist era.

    $('.datepicker').pickadate({
        selectYears: true,
        selectMonths: true,
        min: new Date(2010, 12, 1),
        max: new Date(),
        // max: new Date(2023, 12, 31),
        selectYears: 10,
        monthsFull: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        today: 'วันนี้',
        clear: 'ล้าง',
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        hiddenName: true

    });

</script>


<?= $this->endSection() ?>