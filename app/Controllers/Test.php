<?php

namespace App\Controllers;

use App\Models\SummaryModel;
use App\Models\PatientModel;

class Test extends BaseController
{
    public function index()
    {




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

        $ageRangeStart = 5;
        // Calculate birthdate limits
        $currentYear = date('Y');
        $startYearCE = $currentYear - $ageRangeStart + 543; // Convert to BE
        $startDateCE = date('Y-m-d', strtotime("$startYearCE-01-01"));

        $model = new PatientModel();
        $patients = $model->findAll();

       
        return view('test',['patients' => $patients]);
    }
}
