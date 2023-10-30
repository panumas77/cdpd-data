<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SarabanModel;

class Saraban extends BaseController

{

    public function index()
    {
        $model = new SarabanModel();
        $sarabans = $model->orderBy('id', 'asc')->findAll();

        return view('sarabans/index', [
            'sarabans' => $sarabans
        ]);
    }

    public function add()
    {
        $model = new SarabanModel();

        if ($this->request->getMethod() === 'post') {
            // Save the patient data without server-side validation

            $Data = [
                'doc_id' => $this->request->getPost('doc_id'),
                'doc_cat' => $this->request->getPost('doc_cat'),
                'date_add' => $this->request->getVar('date_add'),
                'doc_from' => $this->request->getPost('doc_from'),
                'doc_to' => $this->request->getPost('doc_to'),
                'doc_object' => $this->request->getPost('doc_object'),
            ];


            // Upload PDF document
            $pdfFile = $this->request->getFile('doc_pdf');

            if ($pdfFile->isValid() && !$pdfFile->hasMoved()) {
                // Check if the file is a PDF (you can add more allowed extensions)
                $allowedExtensions = ['pdf'];
                if (in_array($pdfFile->getExtension(), $allowedExtensions)) {
                    // Check if the file size is within limits (10MB in bytes)
                    if ($pdfFile->getSize() <= 10 * 1024 * 1024) {
                        // Generate a new file name to avoid collisions
                        $newName = $pdfFile->getRandomName();
                        // Move the uploaded file to a writable directory
                        $pdfFile->move('./assets/uploads/sarabans', $newName);
                        // Save the PDF file path to the data
                        $Data['doc_link'] = 'assets/uploads/sarabans/' . $newName;
                    } else {
                        // File size exceeds the limit
                        session()->setFlashdata('error', 'ไฟล์ PDF ต้องมีขนาดไม่เกิน 10 MB');
                        return redirect()->to('/sarabans/create');
                    }
                } else {
                    // Invalid file type
                    session()->setFlashdata('error', 'ไฟล์ไม่ใช่ PDF');
                    return redirect()->to('/sarabans/create');
                }
            } else {
                // Invalid file or other upload error
                session()->setFlashdata('error', 'ไม่สามารถอัปโหลดไฟล์ได้');
                return redirect()->to('/sarabans/create');
            }


            $model->save($Data);
            // Set a flash message to indicate success
            session()->setFlashData('success', 'เพิ่มข้อมูลเอกสาร สำเร็จแล้ว.');

            // Redirect to the patient list page
            return redirect()->to('/saraban');
        }

        // Display the add patient form
        return view('sarabans/add');
    }

    public function edit($sarabanId)
    {
        $SarabanModel = new SarabanModel();

        $patient = $SarabanModel->find($sarabanId);

        if (!$patient) {
            return redirect()->to('/sarabans')->with('error', 'Patient not found.');
        }

        $data['patient'] = $patient;

        return view('sarabans/edit', $data);
    }

    public function update($sarabanId)
    {
        $SarabanModel = new SarabanModel();

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
                    $patient = $SarabanModel->find($sarabanId);
                    $currentPicturePath = $patient['profile_picture'];

                    // Delete the existing picture file
                    if ($currentPicturePath && file_exists($currentPicturePath)) {
                        unlink($currentPicturePath);
                    }

                    // Generate a new file name to avoid collisions
                    $newName = $image->getRandomName();
                    // Move the uploaded file to the desired directory
                    $image->move('./assets/uploads/sarabans', $newName);

                    // Update the patient data with the new profile picture path
                    $data['profile_picture'] = 'assets/uploads/sarabans/' . $newName;
                } else {
                    // File size exceeded, set an error message
                    session()->setFlashdata('error', 'The uploaded image file size exceeds the maximum allowed size of 1 MB.');
                    return redirect()->to("/sarabans/edit/{$sarabanId}");
                }
            }
        }


        $SarabanModel->update($sarabanId, $data);

        return redirect()->to('/sarabans')->with('success', 'แก้ไขข้อมูลผู้พิการ สำเร็จแล้ว');
    }


    public function info($sarabanId)
    {
        $model = new SarabanModel();

        // Fetch the user information from the model
        $patient = $model->find($sarabanId);

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


    public function profilePicture($sarabanId)
    {
        $model = new SarabanModel();

        // Fetch the user information from the model
        $patient = $model->find($sarabanId);

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

    public function delete($sarabanId)
    {
        $model = new SarabanModel();

        // Fetch the user information from the model
        $patient = $model->find($sarabanId);

        if ($patient) {
            // Delete the user from the database
            $model->delete($sarabanId);

            // Set flash data to display a success message
            session()->setFlashData('success', 'ลบข้อมูลผู้พิการ สำเร็จแล้ว.');

            // Redirect back to the users list page
            return redirect()->to('/sarabans');
        } else {
            // Handle the case when the user is not found
            return 'Patient not found.';
        }
    }
}
