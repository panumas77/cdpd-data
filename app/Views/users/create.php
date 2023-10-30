<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <!-- Your create view content here -->
    <h1 class="display-5">เพิ่มผู้ใช้</h1>
    <hr>

        <!-- User creation form -->
        <?= form_open('users/create', ['class' => 'needs-validation', 'novalidate' => true, 'autocomplete' => 'off']) ?>
        <div class="row mb-3">
            <div class="col-lg-4">
                <label for="full_name" class="form-label">ชื่อ-สกุล</label><span class="text-danger">*</span>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= set_value('full_name') ?>" required>
            </div>
            <div class="col-lg-2">
                <label for="nickname" class="form-label">ชื่อเล่น</label>
                <input type="text" class="form-control" id="nickname" name="nickname" value="<?= set_value('nickname') ?>">
            </div>
            <div class="col-lg-6">
                <label for="position" class="form-label">ตำแหน่ง</label><span class="text-danger">*</span>
                <input type="text" class="form-control" id="position" name="position" value="<?= set_value('position') ?>" required>
            </div>

        </div>
        <div class="row mb-3">
        <div class="col-lg-4">
                <label for="username" class="form-label">ชื่อผู้ใช้ (Username)</label><span class="text-danger">*</span>
                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" required>
            </div>
            <div class="col-lg-4">
                <label for="password" class="form-label">พาสเวิร์ด</label><span class="text-danger">*</span>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col-lg-4">
                <label for="email" class="form-label">อีเมล์</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>">
            </div>
            
        </div>
        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="role" class="form-label">สิทธิ</label>
                <select class="form-select" id="role" name="role">
                    <option value="User" <?= set_select('role', 'User') ?>>User</option>
                    <option value="Admin" <?= set_select('role', 'Admin') ?>>Admin</option>
                    <option value="Root" <?= set_select('role', 'Root') ?>>Root</option>

                </select>
            </div>
            <div class="col-lg-6">
                <label for="active" class="form-label">ใช้งาน</label>
                <select class="form-select" id="active" name="active">
                    <option value="1" <?= set_select('role', 'User') ?>>Yes</option>
                    <option value="0" <?= set_select('role', 'Admin') ?>>No</option>

                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">เพิ่มผู้ใช้</button>
        <a href="<?= base_url('users') ?>" class="btn btn-secondary">ยกเลิก</a>
        <?= form_close() ?>


    </div>

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

</script>
<?= $this->endSection() ?>
