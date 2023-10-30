<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        
        return view('login');
    }


    public function auth()
{
    // Instantiate the User model
    $model = new UserModel();

    // Define validation rules
    $rules = [
        'username' => 'required|min_length[4]|max_length[18]',
        'password' => 'required|min_length[4]|max_length[18]|validateUser[username,password]',
    ];

    // Define custom error messages
    $errors = [
        'username' => [
            'required' => 'กรุณากรอก Username',
            'min_length' => 'usernameจะต้องมีอย่างน้อย 4 ตัวอักษร',
        ],
        'password' => [
            'required' => 'กรุณากรอก รหัสผ่าน',
            'min_length' => 'รหัสผ่านจะต้องมีอย่างน้อย 8 ตัวอักษร',
            'validateUser' => 'ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง'
        ]
    ];

    
    if (!$this->validate($rules, $errors)) {
        $data['validation'] = $this->validator;
    } else {

        //instant valiable to use main Model.
        $model = new UserModel();

        $user = $model->where('username', $this->request->getPost('username'))->first();

        $this->setUserSession($user);
        return redirect()->to('home');
    }
    return view('login', $data);
}

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'fullname' => $user['full_name'],
            'nickname' => $user['nickname'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => TRUE
        ];

        session()->set($data);
        return TRUE;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgot_password()
    {
        if ($this->request->getMethod() == 'post') {


            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email|check_email[email]',
            ];

            $errors = [
                'email' => [
                    'required' => 'กรุณากรอก อีเมล์',
                    'min_length' => 'อีเมล์จะต้องมีอย่างน้อย 6 ตัวอักษร',
                    'valid_email' => 'อีเมล์ ไม่ถูกต้อง',
                    'check_email' => 'ไม่มีอีเมล์นี้ลงทะเบียนในระบบ'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {

                $user_email = $this->request->getVar('email');

                $db = db_connect();
                $common_model = new CommonModel($db);

                $row = $common_model->get_data('users', $user_email, 'email');
                $user_id = $row->id;
                $token = $row->uniid;


                //Update time on updated_at
                $common_model->update_data('users', $user_id, ['updated_at' => date("Y-m-d H:i:s")]);

                $email = \Config\Services::email();

                $email->setFrom('admin@accountpost.space', 'Admin web accountpost.space');
                $email->setTo($user_email);
                // $email->setCC('another@another-example.com');
                // $email->setBCC('them@their-example.com');

                $email->setSubject('Reset Password Link');

                $message = 'สวัสดีค่ะ นี่คือข้อความอัตโนมัติจากระบบ <br><br>'
                    . '<p>คำขอสำหรับ Reset password ของคุณได้รับแล้ว. กรุณาคลิกที่ลิงค์ ด้านล่างนี้เพื่อ ทำการ reset password และตั้ง password ใหม่<p>'
                    . '<a href="' . base_url() . '/login/reset_password/' . $token . '">Click here to reset your password.</a>';

                $email->setMessage($message);
                if ($email->send()) {
                    session()->setFlashdata('success_msg', 'ระบบได้ส่งลิงค์เพื่อ Reset password ไปตามที่อยู่อีเมล์ที่ลงทะเบียนในระบบแล้ว กรุณาเช็คอีเมล์และดำเนินการ ภายใน 15 นาที
                    .<p class="text-danger">!! หากไม่พบอีเมล์ใน Inbox กรุณาเช็คอีเมล์ที่ Junk mail.</p>');
                    return redirect()->to('page/success/login');
                } else {
                    $data = $email->printDebugger(['headers']);

                    session()->setFlashdata('error_msg', $data);
                    return redirect()->to('page/error/login');
                }
            }
        }
        // Set date for page title, consist of icon(awsomefont 5: <i class="fas fa-user"></i>), Page title, Page subtitle, Action button (ex. Add button or etc.).
        $data['pageTitle'] = '<img src="/assets/images/icon/forgot-password.png" width="50px" height="50px"> ลืมรหัสผ่าน';
        $data['pageSubtitle'] = '';
        $data['actionButton'] = '';

        return view('pages/forget_password', $data);
    }

    public function reset_password($token = null)
    {
        if ($this->request->getMethod() != 'post') {
            $data = [];
            if (!empty($token)) {
                //Do something
                $db = db_connect();
                $common_model = new CommonModel($db);

                $row = $common_model->get_data('users', $token, 'uniid');
                if (!empty($row)) {
                    if ($this->checkExpiryDate($row->updated_at)) {
                        //

                        // Set date for page title, consist of icon(awsomefont 5: <i class="fas fa-user"></i>), Page title, Page subtitle, Action button (ex. Add button or etc.).
                        $data['pageTitle'] = '<img src="/assets/images/icon/forgot-password.png" width="50px" height="50px"> ตั้ง Password ใหม่';
                        $data['pageSubtitle'] = '';
                        $data['actionButton'] = '';
                        return view('pages/reset_password', $data);
                    } else {
                        //error Link expiced 
                        session()->setFlashdata('error_msg', 'Link นี้หมดอายุแล้ว');
                        return redirect()->to('page/error/login');
                    }
                } else {
                    //error in case randam uniid
                    session()->setFlashdata('error_msg', 'ไม่พบ User นี้ในระบบ!');
                    return redirect()->to('page/error/login');
                }
            } else {
                //error in case Token is NULL
                session()->setFlashdata('error_msg', 'ไม่มี Token ยืนยัน!');
                return redirect()->to('page/error/login');
            }
        } else {

            $db = db_connect();
            $common_model = new CommonModel($db);

            $row = $common_model->get_data('users', $token, 'uniid');
            $user_id = $row->id;

            $rules = [
                'password' => 'required|min_length[8]|max_length[16]',
            ];

            $errors = [

                'password' => [
                    'required' => 'กรุณากรอก รหัสผ่าน',
                    'min_length' => 'รหัสผ่านจะต้องมีอย่างน้อย 8 ตัวอักษร',
                    'max_length' => 'รหัสผ่านจะต้องมีไม่มากกว่า 16 ตัวอักษร'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {

                $model = new UserModel();
                $data = array(
                    'password' => $this->request->getVar('password'),
                    'updated_at' => date('Y-m-d h:i:s')
                );
                $model->update($user_id, $data);

                $session = session();
                $session->setFlashdata('success_msg', 'เปลี่ยน Passwordใหม่ สำเร้จ เรียบร้อย');
                return redirect()->to('page/success/login');
            }

            // Set date for page title, consist of icon(awsomefont 5: <i class="fas fa-user"></i>), Page title, Page subtitle, Action button (ex. Add button or etc.).
            $data['pageTitle'] = '<img src="/assets/images/icon/forgot-password.png" width="50px" height="50px"> ตั้ง Password ใหม่';
            $data['pageSubtitle'] = '';
            $data['actionButton'] = '';

            return view('pages/reset_password', $data);
        }
    }
    public function checkExpiryDate($time)
    {
        $update_time = strtotime($time);
        $current_time = time();
        $timeDiff = $current_time - $update_time;
        if ($timeDiff < 900) {
            return true;
        } else {
            return false;
        }
    }
    public function update_uniid()
    {
        $db = db_connect();
        $common_model = new CommonModel($db);

        $result = $common_model->get_data_arr('users');
        $rs = $result['rows'];

        foreach ($rs as $item) {
            //Update md5 to uniid 
            $common_model->update_data('users', $item->id, ['uniid' => md5($item->id)]);
            echo 'done<br>';
        }
    }
}
