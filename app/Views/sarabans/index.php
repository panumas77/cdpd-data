<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5"><i class="fa-regular fa-file-lines"></i> สารบรรญเอกสาร <small><a href="/saraban/add" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> เพิ่มเอกสาร</a></small></h1>
<hr>
<?php if (session()->getFlashdata('success')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="border-round-bg">
<div class="table-responsive">
    <table id="sarabansTable" class="table table-striped">
        <thead>
            <tr>
                <th>เลขเอกสาร</th>
                <th class="d-none d-lg-table-cell">ลงวันที่</th>
                <th class="d-none d-lg-table-cell">จาก-ถึง</th>
                <th>เอกสาร</th>
                <th class="d-none d-lg-table-cell">เรื่อง</th>
                <th>คำสั่ง</th>
                <!-- Add other columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sarabans as $saraban) : ?>
                <tr>
                    <td><?= $saraban['doc_id'] ?></td>
                    <td class="d-none d-lg-table-cell"><?= date('d-m-Y', strtotime($saraban['date_add'])) ?></td>
                    <td class="d-none d-lg-table-cell"><?= $saraban['doc_from'].'<br>'.$saraban['doc_to'] ?></td>
                    <td><?= $saraban['doc_cat'] ?></td>
                    <td class="d-none d-lg-table-cell"><?= $saraban['doc_object'] ?></td>
                    <td>
                        <!-- Action buttons -->
                        <a href="<?= $saraban['doc_link'] ?>" target="_blank" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ดาว์นโหลดเอกสาร."><i class="fa-solid fa-file-arrow-down"></i></a>
                        <a href="/sarabans/edit/<?= $saraban['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-sarabanid="<?= $saraban['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ลบข้อมูล."><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

<!-- Modal to display saraban info -->
<div class="modal fade" id="sarabanInfoModal" tabindex="-1" aria-labelledby="sarabanInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="sarabanInfoModalLabel">ข้อมูลเอกสาร</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="sarabanInfoModalBody">
                <!-- saraban info will be loaded dynamically here -->
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
                <!-- saraban info will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle click event on info button
        $(document).on('click', '.btn-view', function() {
            var sarabanId = $(this).data('sarabanid');

            // Make an AJAX request to fetch the saraban info
            $.ajax({
                url: '/sarabans/info/' + sarabanId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched saraban info HTML
                    $('#sarabanInfoModalBody').html(response);

                    // Show the modal
                    $('#sarabanInfoModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch saraban info.');
                }
            });
    });

        // Handle click event on Profile Picture
        $(document).on('click', '.btn-picture', function() {
            var sarabanId = $(this).data('sarabanid');

            // Make an AJAX request to fetch the saraban info
            $.ajax({
                url: '/sarabans/profilePicture/' + sarabanId,
                type: 'GET',
                success: function(response) {
                    // Update the modal body with the fetched saraban info HTML
                    $('#pictureModalBody').html(response);

                    // Show the modal
                    $('#pictureModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch saraban info.');
                }
            });
        });

        // Handle click event on delete button
        $(document).on('click', '.btn-delete', function() {
            var sarabanId = $(this).data('sarabanid');

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
                        url: '/sarabans/delete/' + sarabanId,
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
        $('#sarabansTable').DataTable({
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
    });

    // Auto-hide success alert after 3 seconds
    setTimeout(function() {
        $("#success-alert").alert('close');
    }, 3000);
</script>
<?= $this->endSection() ?>