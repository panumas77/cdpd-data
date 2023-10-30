<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5"><i class="fa-solid fa-hands-holding"></i> เพิ่มข้อมูลผู้ดูแล</h1>
<hr>
<?= form_open_multipart('/caregivers/add', ['class' => 'needs-validation', 'novalidate' => true, 'autocomplete' => 'off']) ?>

<div class="row mb-3">
    <div class="col-lg-6">
        <label for="full_name" class="form-label"><strong>ชื่อ-สกุล <span class="text-danger">*</span></strong></label>
        <input type="text" name="full_name" id="full_name" class="form-control" maxlength="100" value="<?= set_value('full_name') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก ชื่อ-สกุล.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="gender" class="form-label"><strong>เพศ</strong></label>
        <select name="gender" id="gender" class="form-select">
            <option value="">-- เลือก --</option>
            <option value="ชาย" <?= set_value('gender') == 'ชาย' ? 'selected' : '' ?>>ชาย</option>
            <option value="หญิง" <?= set_value('gender') == 'หญิง' ? 'selected' : '' ?>>หญิง</option>
        </select>
        <div class="invalid-feedback">
            กรุณากรอก เพศ.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="birthdate" class="form-label"><strong>วันเกิด <span class="text-danger">*</span></strong></label>
        <div class="input-group">
            <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" value="<?= set_value('birthdate') ?>" placeholder="วว-ดด-ปปปป" required>
            <div class="invalid-feedback">
                กรุณากรอก วันเกิด.
            </div>
            <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
        </div>
    </div>
    <div class="col-lg-2">
        <label for="religion" class="form-label"><strong>ศาสนา</strong></label>
        <select name="religion" id="religion" class="form-select">
            <option value="">-- เลือก --</option>
            <option value="พุทธ" <?= set_value('religion') == 'พุทธ' ? 'selected' : '' ?>>พุทธ</option>
            <option value="คริสต์" <?= set_value('religion') == 'คริสต์' ? 'selected' : '' ?>>คริสต์</option>
            <option value="อิสลาม" <?= set_value('religion') == 'อิสลาม' ? 'selected' : '' ?>>อิสลาม</option>
            <option value="ไม่มีศาสนา" <?= set_value('religion') == 'ไม่มีศาสนา' ? 'selected' : '' ?>>ไม่มีศาสนา</option>
        </select>
        <div class="invalid-feedback">
            กรุณากรอก ศาสนา.
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-lg-3">
        <label for="personal_id_number" class="form-label"><strong>เลขบัตรประชาชน <span class="text-danger">*</span></strong></label>
        <input type="text" name="personal_id_number" id="personal_id_number" class="form-control" maxlength="13" value="<?= set_value('personal_id_number') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก เลขบัตรประชาชน.
        </div>
    </div>
    <div class="col-lg-3">
        <label for="phone_number" class="form-label"><strong>เบอร์ติดต่อ<span class="text-danger">*</span></strong></label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" maxlength="10" value="<?= set_value('phone_number') ?>" required>
        <div class="invalid-feedback">
            กรุณากรอก เบอร์ติดต่อ.
        </div>
    </div>
    <div class="col-lg-3">
        <label for="email" class="form-label"><strong>อีเมล์</strong></label>
        <input type="text" name="email" id="email" class="form-control" maxlength="70" value="<?= set_value('email') ?>">
        <div class="invalid-feedback">
            กรุณากรอก อีเมล์.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="relationship" class="form-label"><strong>ความสัมพันท์ <span class="text-danger">*</span></strong></label>
        <select name="relationship" id="relationship" class="form-select" required>
            <option value="">-- เลือก --</option>
            <option value="สามี" <?= set_value('relationship') == 'สามี' ? 'selected' : '' ?>>สามี</option>
            <option value="ภรรยา" <?= set_value('relationship') == 'ภรรยา' ? 'selected' : '' ?>>ภรรยา</option>
            <option value="พ่อ" <?= set_value('relationship') == 'พ่อ' ? 'selected' : '' ?>>พ่อ</option>
            <option value="แม่" <?= set_value('relationship') == 'แม่' ? 'selected' : '' ?>>แม่</option>
            <option value="ลูก" <?= set_value('relationship') == 'ลูก' ? 'selected' : '' ?>>ลูก</option>
            <option value="หลาน" <?= set_value('relationship') == 'หลาน' ? 'selected' : '' ?>>หลาน</option>
            <option value="ลุง" <?= set_value('relationship') == 'ลุง' ? 'selected' : '' ?>>ลุง</option>
            <option value="ป้า" <?= set_value('relationship') == 'ป้า' ? 'selected' : '' ?>>ป้า</option>
            <option value="น้า" <?= set_value('relationship') == 'น้า' ? 'selected' : '' ?>>น้า</option>
            <option value="อา" <?= set_value('relationship') == 'อา' ? 'selected' : '' ?>>อา</option>
            <option value="ญาติ" <?= set_value('relationship') == 'ญาติ' ? 'selected' : '' ?>>ญาติ</option>
        </select>
        <div class="invalid-feedback">
            กรุณากรอก ความสัมพันท์.
        </div>
    </div>
