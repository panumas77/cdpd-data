<?php

namespace App\Controllers;

use App\Models\CaregiverModel;

class Caregivers extends BaseController
{
    public function index()
    {
        $model = new CaregiverModel();
        $caregivers = $model->findAll();

        return view('caregivers/index', [
            'caregivers' => $caregivers
        ]);
    }

    public function add()
    {
        $model = new CaregiverModel();

        if ($this->request->getMethod() === 'post') {

            $Data = [
                'full_name' => $this->request->getPost('full_name'),
                'gender' => $this->request->getPost('gender'),
                'birthdate' => $this->request->getPost('birthdate'),
                'personal_id_number' => $this->request->getPost('personal_id_number'),
                'phone_number' => $this->request->getPost('phone_number'),
                'email' => $this->request->getPost('email'),
                'religion' => $this->request->getPost('religion'),
                'relationship' => $this->request->getPost('relationship'),
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
                    $image->move('./assets/uploads/caregivers', $newName);
                    // Save the image path to the lesson data
                    $Data['profile_picture'] = 'assets/uploads/caregivers/' . $newName;
                } else {
                    // File size exceeds the limit
                    session()->setFlashdata('error', 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 1 MB');
                    return redirect()->to('/caregivers/add');
                }
            }

            $model->save($Data);
            // Set a flash message to indicate success
            session()->setFlashData('success', 'เพิ่มข้อมูลผู้ดูแล สำเร็จแล้ว.');

            // Redirect to the caregiver list page
            return redirect()->to('/caregivers');
        }

        // Display the add caregiver form
        return view('caregivers/add');
    }

    public function info($CaregiverId)
    {
        $model = new CaregiverModel();

        // Fetch the user information from the model
        $caregiver = $model->find($CaregiverId);

        if ($caregiver) {
            // Calculate age based on date_of_birth
            $birthdate = new \DateTime($caregiver['date_of_birth']);
            $today = new \DateTime();
            $age = $today->diff($birthdate)->y;
            // Load the user information into a view and return it as HTML
            $html = '';

            $html .= '
    <p><strong>ชื่อ-สกุล: </strong>' . $caregiver['full_name'] . '</p>
    <p><strong>เพศ: </strong>' . $caregiver['gender'] . '</p>
    <p><strong>อายุ: </strong>' . $age . ' ปี</p>
    <p><strong>วัน/เดือน/ปีเกิด: </strong>' . date('d/m/Y', strtotime($caregiver['date_of_birth'])) . '</p>
    <p><strong>เลขประจำตัวประชาชน: </strong>' . $caregiver['personal_id_number'] . '</p>
    <p><strong>เบอร์โทรศัพท์: </strong>' . $caregiver['phone_number'] . '</p>
    <p><strong>อีเมล: </strong>' . $caregiver['email'] . '</p>
    <p><strong>ศาสนา: </strong>' . $caregiver['religion'] . '</p>
    <p><strong>ความสัมพันธ์: </strong>' . $caregiver['relationship'] . '</p>';

            $html .= '<br><br>';


            return $html;
        } else {
            // Handle the case when the user is not found
            return 'Caregiver not found.';
        }
    }

    public function delete($CaregiverId)
    {
        $model = new CaregiverModel();

        // Fetch the user information from the model
        $caregiver = $model->find($CaregiverId);

        if ($caregiver) {
            // Delete the user from the database
            $model->delete($CaregiverId);

            // Set flash data to display a success message
            session()->setFlashData('success', 'Caregiver deleted successfully.');

            // Redirect back to the users list page
            return redirect()->to('/caregivers');
        } else {
            // Handle the case when the user is not found
            return 'Caregiver not found.';
        }
    }

    public function search_caregivers()
    {
        // Get the search term from the AJAX request
        $search = $this->request->getPost('search');

        $caregiverModel = new CaregiverModel;

        // Perform a database query to search for caregivers based on the search term
        $caregivers = $caregiverModel->searchCaregivers($search); // Adjust to your model and method

        // Load a view to display the search results
        $viewData = ['caregivers' => $caregivers];
        $html = view('caregivers/search_results', $viewData);

        echo $html;
    }
}
