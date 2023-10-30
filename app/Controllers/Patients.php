<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\HistoryModel;

class Patients extends BaseController

{

    public function index()
    {
        $model = new PatientModel();
        $patients = $model->findAll();

        return view('patients/index', [
            'patients' => $patients
        ]);
    }

    public function add()
    {
        $model = new PatientModel();

        if ($this->request->getMethod() === 'post') {
            // Save the patient data without server-side validation

            $Data = [
                'full_name' => $this->request->getPost('full_name'),
                'gender' => $this->request->getPost('gender'),
                'birthdate' => $this->request->getPost('birthdate'),
                // 'date_of_birth' => date('Y-m-d', strtotime(str_replace('/', '-', $this->request->getVar('date_of_birth')))),
                'personal_id_number' => $this->request->getPost('personal_id_number'),
                'phone_number' => $this->request->getPost('phone_number'),
                'email' => $this->request->getPost('email'),
                'religion' => $this->request->getPost('religion'),
                'marriage_status' => $this->request->getPost('marriage_status'),
                'number_of_children' => $this->request->getPost('number_of_children'),
                'likely' => $this->request->getPost('likely_to_disability'),
                'disability_type_1' => $this->request->getPost('disability_type_1'),
                'disability_type_2' => $this->request->getPost('disability_type_2'),
                'disability_type_3' => $this->request->getPost('disability_type_3'),
                'disability_type_4' => $this->request->getPost('disability_type_4'),
                'disability_type_5' => $this->request->getPost('disability_type_5'),
                'disability_type_6' => $this->request->getPost('disability_type_6'),
                'disability_type_7' => $this->request->getPost('disability_type_7'),
                'address' => $this->request->getPost('address'),
                'district' => $this->request->getPost('district'),
                'amphoe' => $this->request->getPost('amphoe'),
                'province' => $this->request->getPost('province'),
                'zipcode' => $this->request->getPost('zipcode'),
                // Assign other form fields to respective columns
            ];


            // Upload lesson image
            $image = $this->request->getFile('profile_picture');
            if ($image->isValid() && !$image->hasMoved()) {
                // Check if the file size is within limits
                if ($image->getSize() <= 1024 * 1024) { // 1 MB in bytes
                    // Generate a new file name to avoid collisions
                    $newName = $image->getRandomName();
                    // Move the uploaded file to a writable directory
                    $image->move('./assets/uploads/patients', $newName);
                    // Save the image path to the lesson data
                    $Data['profile_picture'] = 'assets/uploads/patients/' . $newName;
                } else {
                    // File size exceeds the limit
                    session()->setFlashdata('error', 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 1 MB');
                    return redirect()->to('/patients/create');
                }
            }

            $model->save($Data);
            // Set a flash message to indicate success
            session()->setFlashData('success', 'เพิ่มข้อมูลผู้พิการ สำเร็จแล้ว.');

            // Redirect to the patient list page
            return redirect()->to('/patients');
        }

        // Display the add patient form
        return view('patients/add');
    }

    public function edit($patientId)
    {
        $patientModel = new PatientModel();

        $patient = $patientModel->find($patientId);

        if (!$patient) {
            return redirect()->to('/patients')->with('error', 'Patient not found.');
        }

        $data['patient'] = $patient;

        return view('patients/edit', $data);
    }

    public function update($patientId)
    {
        $patientModel = new PatientModel();

        $data = [
            'likely' => $this->request->getPost('likely_to_disability'),
            'full_name' => $this->request->getPost('full_name'),
            'gender' => $this->request->getPost('gender'),
            'birthdate' => $this->request->getVar('birthdate'),
            // 'date_of_birth' => $this->request->getPost('date_of_birth'),
            'religion' => $this->request->getPost('religion'),
            'personal_id_number' => $this->request->getPost('personal_id_number'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email' => $this->request->getPost('email'),
            'marriage_status' => $this->request->getPost('marriage_status'),
            'number_of_children' => $this->request->getPost('number_of_children'),
            'disability_type_1' => $this->request->getPost('disability_type_1'),
            'disability_type_2' => $this->request->getPost('disability_type_2'),
            'disability_type_3' => $this->request->getPost('disability_type_3'),
            'disability_type_4' => $this->request->getPost('disability_type_4'),
            'disability_type_5' => $this->request->getPost('disability_type_5'),
            'disability_type_6' => $this->request->getPost('disability_type_6'),
            'disability_type_7' => $this->request->getPost('disability_type_7'),
            'address' => $this->request->getPost('address'),
            'district' => $this->request->getPost('district'),
            'amphoe' => $this->request->getPost('amphoe'),
            'province' => $this->request->getPost('province'),
            'zipcode' => $this->request->getPost('zipcode')
        ];

        // Check if a profile picture was uploaded
        if ($image = $this->request->getFile('profile_picture')) {

            // Validate the uploaded file
            if ($image->isValid() && !$image->hasMoved() && in_array($image->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                // Check file size (1 MB maximum)
                if ($image->getSize() <= 1024 * 1024) {

                    // Get the patient's current profile picture path
                    $patient = $patientModel->find($patientId);
                    $currentPicturePath = $patient['profile_picture'];

                    // Delete the existing picture file
                    if ($currentPicturePath && file_exists($currentPicturePath)) {
                        unlink($currentPicturePath);
                    }

                    // Generate a new file name to avoid collisions
                    $newName = $image->getRandomName();
                    // Move the uploaded file to the desired directory
                    $image->move('./assets/uploads/patients', $newName);

                    // Update the patient data with the new profile picture path
                    $data['profile_picture'] = 'assets/uploads/patients/' . $newName;
                } else {
                    // File size exceeded, set an error message
                    session()->setFlashdata('error', 'The uploaded image file size exceeds the maximum allowed size of 1 MB.');
                    return redirect()->to("/patients/edit/{$patientId}");
                }
            }
        }


        $patientModel->update($patientId, $data);

        return redirect()->to('/patients')->with('success', 'แก้ไขข้อมูลผู้พิการ สำเร็จแล้ว');
    }


    public function info($PatientId)
    {
        $model = new PatientModel();

        // Fetch the user information from the model
        $patient = $model->find($PatientId);

        if ($patient) {
            // Calculate age based on date_of_birth
            $birthdate = new \DateTime($patient['birthdate']);
            $today = new \DateTime();
            $age = $today->diff($birthdate)->y;

            $age = 543 - $age;
            // Load the user information into a view and return it as HTML
            $html = '';

            if (!empty($patient['likely'])) {
                $html .= '<h5 class="text-danger">ผู้มีแนวโน้มจะพิการ </h5>';
            }
            $html .= '
    <p><strong>ชื่อ-สกุล: </strong>' . $patient['full_name'] . '</p>
    <p><strong>เพศ: </strong>' . $patient['gender'] . '</p>
    <p><strong>อายุ: </strong>' . $age . ' ปี</p>
    <p><strong>วัน/เดือน/ปีเกิด: </strong>' . date('d/m/Y', strtotime($patient['birthdate'])) . '</p>
    <p><strong>เลขประจำตัวประชาชน: </strong>' . $patient['personal_id_number'] . '</p>
    <p><strong>เบอร์โทรศัพท์: </strong>' . $patient['phone_number'] . '</p>
    <p><strong>อีเมล: </strong>' . $patient['email'] . '</p>
    <p><strong>ศาสนา: </strong>' . $patient['religion'] . '</p>
    <p><strong>สถานะสมรส: </strong>' . $patient['marriage_status'] . '</p>
    <p><strong>จำนวนบุตร: </strong>' . $patient['number_of_children'] . '</p>';

            if (!empty($patient['disability_type_1'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 1: </strong> ทางการมองเห็น</p>';
            }

            if (!empty($patient['disability_type_2'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 2: </strong> ทางการได้ยินหรือ สื่อความหมาย</p>';
            }

            if (!empty($patient['disability_type_3'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 3: </strong> ทางการเคลื่อนไหวหรือ ทางร่างกาย</p>';
            }

            if (!empty($patient['disability_type_4'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 4: </strong> ทางจิตใจหรือ พฤติกรรม</p>';
            }

            if (!empty($patient['disability_type_5'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 5: </strong> ทางสติปัญญา</p>';
            }

            if (!empty($patient['disability_type_6'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 6: </strong> ทางการเรียนรู้</p>';
            }

            if (!empty($patient['disability_type_7'])) {
                $html .= '<p><strong>ประเภทความพิการที่ 7: </strong> ออทิสติก</p>';
            }

            $html .= '<br><br>';


            return $html;
        } else {
            // Handle the case when the user is not found
            return 'Patient not found.';
        }
    }


    public function profilePicture($PatientId)
    {
        $model = new PatientModel();

        // Fetch the user information from the model
        $patient = $model->find($PatientId);

        if ($patient) {
            // Load the user information into a view and return it as HTML
            $html = '';

            if ($patient['profile_picture'] !== NULL) {
                $html .= '<img src="' . base_url($patient['profile_picture']) . '" width="100%">
            <br><br>';
            } else {
                $html .= '<img src="' . base_url() . 'assets/images/no-image.svg" width="100%">
                <br><br>';
            }

            return $html;
        } else {
            // Handle the case when the user is not found
            return 'User not found.';
        }
    }

    public function delete($PatientId)
    {
        $model = new PatientModel();

        // Fetch the user information from the model
        $patient = $model->find($PatientId);

        if ($patient) {
            // Delete the user from the database
            $model->delete($PatientId);

            // Set flash data to display a success message
            session()->setFlashData('success', 'ลบข้อมูลผู้พิการ สำเร็จแล้ว.');

            // Redirect back to the users list page
            return redirect()->to('/patients');
        } else {
            // Handle the case when the user is not found
            return 'Patient not found.';
        }
    }

    public function profile($patientId)
    {
        $patientModel = new PatientModel();
        $historyModel = new HistoryModel();

        $patient = $patientModel->find($patientId);

        // Calculate age based on date_of_birth
        $birthdate = new \DateTime($patient['birthdate']);
        $today = new \DateTime();
        $age = $today->diff($birthdate)->y;

        $age = 543 - $age;

        if (!$patient) {
            return redirect()->to('patients')->with('error', 'Patient not found.');
        }

        $histories = $historyModel->findAll();

        return view('patients/profile', [
            'patient' => $patient,
            'histories' => $histories,
            'age' => $age,
        ]);

    }
}
