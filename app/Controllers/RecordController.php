<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class RecordController extends BaseController
{
    protected $productModel;
    protected $customerModel;
    protected $saleModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->saleModel     = new SaleModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $data['products']  = $this->productModel->findAll();
        $data['customers'] = $this->customerModel->findAll();

        return view('sales/records', $data);
    }

    public function store()
    {
        $productId  = $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity   = (int) $this->request->getPost('quantity');

        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->back()->withInput()->with('error', 'Selected product not found.');
        }

        if ($quantity > $product['stock_quantity']) {
            return redirect()->back()->withInput()->with('error', 'Sale rejected: Requested quantity exceeds available stock (' . $product['stock_quantity'] . ' left).');
        }

        $totalPrice = $product['price'] * $quantity;
        $newStock = $product['stock_quantity'] - $quantity;
        $this->productModel->update($productId, ['stock_quantity' => $newStock]);

        $firstUser = $this->userModel->first();
        $userId = $firstUser ? $firstUser['id'] : 1;

        try {
            $this->saleModel->save([
                'product_id'  => $productId,
                'customer_id' => !empty($customerId) ? $customerId : null,
                'sold_by'     => $userId,
                'quantity'    => $quantity,
                'total_price' => $totalPrice,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Sale could not be saved. Database Error: ' . $e->getMessage());
        }

        return redirect()->to(site_url('sales/history'))->with('success', 'Sale recorded successfully!');
    }

    public function history()
    {
        $data['sales'] =$this->saleModel->select('sales.*, products.name as product_name, customers.full_name as customer_name, COALESCE(users.username, "hellokitty") as staff_name')
            ->join('products', 'products.id = sales.product_id', 'left')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by', 'left')
            ->orderBy('sales.created_at', 'DESC')
            ->findAll();

        return view('sales/history', $data);
    }
}