<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthRoot implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //if user not logged in 
        if (session()->get('role') != 'Root' && !session()->get('logged_in')) {
            return redirect()->to('not_allowed');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //Do something
    }
}