</div>

<h5><strong>ข้อมูลที่อยู่</strong></h5>
<hr>
<div class="row mb-3">
    <div class="col-lg-4">
        <label for="address" class="form-label"><strong>ที่อยู่</strong></label>
        <input type="text" name="address" id="address" class="form-control" maxlength="100" value="<?= set_value('address') ?>">
        <div class="invalid-feedback">
            กรุณากรอก ที่อยู่.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="district" class="form-label"><strong>ตำบล</strong></label>
        <input type="text" name="district" id="district" class="form-control" maxlength="100" value="<?= set_value('district') ?>">
        <div class="invalid-feedback">
            กรุณากรอก ตำบล.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="amphoe" class="form-label"><strong>อำเภอ</strong></label>
        <input type="text" name="amphoe" id="amphoe" class="form-control" maxlength="100" value="<?= set_value('amphoe') ?>">
        <div class="invalid-feedback">
            กรุณากรอก อำเภอ.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="province" class="form-label"><strong>จังหวัด</strong></label>
        <input type="text" name="province" id="province" class="form-control" maxlength="100" value="<?= set_value('province') ?>">
        <div class="invalid-feedback">
            กรุณากรอก จังหวัด.
        </div>
    </div>
    <div class="col-lg-2">
        <label for="zipcode" class="form-label"><strong>รหัสไปรษณี</strong></label>
        <input type="text" name="zipcode" id="zipcode" class="form-control" maxlength="100" value="<?= set_value('zipcode') ?>">
        <div class="invalid-feedback">
            กรุณากรอก รหัสไปรษณี.
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <label for="profile_picture" class="form-label">รูปภาพผู้ดูแล</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
        <div class="invalid-feedback">กรุณาเลือกรูปภาพผู้ดูแล</div>
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
    var buddhistYearStart = 1940 + 543; // Start year (Gregorian)
    var buddhistCerrentYear = new Date().getFullYear() + 543; // End year (Gregorian)

    $('.datepicker').pickadate({
        selectYears: true,
        selectMonths: true,
        min: new Date(buddhistYearStart, 12, 1),
        max: new Date(buddhistCerrentYear, 12, 31),
        selectYears: 85,
        monthsFull: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        today: 'วันนี้',
        clear: 'ล้าง',
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        hiddenName: true

    });


    $.Thailand({
        $district: $('#district'), // input ของตำบล
        $amphoe: $('#amphoe'), // input ของอำเภอ
        $province: $('#province'), // input ของจังหวัด
        $zipcode: $('#zipcode'), // input ของรหัสไปรษณีย์
    });
</script>


<?= $this->endSection() ?>