<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class DataProduct extends Model
{
    protected $table            = 'products';
    protected $column_order       = array(null, 'nama', 'harga_jual');
    protected $column_search       = array('nama');
    protected $order       = array('nama' => 'desc');

    protected $request;
    protected $db;
    protected $dt;


    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    private function _get_datatables_query()
    {
        $this->dt = $this->db->table($this->table)->join('categories', 'category_id=categories.id');
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost("search")['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost("search")["value"]);
                } else {
                    $this->dt->orLike($item, $this->request->getPost("search")["value"]);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost("order")) {
            $this->dt->orderBy($this->column_order[$this->request->getPost("order")['0']['column']]);
            $this->request->getPost("order"['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost("length") != -1) {
            $this->dt->limit($this->request->getPost("length"), $this->request->getPost("start"));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table)->join('categories', 'category_id=categories.id')->get();
        return $tbl_storage->countAllResults();
    }
}
