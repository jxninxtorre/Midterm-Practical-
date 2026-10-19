<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

class Products extends BaseController
{
    private array $rules = [
        'name'           => 'required|max_length[100]',
        'price'          => 'required|numeric|greater_than_equal_to[0]|less_than[100000000]',
        'stock_quantity' => 'required|is_natural',
        'image'          => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
    ];

    private function dir(): string
    {
        return WRITEPATH . 'uploads/products/';
    }

    private function saveImage($file): string
    {
        if (! is_dir($this->dir())) {
            mkdir($this->dir(), 0775, true);
        }

        $name = $file->getRandomName();
        $file->move($this->dir(), $name);

        // display-ready: crop/resize to 400x400
        \Config\Services::image()
            ->withFile($this->dir() . $name)
            ->fit(400, 400, 'center')
            ->save($this->dir() . $name, 90);

        return $name;
    }

    private function deleteImage(?string $name): void
    {
        if ($name) {
            $path = $this->dir() . basename($name);
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    public function index()
    {
        $products = (new ProductModel())->orderBy('id', 'DESC')->findAll();

        return view('products/index', [
            'title'    => 'Products',
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('products/form', ['title' => 'Add Product', 'product' => null]);
    }

    public function store()
    {
        if (! $this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'           => trim($this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $data['image'] = $this->saveImage($file);
        }

        (new ProductModel())->insert($data);

        return redirect()->to('/products')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = (new ProductModel())->find($id);
        if (! $product) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('products/form', ['title' => 'Edit Product', 'product' => $product]);
    }

    public function update($id)
    {
        $model   = new ProductModel();
        $product = $model->find($id);
        if (! $product) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! $this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'           => trim($this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $this->deleteImage($product['image']);
            $data['image'] = $this->saveImage($file);
        }

        $model->update($id, $data);

        return redirect()->to('/products')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $model   = new ProductModel();
        $product = $model->find($id);
        if (! $product) {
            throw PageNotFoundException::forPageNotFound();
        }

        $hasSales = \Config\Database::connect()
            ->table('sales')
            ->where('product_id', $id)
            ->countAllResults() > 0;

        if ($hasSales) {
            return redirect()->to('/products')
                ->with('error', 'Cannot delete "' . $product['name'] . '" because it already has sales records.');
        }

        $this->deleteImage($product['image']);
        $model->delete($id);

        return redirect()->to('/products')->with('success', 'Product deleted.');
    }

    // Serves the stored product image (kept in writable/, not public)
    public function image($filename)
    {
        $path = $this->dir() . basename($filename);
        if (! is_file($path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', (new File($path))->getMimeType())
            ->setHeader('Cache-Control', 'private, max-age=86400')
            ->setBody(file_get_contents($path));
    }
}