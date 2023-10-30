<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5"><i class="fa-solid fa-hands-holding"></i> ผู้ดูแล <small><a href="/caregivers/add" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> เพิ่มผู้ดูแล</a></small></h1>
<hr>
<?php if (session()->getFlashdata('success')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<div class="table-responsive">
    <table id="caregiversTable" class="table table-striped">
        <thead>
            <tr>
                <th class="d-none d-lg-table-cell">เลขประชาชน</th>
                <th>ชื่อ-สกุล</th>
                <th class="d-none d-lg-table-cell">เพศ</th>
                <th class="d-none d-lg-table-cell">วันเกิด</th>
                <th class="d-none d-lg-table-cell">อายุ</th>
                <th>คำสั่ง</th>
                <!-- Add other columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($caregivers as $caregiver) : ?>
                <tr>
                    <td class="d-none d-lg-table-cell"><?= $caregiver['personal_id_number'] ?></td>
                    <td><?= $caregiver['full_name'] ?></td>
                    <td class="d-none d-lg-table-cell"><?= $caregiver['gender'] ?></td>
                    <td class="d-none d-lg-table-cell"><?= date('d-m-Y', strtotime($caregiver['birthdate'])) ?></td>
                    <td class="d-none d-lg-table-cell"></td>
                    <td>
                        <!-- Action buttons -->
                        <button class="btn btn-info btn-sm btn-view" data-caregiverid="<?= $caregiver['id'] ?>"><i class="fa-solid fa-info"></i></button>
                        <a href="/caregivers/edit/<?= $caregiver['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-caregiverid="<?= $caregiver['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ลบข้อมูล."><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal to display caregiver info -->
<div class="modal fade" id="caregiverInfoModal" tabindex="-1" aria-labelledby="caregiverInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="caregiverInfoModalLabel">ข้อมูลรายละเอียดผู้ดูแล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="caregiverInfoModalBody">
                <!-- caregiver info will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle click event on info button
        $(document).on('click', '.btn-view', function() {
            var caregiverId = $(this).data('caregiverid');

            // Make an AJAX request to fetch the caregiver info
            $.ajax({
                url: '/caregivers/info/' + caregiverId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched caregiver info HTML
                    $('#caregiverInfoModalBody').html(response);

                    // Show the modal
                    $('#caregiverInfoModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch caregiver info.');
                }
            });
        });

        // Handle click event on delete button
        $(document).on('click', '.btn-delete', function() {
            var caregiverId = $(this).data('caregiverid');

            Swal.fire({
                title: "คุณแน่ใจที่จะลบใช่หรือไม่?",
                text: "หากต้องการรายการนี้จะถูกลบถาวรไปจากฐานข้อมูล",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบ!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/caregivers/delete/' + caregiverId,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'รายการที่เลือกถูกลบแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        // Initialize DataTables
        $('#caregiversTable').DataTable({
        "dom": 'Pfrtp',
        "columnDefs": [
        {
            "targets": [4], // Index of the calculated column (starting from 0)
            "render": function(data, type, row, meta) {
                // Calculate the age based on the date_of_birth
                var dateOfBirth = moment(row[3], 'DD-MM-YYYY'); // Assuming the date_of_birth is in the fourth column
                var today = moment();
                var ageYears = today.diff(dateOfBirth, 'years') +543;
                var ageMonths = today.diff(dateOfBirth, 'months') % 12;

                // Construct the age string
                var ageString = ageYears + ' ปี';
                if (ageMonths > 0) {
                    ageString += ' ' + ageMonths + ' เดือน';
                }

                return ageString;
            }
        }
        ]
    });
    });
</script>
<?= $this->endSection() ?>
