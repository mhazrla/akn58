<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sales;

class LayoutController extends BaseController
{
    public function __construct()
    {
        $this->products = new Product();
        $this->categories = new Category();
        $this->sales = new Sales();
        $this->db = db_connect();
    }

    public function index()
    {
        $products = $this->products->countAllResults();
        $categories = $this->categories->countAllResults();
        $sales = $this->sales->countAllResults();
        $data = [
            'products' => $products,
            'categories' => $categories,
            'sales' => $sales,
        ];
        return view("layout/home", $data);
    }
}
