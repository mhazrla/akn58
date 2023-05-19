<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataProduct;
use App\Models\ModelDataProduct;
use App\Models\Product;
use App\Models\Sales;
use Config\Services;

class SalesController extends BaseController
{
    public function __construct()
    {
        $this->products = new Product();
        $this->sales = new Sales();
    }

    public function index()
    {
        $show_data = $this->db->table("sales as s")->select('*, s.id as sales_id')->join('products as p', 's.product_id = p.id')->get()->getResultArray();
        $data = [
            'no_faktur' => $this->createFaktur(),
            'sales' => $show_data
        ];
        return view("sales/index", $data);
    }

    public function add()
    {
        $data = [
            'no_faktur' => $this->createFaktur()
        ];
        return view("sales/add", $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {

            $faktur_sale = $this->request->getVar('no_faktur');
            $date = $this->request->getVar('date');
            $product_id = $this->request->getVar('product_id');
            $qty = $this->request->getVar('qty');

            $data_product = $this->products->where('id = ', $product_id)->get()->getResultArray();
            $total_price = $data_product[0]['harga_jual'] * $qty;
            $total_price = number_format($total_price, 2, '.', '');

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'product_id' => [
                    'label' => 'Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'qty' => [
                    'label' => 'Jumlah Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorNamaProduk' => $validation->getError('product_id'),
                        'errorStok' => $validation->getError('qty'),
                    ]
                ];
            } else {
                $this->sales->insert([
                    'product_id' => $product_id,
                    'qty' => $qty,
                    'faktur_sale' => $faktur_sale,
                    'total_price' => $total_price,
                    'sales_date' => $date,
                ]);

                $msg = [
                    'sukses' => 'Berhasil dieksekusi'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function createFaktur()
    {
        $date = $this->request->getPost('date');
        $query = $this->db->query("SELECT MAX(faktur_sale) AS no_faktur FROM sales");
        $result = $query->getRowArray();
        $data = $result['no_faktur'];

        $last_num = substr($data, -4);

        $next_num = intval($last_num) + 1;

        $faktur_sales = 'A' . date("dmy", strtotime($date)) . sprintf("%04s", $next_num);
        return $faktur_sales;
    }

    public function data()
    {
        $faktur_sales = $this->request->getPost('no_faktur');

        $show_data = $this->db->table("sales as s")->select('*, p.id as sales_id')->join('products as p', 's.product_id = p.id')->get()->getResultArray();

        $data = [
            'sales' => $show_data
        ];

        $msg = [
            'sales' => view('sales/data', $data)
        ];

        echo json_encode($msg);
    }

    public function viewDataProduct()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'viewmodal' => view("sales/viewModalSearchProduct")
            ];
            echo json_encode($msg);
        }
    }

    public function getProduct()
    {
        if ($this->request->isAJAX()) {
            $products = $this->db->table('products')->get();

            $values = "<option value='' selected>--Pilih Produk--</option>";

            foreach ($products->getResultArray() as $row) :
                $values .= '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $values
            ];

            echo json_encode($msg);
        }
    }

    public function getListProduct()
    {
        if ($this->request->isAJAX()) {

            $request = Services::request();
            $modelProduct = new DataProduct($request);
            if ($request->getMethod(true) == "POST") {
                $lists = $modelProduct->get_datatables();
                $data = [];
                $no = $request->getPost("start");

                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row = $no;
                    $row = $list->nama;
                    $row = number_format($list->harga_jual, 0, ",", ".");
                }
                $output = [
                    "draw" => $request->getPost("draw"),
                    "recordsTotal" => $modelProduct->count_all(),
                    "recordsFiltered" => $modelProduct->count_filtered(),
                    "draw" => $data,
                ];
                echo json_encode($output);
            }
        }
    }

    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->sales->delete($id);

            $msg = [
                'sukses' => 'Item berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }
}
