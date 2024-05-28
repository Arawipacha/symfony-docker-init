<?php
declare(strict_types=1);

namespace App\Core\Http\API\Filter;

final class QueryFilter extends BaseFilter implements FilterInterface{
    private const DEFAULT_SORT = 'id';
    private const DEFAULT_ORDER = 'asc';
    
    public readonly string $sort;
    public readonly string $order;


    public function __construct(
        int $page,
        int $limit,
        string $sort,
        string $order,
        public readonly ?string $name=null,
        //public readonly ?string $token,
        /* public readonly ?string $from,
        public readonly ?string $to, */
    ) {
        $this->validateSort($sort);
        $this->validateOrder($order);
        
        /* $this->checkValidDate($from);
        $this->checkValidDate($to); */

        $this->sort=$sort;
        $this->order=$order;
        parent::__construct($page, $limit);
    }


    public static function create(int $page, int $limit, ?string $sort, ?string $order, ?string $name=null ) : QueryFilter {
        if(null ===$sort){
            $sort == self::DEFAULT_SORT;
        }

        if(null ===$order){
            $order == self::DEFAULT_ORDER;
        }

        return new QueryFilter($page, $limit, $sort, $order,$name);
    }
}