<?php

namespace App\Validation;

use App\Models\UserModel;
use App\Models\CommonModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('username', $data['username'])->first();

        if (!$user) {
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }

    public function check_email(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $email = $model->where('email', $data['email'])->first();

        if (!$email) {
            return false;
        }
        return true;
    }
    public function check_order_id(string $str, string $fields, array $data)
    {
        $db = db_connect();
        $model = new CommonModel($db);
        $order = $model->get_data('posts_order', $data['order_id'], 'order_id'); //get_data($table, $id, $id_field = 'id') where('order_id', $data['order_id'])->first();

        if (!$order) {
            return false;
        }
        return true;
    }
}
