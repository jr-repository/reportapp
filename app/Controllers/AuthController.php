<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function loginPage(): string
    {
        $this->response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('Expires', '0');

        return $this->page('Auth/LoginPage', [
            'pageTitle' => 'Login',
            'pageClass' => 'AuthPage',
        ]);
    }

    public function login()
    {
        $payload = $this->request->getPost(['login', 'password']);
        $rules   = config(\Config\Validation::class)->authLogin;

        if (! service('validation')->setRules($rules)->run($payload)) {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }

        if (! $this->authService->attempt((string) $payload['login'], (string) $payload['password'], $this->request)) {
            return redirect()->back()->withInput()->with('error', 'Email/username atau password tidak valid.');
        }

        return redirect()->to(base_url('/'))->with('success', 'Login berhasil.');
    }

    public function registerPage(): string
    {
        $this->response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('Expires', '0');

        return $this->page('Auth/RegisterPage', [
            'pageTitle' => 'Register',
            'pageClass' => 'AuthPage',
        ]);
    }

    public function register()
    {
        $result = $this->authService->register($this->request->getPost([
            'fullName',
            'email',
            'username',
            'phone',
            'password',
        ]));

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('errors', $result['errors']);
        }

        return redirect()->to(base_url('login'))->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->to(base_url('login'));
    }
}
