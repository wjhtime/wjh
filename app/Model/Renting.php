<?php
namespace App\Model;


use App\Lib\IoC;
use Psr\Container\ContainerInterface;

class Renting extends IoC
{

    const TABLE = 'renting';

    const PAGE_SIZE = 20;

    protected $ci;

    public function getList($where)
    {
        $query = $this->db->table(self::TABLE);

        if (!empty($where['keyword'])) {
            $query->where('title', 'like', "%{$where['keyword']}%");
        }

        if (!empty($where['start_time'])) {
            $query->whereDate('created_at', '>=', $where['start_time']);
        }

        if (!empty($where['end_time'])) {
            $query->whereDate('created_at', '<=', $where['end_time']);
        }
        $total = $query->count();

        if ($where['page']) {
            $query->offset($where['page']);
        }
        $result = $query->limit(self::PAGE_SIZE)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return [
            'houses' => $result,
            'total' => $total
        ];
    }


    
}