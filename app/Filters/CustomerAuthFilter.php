<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('/customer/login')->with('error', 'Please login to shop.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}