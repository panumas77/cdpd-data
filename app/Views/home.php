<?= $this->extend('layout/main.php') ?>

<?= $this->section('content') ?>

<h1 class="display-5">สรุปข้อมูล <small> - สวัสดี, <?= session('nickname') .' ('.session('role') . ')' ?></small></h1>
<hr>
<div class="border-round-bg">
<div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th scope="col">ความพิการ</th>
                <th scope="col" colspan="2">0.มีแนวโน้ม</th>
                <th scope="col" colspan="2">1.การมอง</th>
                <th scope="col" colspan="2">2.ได้ยิน</th>
                <th scope="col" colspan="2">3.เคลื่อนไหว</th>
                <th scope="col" colspan="2">4.จิตใจ</th>
                <th scope="col" colspan="2">5.สติปัญญา</th>
                <th scope="col" colspan="2">6.เรียนรู้</th>
                <th scope="col" colspan="2">7.ออทิสติก</th>
                <th scope="col" colspan="2">8.ซ้ำซ้อน</th>
                <th scope="col" colspan="3">รวม</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ช่วงอายุ</td>
                <?php foreach ($disabilityTypes as $disabilityType) : ?>
                    <td>ช</td>
                    <td>ญ</td>
                <?php endforeach; ?>
                <td>ช</td>
                <td>ญ</td>
                <td>ช</td>
                <td>ญ</td>
                <td>ชญ</td>
            </tr>
            <?php foreach ($ageRanges as $ageRange) : ?>
                <tr>
                    <td><?= $ageRange[0] ?></td>

                    <?php foreach ($disabilityTypes as $disabilityType) : ?>
                        <?php $countMale = $data[$disabilityType[0]]['ชาย'][$ageRange[0]]['count']; ?>
                        <?php $countFemale = $data[$disabilityType[0]]['หญิง'][$ageRange[0]]['count']; ?>
                        <td><?= $countMale ?></td>
                        <td><?= $countFemale ?></td>
                    <?php endforeach; ?>

                    <?php // Calculate and display the count of people with multiple disability types ?>
                    <?php $countMaleMulti = $multiDisabilityData[$ageRange[0]]['ชาย']['count_multi']; ?>
                    <?php $countFemaleMulti = $multiDisabilityData[$ageRange[0]]['หญิง']['count_multi']; ?>
                    <td><?= $countMaleMulti ?></td>
                    <td><?= $countFemaleMulti ?></td>

                    <?php // Calculate and display the sum of people in the "รวม" column ?>
                    <?php $sumMale = 0; ?>
                    <?php $sumFemale = 0; ?>
                    <?php foreach ($disabilityTypes as $disabilityType) : ?>
                        <?php $sumMale += $data[$disabilityType[0]]['ชาย'][$ageRange[0]]['count']; ?>
                        <?php $sumFemale += $data[$disabilityType[0]]['หญิง'][$ageRange[0]]['count']; ?>
                    <?php endforeach; ?>
                    <?php $sumMaleMulti = $multiDisabilityData[$ageRange[0]]['ชาย']['count_multi']; ?>
                    <?php $sumFemaleMulti = $multiDisabilityData[$ageRange[0]]['หญิง']['count_multi']; ?>
                    <?php $sumTotal = $sumMale + $sumFemale + $sumMaleMulti + $sumFemaleMulti; ?>
                    <td><?= $sumMaleMulti + $sumMale ?></td>
                    <td><?= $sumFemaleMulti + $sumFemale ?></td>
                    <td><?= $sumTotal ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
    <td></td>
    <td colspan="<?= (2 * count($disabilityTypes)) + 2 ?>">รวม</td>
    <?php // Calculate and display the sum of people in the "รวม" column ?>
    <?php $sumMaleTotal = 0; ?>
    <?php $sumFemaleTotal = 0; ?>
    <?php $sumMaleMultiTotal = 0; ?>
    <?php $sumFemaleMultiTotal = 0; ?>
    <?php foreach ($ageRanges as $ageRange) : ?>
        <?php $sumMale = 0; ?>
        <?php $sumFemale = 0; ?>
        <?php foreach ($disabilityTypes as $disabilityType) : ?>
            <?php $sumMale += $data[$disabilityType[0]]['ชาย'][$ageRange[0]]['count']; ?>
            <?php $sumFemale += $data[$disabilityType[0]]['หญิง'][$ageRange[0]]['count']; ?>
        <?php endforeach; ?>
        <?php $sumMaleMulti = $multiDisabilityData[$ageRange[0]]['ชาย']['count_multi']; ?>
        <?php $sumFemaleMulti = $multiDisabilityData[$ageRange[0]]['หญิง']['count_multi']; ?>
        <?php $sumMaleTotal += $sumMale + $sumMaleMulti; ?>
        <?php $sumFemaleTotal += $sumFemale + $sumFemaleMulti; ?>
        <?php $sumMaleMultiTotal += $sumMaleMulti; ?>
        <?php $sumFemaleMultiTotal += $sumFemaleMulti; ?>
    <?php endforeach; ?>
    <td><?= $sumMaleTotal ?></td>
    <td><?= $sumFemaleTotal ?></td>
    <td><?= $sumMaleTotal + $sumFemaleTotal ?></td>
</tr>

        </tbody>
    </table>
</div>
</div>
<?= $this->endSection() ?>
