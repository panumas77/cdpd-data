<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Your index view content here -->
<h1 class="display-5"><i class="fa-solid fa-circle-user"></i> ผู้ใช้ <small><a href="/users/create" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> เพิ่มผู้ใช้</a></small></h1>
<hr>
<?php if (session()->getFlashData('success')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
        }, 3000);
    </script>
<?php endif; ?>

<div class="border-round-bg">
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ชื่อ-สกุล</th>
                    <th class="d-none d-lg-table-cell">ตำแหน่ง</th>
                    <th class="d-none d-lg-table-cell">สิทธิ</th>
                    <th>คำสั่ง</th>
                    <!-- Add other columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['full_name'] . ' (' . $user['nickname'] . ')' ?> </td>
                        <td class="d-none d-lg-table-cell"><?= $user['position'] ?></td>
                        <td class="d-none d-lg-table-cell"><?= $user['role'] ?></td>
                        <!-- Display other user data as needed -->
                        <!-- Action buttons -->
                        <td>
                            <!-- Add info, edit, and delete buttons -->
                            <button class="btn btn-info btn-sm btn-view" data-userid="<?= $user['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="รายละเอียด."><i class="fa-solid fa-info"></i></button>
                            <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แก้ไข."><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-userid="<?= $user['id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ลบข้อมูล."><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal to display user info -->
<div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="userInfoModalLabel">ข้อมูลผู้ใช้</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userInfoModalBody">
                <!-- User info will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>
</div>

<script>
    //------------Initialize Tooltip ----------------------------------
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    //------------ Initialize the Datatable----------------------------------
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
        });

        // Handle click event on info button
        $(document).on('click', '.btn-view', function() {
            var userId = $(this).data('userid');

            // Make an AJAX request to fetch the user info
            $.ajax({
                url: '/users/info/' + userId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched user info HTML
                    $('#userInfoModalBody').html(response);

                    // Show the modal
                    $('#userInfoModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch user info.');
                }
            });
        });
    });

    //------------Javascript Ajax Delete -----------------------------
    // Handle click event on delete button
    $(document).on('click', '.btn-delete', function() {
        var userId = $(this).data('userid');

        Swal.fire({
                title: "คุณแน่ใจที่จะลบใช่หรือไม่?",
                text: "หากต้องการรายการนี้จะถูกลบถาวรไปจากฐานข้อมูล",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบ!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/users/delete/' + userId,
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
</script>

<?= $this->endSection() ?>