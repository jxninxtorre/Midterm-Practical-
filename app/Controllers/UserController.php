<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('users/index', $data);
    }

    public function new()
    {
        return view('users/create');
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|min_length[3]',
            'username'  => 'required|is_unique[users.username]',
            'password'  => 'required|min_length[6]',
            'avatar'    => 'uploaded[avatar]|is_image[avatar]|max_size[avatar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $avatarFile = $this->request->getFile('avatar');
        $avatarName = '';

        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $avatarName = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads', $avatarName);
        }

        $this->userModel->save([
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'avatar'    => $avatarName
        ]);

        return redirect()->to(site_url('users'))->with('success', 'Staff added successfully.');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        $rules = [
            'full_name' => 'required|min_length[3]',
            'username'  => "required|is_unique[users.username,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $avatarName = $user['avatar'];
        $avatarFile = $this->request->getFile('avatar');

        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $avatarName = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads', $avatarName);
            
            if (!empty($user['avatar']) && file_exists(FCPATH . 'uploads/' . $user['avatar'])) {
                unlink(FCPATH . 'uploads/' . $user['avatar']);
            }
        }

        $updateData = [
            'id'        => $id,
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'avatar'    => $avatarName
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = $password;
        }

        $this->userModel->save($updateData);

        return redirect()->to(site_url('users'))->with('success', 'Staff updated successfully.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            if (!empty($user['avatar']) && file_exists(FCPATH . 'uploads/' . $user['avatar'])) {
                unlink(FCPATH . 'uploads/' . $user['avatar']);
            }
            $this->userModel->delete($id);
        }
        return redirect()->to(site_url('users'))->with('success', 'Staff deleted successfully.');
    }
}