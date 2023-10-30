<?php

namespace App\Controllers;

use App\Models\SummaryModel;

class Home extends BaseController
{
    public function index()
{
    $session = session();
    $db = db_connect();
    $summaryModel = new SummaryModel($db);

    // Age Ranges
    $ageRanges = [
        ['0-5y', 0, 5],
        ['6-15y', 6, 15],
        ['16-25y', 16, 25],
        ['26-59y', 26, 59],
        ['more than 60y', 60, 999]
    ];

    // Disability Types
    $disabilityTypes = [
        ['type0', 'likely'],
        ['type1', 'disability_type_1'],
        ['type2', 'disability_type_2'],
        ['type3', 'disability_type_3'],
        ['type4', 'disability_type_4'],
        ['type5', 'disability_type_5'],
        ['type6', 'disability_type_6'],
        ['type7', 'disability_type_7'],
        // Add more disability types here
    ];

    // Multi Disability Types
    $disabilityMultiTypes = ['disability_type_1', 'disability_type_2', 'disability_type_3', 'disability_type_4', 'disability_type_5', 'disability_type_6', 'disability_type_7'];

    // Gender
    $genders = ['ชาย', 'หญิง'];

    // Query and retrieve data
    $data = [];

    foreach ($disabilityTypes as $disabilityType) {
        $typeData = [];

        foreach ($genders as $gender) {
            $genderData = [];

            foreach ($ageRanges as $ageRange) {
                [$rangeName, $rangeStart, $rangeEnd] = $ageRange;

                $result = $summaryModel->countAndData($disabilityType[1], $gender, $rangeStart, $rangeEnd);
                $genderData[$rangeName] = [
                    'count' => $result['count'],
                    'data' => $result['data'],
                ];
            }

            $typeData[$gender] = $genderData;
        }

        $data[$disabilityType[0]] = $typeData;
    }

    // Count patients with multiple disability types
    $multiDisabilityData = [];

    foreach ($ageRanges as $ageRange) {
        [$rangeName, $rangeStart, $rangeEnd] = $ageRange;

        $multiDisabilityData[$rangeName] = [];

        foreach ($genders as $gender) {
            $countMulti = $summaryModel->countPatientsWithMultipleDisability($disabilityMultiTypes, $gender, $rangeStart, $rangeEnd);
            $multiDisabilityData[$rangeName][$gender] = [
                'count_multi' => $countMulti,
            ];
        }
    }

    return view('home', [
        'data' => $data,
        'ageRanges' => $ageRanges,
        'disabilityTypes' => $disabilityTypes,
        'multiDisabilityData' => $multiDisabilityData,
    ]);
}


public function notAllowed(){
    
    return view('not_allowed');
}

public function test(){
    
    return view('test');
}
}

