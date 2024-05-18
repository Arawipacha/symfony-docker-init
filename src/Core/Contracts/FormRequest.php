<?php
namespace App\Core\Contracts;

use Symfony\Component\HttpFoundation\Request;

interface FormRequest{
    public function  __construct(Request $request);
}
