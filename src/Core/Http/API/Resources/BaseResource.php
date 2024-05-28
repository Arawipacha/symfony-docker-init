<?php
declare(strict_types=1);

namespace App\Core\Http\API\Resources;

interface  BaseResource{
    public function toArray():array;    
}