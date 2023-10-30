<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Your edit view content here -->
<h1 class="display-5">Edit User</h1>
<hr>
<!-- Display validation errors if any -->
<?php if (isset($validation)) : ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<!-- User creation form -->
<?= form_open('users/update/' . $user['id'], ['class' => 'needs-validation', 'novalidate' => true, 'autocomplete' => 'off']) ?>
<!-- Full Name -->
<div class="row mb-3">
    <div class="col-lg-2">
        <label for="username" class="form-label">ชื่อผู้ใช้ (Username)</label><span class="text-danger">*</span>
        <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
    </div>
    <div class="col-lg-3">
        <label for="fullName" class="form-label">Full Name</label><span class="text-danger">*</span>
        <input type="text" class="form-control" id="fullName" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
    </div>

    <!-- Nickname -->
    <div class="col-lg-2">
        <label for="nickname" class="form-label">Nickname</label>
        <input type="text" class="form-control" id="nickname" name="nickname" value="<?= old('nickname', $user['nickname']) ?>">
    </div>

    <!-- Position -->
    <div class="col-lg-5">
        <label for="position" class="form-label">Position</label><span class="text-danger">*</span>
        <input type="text" class="form-control" id="position" name="position" value="<?= old('position', $user['position']) ?>" required>
    </div>
</div>

<!-- Email -->
<div class="row mb-3">
    <div class="col-lg-5">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>">
    </div>

    <!-- Role -->
    <div class="col-lg-4">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role">
            <option value="User" <?= old('role', $user['role']) === 'User' ? 'selected' : '' ?>>User</option>
            <option value="Admin" <?= old('role', $user['role']) === 'Admin' ? 'selected' : '' ?>>Admin</option>
            <option value="Root" <?= old('role', $user['role']) === 'Root' ? 'selected' : '' ?>>Root</option>
        </select>
    </div>

    <!-- Active -->
    <div class="col-lg-3">
        <label for="active" class="form-label">Active</label>
        <select class="form-select" id="active" name="active">
            <option value="1" <?= old('active', $user['active']) == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= old('active', $user['active']) == 0 ? 'selected' : '' ?>>No</option>
        </select>
    </div>
</div>

<button type="submit" class="btn btn-primary">อัพเดท</button>
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