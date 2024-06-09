<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

//data Mapper
class PaginatedResponse{
    private function __construct(
        private readonly array $items,
        private readonly array $meta
    ) { 
        
    }



    public static function create(array $items, int $total, int $page, int $limit){
        if($limit ===0){
            $lastPage = 0;
        }else{
            $lastPage = (int) \ceil($total/$limit);
        }
        //este meta es para usralo en un scroll infinito
        $meta = [
            'total'=> $total,
            'page' => $page,
            'limit' =>$limit,
            'hasNext'=> $page < $lastPage
        ];

        return new PaginatedResponse($items, $meta);
    }

    public function getItems():array{
        return $this->items;
    }


    public function getMeta():array{
        return $this->meta;
    }
}