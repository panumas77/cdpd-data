<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class SummaryModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function countAndData($disabilityType, $gender, $ageRangeStart, $ageRangeEnd)
    {
        // Calculate birthdate limits
        $currentYear = date('Y');
        $startYearCE = $currentYear - $ageRangeStart + 543; // Convert to BE
        $endYearCE = $currentYear - $ageRangeEnd + 543; // Convert to BE
    
        // Convert to Thai date format 'd-m-Y' for comparison
        $startDateThai = date('d-m-Y', strtotime("$startYearCE-01-01"));
        $endDateThai = date('d-m-Y', strtotime("$endYearCE-12-31"));
    
        // Convert Thai date formats to 'Y-m-d' for MySQL
        $startDateCE = date('d-m-Y', strtotime("01-01-$startYearCE"));
        $endDateCE = date('d-m-Y', strtotime("31-12-$endYearCE"));
    
        // Count records
        $count = $this->db->table('patients')
            ->where($disabilityType, 1)
            ->where('gender', $gender)
            ->where('birthdate >=', $startDateCE)
            ->where('birthdate <=', $endDateCE)
            ->countAllResults();
    
        // Fetch data
        $data = $this->db->table('patients')
            ->select('*')
            ->where($disabilityType, 1)
            ->where('gender', $gender)
            ->where('birthdate >=', $startDateCE)
            ->where('birthdate <=', $endDateCE)
            ->get()
            ->getResultArray();
    
        return [
            'count' => $count,
            'data' => $data
        ];
    }
    


    public function countAndDataMultiDisability($disabilityTypes, $gender, $ageRangeStart, $ageRangeEnd)
    {
        $query = $this->db->table('patients');

        $query->where('gender', $gender)
            ->where('birthdate >=', date('Y-m-d', strtotime($ageRangeEnd . ' years ago')))
            ->where('birthdate <=', date('Y-m-d', strtotime($ageRangeStart . ' years ago')))
            ->groupStart();

        foreach ($disabilityTypes as $disabilityType) {
            $query->orWhere($disabilityType, 1);
        }

        $query->groupEnd();

        $count = $query->countAllResults();

        $dataQuery = $this->db->table('patients');

        $dataQuery->where('gender', $gender)
            ->where('birthdate >=', date('Y-m-d', strtotime($ageRangeEnd . ' years ago')))
            ->where('birthdate <=', date('Y-m-d', strtotime($ageRangeStart . ' years ago')))
            ->groupStart();

        foreach ($disabilityTypes as $disabilityType) {
            $dataQuery->orWhere($disabilityType, 1);
        }

        $dataQuery->groupEnd();

        $data = $dataQuery->get()->getResultArray();

        return [
            'count' => $count,
            'data' => $data
        ];
    }
    public function countPatientsWithMultipleDisability($disabilityTypes, $gender, $ageRangeStart, $ageRangeEnd)
    {
        $query = $this->db->table('patients');

        foreach ($disabilityTypes as $disabilityType) {
            $query->orWhere($disabilityType, 1);
        }

        $query->where('gender', $gender)
            ->where('birthdate >=', date('Y-m-d', strtotime($ageRangeEnd . ' years ago')))
            ->where('birthdate <=', date('Y-m-d', strtotime($ageRangeStart . ' years ago')))
            ->groupBy('id')
            ->having('COUNT(*) > 1');

        return $query->countAllResults();
    }

    public function getPatientsWithMultipleDisability($disabilityTypes, $gender, $ageRangeStart, $ageRangeEnd)
    {
        $query = $this->db->table('patients');

        $query->where('gender', $gender)
            ->where('birthdate >=', date('Y-m-d', strtotime($ageRangeEnd . ' years ago')))
            ->where('birthdate <=', date('Y-m-d', strtotime($ageRangeStart . ' years ago')));

        foreach ($disabilityTypes as $disabilityType) {
            $query->where($disabilityType, 1);
        }

        return $query->get()->getResult();
    }
}
