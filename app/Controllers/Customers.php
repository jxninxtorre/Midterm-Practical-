<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    private array $rules = [
        'full_name' => 'required|max_length[100]',
        'email'     => 'required|valid_email|max_length[100]',
        'phone'     => 'permit_empty|max_length[20]|regex_match[/^[0-9+\-\s()]+$/]',
    ];

    private array $messages = [
        'phone' => [
            'regex_match' => 'Phone may only contain numbers, spaces, +, -, and parentheses.',
        ],
    ];

    private function formData(): array
    {
        $phone = trim((string) $this->request->getPost('phone'));

        return [
            'full_name' => trim($this->request->getPost('full_name')),
            'email'     => trim($this->request->getPost('email')),
            'phone'     => $phone === '' ? null : $phone,
        ];
    }

    public function index()
    {
        $customers = (new CustomerModel())->orderBy('id', 'DESC')->findAll();

        return view('customers/index', [
            'title'     => 'Customers',
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return view('customers/form', ['title' => 'Add Customer', 'customer' => null]);
    }

    public function store()
    {
        if (! $this->validate($this->rules, $this->messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert($this->formData());

        return redirect()->to('/customers')->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customer = (new CustomerModel())->find($id);
        if (! $customer) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('customers/form', ['title' => 'Edit Customer', 'customer' => $customer]);
    }

    public function update($id)
    {
        $model    = new CustomerModel();
        $customer = $model->find($id);
        if (! $customer) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! $this->validate($this->rules, $this->messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->formData());

        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $model    = new CustomerModel();
        $customer = $model->find($id);
        if (! $customer) {
            throw PageNotFoundException::forPageNotFound();
        }

        $hasSales = \Config\Database::connect()
            ->table('sales')
            ->where('customer_id', $id)
            ->countAllResults() > 0;

        if ($hasSales) {
            return redirect()->to('/customers')
                ->with('error', 'Cannot delete "' . $customer['full_name'] . '" because this customer already has sales records.');
        }

        $model->delete($id);

        return redirect()->to('/customers')->with('success', 'Customer deleted.');
    }
}