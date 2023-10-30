<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5"><i class="fa-solid fa-wheelchair"></i> ผู้พิการ <small><a href="/patients/add" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> เพิ่มผู้พิการ</a></small></h1>
<hr>
<?php if (session()->getFlashdata('success')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="border-round-bg">
    <div class="table-responsive">
        <table id="patientsTable" class="table table-striped">
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
                <?php foreach ($patients as $patient) : ?>
                    <tr>
                        <td class="d-none d-lg-table-cell"><?= $patient['personal_id_number'] ?></td>
                        <td>
                            <a href="#" class="btn-picture" data-patientid="<?= $patient['id'] ?>">
                                <?php
                                if (!empty($patient['profile_picture'])) {
                                    echo '<img src="' . base_url($patient['profile_picture']) . '" alt="' . $patient['full_name'] . '" class="patient-image img-thumbnail" width="30" height="30" >';
                                } else {
                                    echo '<img src="' . base_url('assets/images/no-image.svg') . '" alt="No Image" class="patient-image img-thumbnail" width="40px">';
                                }
                                ?></a> <a href="<?= base_url('patients/profile/'.$patient['id']) ?>"><?= $patient['full_name'] ?></a>

                        </td>
                        <td class="d-none d-lg-table-cell"><?= $patient['gender'] ?></td>
                        <td class="d-none d-lg-table-cell"><?= date('d-m-Y', strtotime($patient['birthdate'])) ?></td>
                        <td class="d-none d-lg-table-cell"></td>
                        <td>
                            <!-- Action buttons -->
                            <button class="btn btn-info btn-sm btn-view" data-patientid="<?= $patient['id'] ?>"><i class="fa-solid fa-info"></i></button>
                            <a href="/patients/edit/<?= $patient['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-patientid="<?= $patient['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ลบข้อมูล."><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal to display patient info -->
<div class="modal fade" id="patientInfoModal" tabindex="-1" aria-labelledby="patientInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="patientInfoModalLabel">ข้อมูลผู้พิการ</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="patientInfoModalBody">
                <!-- Patient info will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>

<!-- Modal to display picture -->
<div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="pictureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pictureModalBody">
                <!-- Patient info will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle click event on info button
        $(document).on('click', '.btn-view', function() {
            var patientId = $(this).data('patientid');

            // Make an AJAX request to fetch the patient info
            $.ajax({
                url: '/patients/info/' + patientId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched patient info HTML
                    $('#patientInfoModalBody').html(response);

                    // Show the modal
                    $('#patientInfoModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch patient info.');
                }
            });
        });

        // Handle click event on Profile Picture
        $(document).on('click', '.btn-picture', function() {
            var patientId = $(this).data('patientid');

            // Make an AJAX request to fetch the patient info
            $.ajax({
                url: '/patients/profilePicture/' + patientId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched patient info HTML
                    $('#pictureModalBody').html(response);

                    // Show the modal
                    $('#pictureModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch patient info.');
                }
            });
        });

        // Handle click event on delete button
        $(document).on('click', '.btn-delete', function() {
            var patientId = $(this).data('patientid');

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
                        url: '/patients/delete/' + patientId,
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
        $('#patientsTable').DataTable({
            "dom": 'Pfrtp',
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "ไม่พบข้อมูล",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "ค้นหา:",
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "paginate": {
                    "first": "แรก",
                    "last": "สุดท้าย",
                    "next": "ต่อไป",
                    "previous": "ก่อนหน้า"
                },
            },
            "columnDefs": [{
                "targets": [4], // Index of the calculated column (starting from 0)
                "render": function(data, type, row, meta) {
                    // Calculate the age based on the date_of_birth
                    var dateOfBirth = moment(row[3], 'DD-MM-YYYY'); // Assuming the date_of_birth is in the fourth column
                    var today = moment();
                    var ageYears = today.diff(dateOfBirth, 'years') + 543;
                    var ageMonths = today.diff(dateOfBirth, 'months') % 12;

                    // Construct the age string
                    var ageString = ageYears + ' ปี';
                    if (ageMonths > 0) {
                        ageString += ' ' + ageMonths + ' เดือน';
                    }

                    return ageString;
                }
            }]
        });
    });

    // Auto-hide success alert after 3 seconds
    setTimeout(function() {
        $("#success-alert").alert('close');
    }, 3000);
</script>
<?= $this->endSection() ?>