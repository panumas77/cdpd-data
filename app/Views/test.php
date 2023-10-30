<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $disabilityTypes = [
        ['type1', 'disability_type_1'],
        ['type2', 'disability_type_2'],
        ['type3', 'disability_type_3'],
        ['type4', 'disability_type_4'],
        ['type5', 'disability_type_5'],
        ['type6', 'disability_type_6'],
        ['type7', 'disability_type_7'],
        // Add more disability types here
    ];

    $multi_dis_count = 0;
    $dis_count = 0;
    $dis_count_sum = 0;
    foreach ($patients as $patient) {
        $type = 0;
        foreach ($disabilityTypes as $disabilityType) {
            if ($patient[$disabilityType[1]] == 1) {
                echo $disabilityType[1] . '<br>';
                $dis_count++;
                $type++;
            }

            
        }
        
        if ($type > 1) {
            $dis_count = 0;
            $multi_dis_count = $multi_dis_count + 1;
        }
        $dis_count_sum = $dis_count_sum + $dis_count;
        
    }
    echo '<p>Dis Count : '. $dis_count_sum . '</p>';

    echo '<p>Multi Dis Count : '. $multi_dis_count . '</p>';


    ?>

<!-- echo '<pre>';
        print_r($patient);
        echo '</pre>'; -->
</body>

</html>