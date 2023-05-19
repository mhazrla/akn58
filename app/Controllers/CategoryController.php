<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{

    public function __construct()
    {
        $this->categories = new Category();
    }

    public function index()
    {
        $data = [
            'categories' => $this->categories->findAll(),
        ];
        return view("category/data", $data);
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $act = $this->request->getPost('act');
            $msg = [
                'data' => view('category/modaladdCategory', ['act' => $act])
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $name = $this->request->getVar("name");

            $this->categories->insert([
                'name' => $name
            ]);

            $msg = [
                'sukses' => 'Kategori berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }

    function edit($id)
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');

            $categories = $this->categories->find($id);
            $data = [
                'id' => $id,
                'name' => $categories['name']
            ];

            $msg = [
                'data' => view('category/modalEditCategory', $data)
            ];
            echo json_encode($msg);
        }
    }

    function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $name = $this->request->getVar('name');
            $this->categories->update($id, [
                'name' => $name,
            ]);
            $msg = [
                'sukses' => 'Berhasil diperbarui'
            ];
        }
        echo json_encode($msg);
    }

    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->categories->delete($id);

            $msg = [
                'sukses' => 'Kategori berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }
}
