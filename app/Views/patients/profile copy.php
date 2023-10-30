<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="display-5"><i class="fa-solid fa-wheelchair"></i> ข้อมูลผู้พิการ <small> <a href="<?= previous_url() ?>" class="btn btn-light"><i class="fa-solid fa-arrow-left-long fa-2xl"></i></a></small></h1>
<hr>
<div class="border-round-bg">
    <div class="row mb-3">
        <div class="col-lg-9">

            <?php if (!empty($patient['likely'])) : ?>
                <h5 class="text-danger">ผู้มีแนวโน้มจะพิการ </h5>';
            <?php endif ?>
            <p class="fs-4"><strong>เลขประจำตัวประชาชน: </strong><?= $patient['personal_id_number'] ?> | <strong>ศาสนา: </strong><?= $patient['religion'] ?></p>
            <p class="fs-4"><strong>ชื่อ-สกุล: </strong> <?= $patient['full_name'] ?> | <strong>เพศ: </strong> <?= $patient['gender'] ?></p>
            <p class="fs-4"><strong>วัน/เดือน/ปีเกิด: </strong><?= date('d/m/Y', strtotime($patient['birthdate'])) ?> | <strong>อายุ: </strong><?= $age ?> ปี</p>
            <p class="fs-4"><strong>เบอร์โทรศัพท์: </strong><?= $patient['phone_number'] ?></p>
            <p class="fs-4"><strong>อีเมล: </strong><?= $patient['email'] ?></p>
            <p class="fs-4"><strong>สถานะสมรส: </strong><?= $patient['marriage_status'] ?> | <strong>จำนวนบุตร: </strong><?= $patient['number_of_children'] ?></p>
            <ul>
            <?php
            if (!empty($patient['disability_type_1'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 1: </strong> ทางการมองเห็น</li>';
            }

            if (!empty($patient['disability_type_2'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 2: </strong> ทางการได้ยินหรือ สื่อความหมาย</li>';
            }

            if (!empty($patient['disability_type_3'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 3: </strong> ทางการเคลื่อนไหวหรือ ทางร่างกาย</li>';
            }

            if (!empty($patient['disability_type_4'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 4: </strong> ทางจิตใจหรือ พฤติกรรม</li>';
            }

            if (!empty($patient['disability_type_5'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 5: </strong> ทางสติปัญญา</li>';
            }

            if (!empty($patient['disability_type_6'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 6: </strong> ทางการเรียนรู้</li>';
            }

            if (!empty($patient['disability_type_7'])) {
                echo '<li class="fs-5"><strong>ประเภทความพิการที่ 7: </strong> ออทิสติก</li>';
            }
            ?>
            </ul>
        </div>

        <div class="col-lg-3 text-center">
            <img class="rounded" src="<?= base_url($patient['profile_picture']) ?>" width="300px">
        </div>
    </div>



    <h4 class="display-6"> ประวัติการเข้ารับบริการ </h4>
    <hr>

    <div class="table-responsive">
        <table id="historysTable" class="table table-striped">
            <thead>
                <tr>
                    <th class="d-none d-lg-table-cell">วันที่รับบริการ</th>
                    <th>บริการที่รับ</th>
                    <th class="d-none d-lg-table-cell">ผู้ให้บริการ</th>
                    <th>คำสั่ง</th>
                    <!-- Add other columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($histories as $history) : ?>
                    <tr>
                        <td class="d-none d-lg-table-cell"><?= $history['personal_id_number'] ?></td>
                        <td>
                            <a href="#" class="btn-picture" data-historyid="<?= $history['id'] ?>">
                                <?php
                                if (!empty($history['profile_picture'])) {
                                    echo '<img src="' . base_url($history['profile_picture']) . '" alt="' . $history['full_name'] . '" class="history-image img-thumbnail" width="30" height="30" >';
                                } else {
                                    echo '<img src="' . base_url('assets/images/no-image.svg') . '" alt="No Image" class="history-image img-thumbnail" width="40px">';
                                }
                                ?></a> <a href="<?= base_url("history/profile/{$history['id']}") ?>"><?= $history['full_name'] ?></a>

                        </td>
                        <td class="d-none d-lg-table-cell"><?= $history['gender'] ?></td>
                        <td class="d-none d-lg-table-cell"><?= date('d-m-Y', strtotime($history['birthdate'])) ?></td>
                        <td class="d-none d-lg-table-cell"></td>
                        <td>
                            <!-- Action buttons -->
                            <button class="btn btn-info btn-sm btn-view" data-historyid="<?= $history['id'] ?>"><i class="fa-solid fa-info"></i></button>
                            <a href="/historys/edit/<?= $history['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-historyid="<?= $history['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ลบข้อมูล."><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#historysTable').DataTable({
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
</script>
<?= $this->endSection() ?>