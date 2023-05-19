<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->products = new Product();
        $this->categories = new Category();
        $this->db = db_connect();
    }

    public function index()
    {
        $products = $this->db->table('products as p')->select('*, p.id as product_id')->join('categories as c', 'p.category_id = c.id')->get()->getResultArray();
        $data = [
            'products' => $products
        ];
        return view('product/data', $data);
    }

    public function add()
    {
        return view("product/add");
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $nama = $this->request->getVar('nama');
            $stok = $this->request->getVar('stok');
            $category_id = $this->request->getVar('category_id');
            $hargabeli = str_replace(',', '', $this->request->getVar('harga_beli'));
            $hargajual = str_replace(',', '', $this->request->getVar('harga_jual'));

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'nama' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Tersedia',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'category_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib dipilih'
                    ]
                ],
                'harga_beli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong',
                    ]
                ],
                'harga_jual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong'
                    ]
                ],
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorNamaProduk' => $validation->getError('nama'),
                        'errorStok' => $validation->getError('stok'),
                        'errorCategory' => $validation->getError('category_id'),
                        'errorHargaBeli' => $validation->getError('harga_beli'),
                        'errorHargaJual' => $validation->getError('harga_jual'),
                    ]
                ];
            } else {
                $this->products->insert([
                    'nama' => $nama,
                    'category_id' => $category_id,
                    'stok' => $stok,
                    'harga_beli' => $hargabeli,
                    'harga_jual' => $hargajual,
                ]);

                $msg = [
                    'sukses' => 'Berhasil dieksekusi'
                ];
            }

            echo json_encode($msg);
        }
    }

    function edit($id)
    {
        $row = $this->products->find($id);


        if ($row) {
            $data = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'stok' => $row['stok'],
                'harga_jual' => $row['harga_jual'],
                'harga_beli' => $row['harga_beli'],
                'category_id' => $row['category_id'],
                'categories' => $this->categories->findAll()
            ];
            return view('product/edit', $data);
        }
    }

    function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $stok = $this->request->getVar('stok');
            $category_id = $this->request->getVar('category_id');
            $hargabeli = str_replace(',', '', $this->request->getVar('harga_beli'));
            $hargajual = str_replace(',', '', $this->request->getVar('harga_jual'));

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'nama' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Tersedia',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'category_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib dipilih'
                    ]
                ],
                'harga_beli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong',
                    ]
                ],
                'harga_jual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong'
                    ]
                ],
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorNamaProduk' => $validation->getError('nama'),
                        'errorStok' => $validation->getError('stok'),
                        'errorCategory' => $validation->getError('category_id'),
                        'errorHargaBeli' => $validation->getError('harga_beli'),
                        'errorHargaJual' => $validation->getError('harga_jual'),
                    ]
                ];
            } else {
                $this->products->update($id, [
                    'nama' => $nama,
                    'category_id' => $category_id,
                    'stok' => $stok,
                    'harga_beli' => $hargabeli,
                    'harga_jual' => $hargajual,
                ]);

                $msg = [
                    'sukses' => 'Berhasil dieksekusi'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function destroy()
    {
        // Bug di delete
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->products->delete($id);

            $msg = [
                'sukses' => 'Produk berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

    public function getCategory()
    {
        if ($this->request->isAJAX()) {
            $categories = $this->db->table('categories')->get();

            $values = "<option value='' selected>--Pilih Kategori--</option>";

            foreach ($categories->getResultArray() as $row) :
                $values .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            endforeach;

            $msg = [
                'data' => $values
            ];
            echo json_encode($msg);
        }
    }
}
