<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('full_name','asc')->findAll();

        // Check if a success message is set in the session
        $success = session('success');

        return view('users/index', ['users' => $data['users'], 'success' => $success]);
    }

    // Add other methods for managing users (e.g., create, edit, delete)

    public function create()
    {
        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            $Data = [
                'full_name' => $this->request->getPost('full_name'),
                'nickname' => $this->request->getPost('nickname'),
                'position' => $this->request->getPost('position'),
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
                'active' => $this->request->getPost('active'),

            ];

            $model->save($Data);

            session()->setFlashdata('success', 'ผู้ใช้ใหม่ถูกเพิ่มเรียบร้อยแล้ว');
            // Redirect to the lessons index page or show a success message
            return redirect()->to('/users');
        }

        return view('users/create');
    }
    
    

public function info($userId)
{
    $model = new UserModel();

    // Fetch the user information from the model
    $user = $model->find($userId);

    if ($user) {
        // Load the user information into a view and return it as HTML
        $html = '';

        $html .= '
            <p> <strong>ชื่อ-สกุล : </strong>' . $user['full_name'] . '</p>
            <p> <strong>ชื่อเล่น : </strong>' . $user['nickname'] . '</p>
            <p> <strong>ตำแหน่ง : </strong>' . $user['position'] . '</p>
            <p> <strong>Email : </strong>' . $user['email'] . '</p>
            <p> <strong>Username : </strong>' . $user['username'] . '</p>
            <p> <strong>สิทธิในระบบ : </strong>' . $user['role'] . '</p>
            <br><br>
            ';

        return $html;
    } else {
        // Handle the case when the user is not found
        return 'User not found.';
    }
}

public function delete($userId)
{
    $model = new UserModel();

    // Fetch the user information from the model
    $user = $model->find($userId);

    if ($user) {
        // Delete the user from the database
        $model->delete($userId);

        // Set flash data to display a success message
        session()->setFlashData('success', 'ข้อมูลผู้ใช้ถูกลบเรียบร้อยแล้ว.');

        // Redirect back to the users list page
        return redirect()->to('/users');
    } else {
        // Handle the case when the user is not found
        return 'User not found.';
    }
}

public function edit($userId)
{
    $model = new UserModel();

    // Fetch the user information from the model
    $user = $model->find($userId);

    if ($user) {
        // Pass the user data to the view
        $data['user'] = $user;

        // Load the edit view with the user data
        return view('users/edit', $data);
    } else {
        // Handle the case when the user is not found
        return 'User not found.';
    }
}

public function update($userId)
{

        $model = new UserModel();

        $userData = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'nickname' => $this->request->getPost('nickname'),
            'position' => $this->request->getPost('position'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'active' => $this->request->getPost('active')
        ];

        $model->update($userId, $userData);

        // Redirect to the users index page with success message
        return redirect()->to('/users')->with('success', 'ข้อมูลผู้ใช้อัพเดทเรียบร้อยแล้ว.');

}

}
