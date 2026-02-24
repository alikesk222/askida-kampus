<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Models\UserModel;

class RegisterController
{
    public function form(): void
    {
        if (Auth::check()) {
            redirect('/bagis');
        }
        $errors    = flash('errors') ?? [];
        $old       = flash('old') ?? [];
        $pageTitle = 'Bağışçı Hesabı Oluştur';
        view('auth/register', compact('pageTitle', 'errors', 'old'));
    }

    public function store(): void
    {
        CSRF::verify();

        if (Auth::check()) {
            redirect('/bagis');
        }

        $v = new Validator($_POST);
        $v->required('name', 'Ad Soyad')
          ->required('email', 'E-posta')
          ->email('email', 'E-posta')
          ->required('password', 'Şifre')
          ->min('password', 'Şifre', 8);

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '']);
            redirect('/kayit');
        }

        $userModel = new UserModel();

        if ($userModel->findByEmail(trim($_POST['email']))) {
            flash('errors', ['email' => ['Bu e-posta adresi zaten kayıtlı.']]);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '']);
            redirect('/kayit');
        }

        $userId = $userModel->create([
            'name'     => trim($_POST['name']),
            'email'    => trim($_POST['email']),
            'password' => $_POST['password'],
            'role'     => 'donor',
        ]);

        $user = $userModel->findById($userId);
        Auth::login($user);

        flash('success', 'Hesabınız oluşturuldu! Bağış yapmaya başlayabilirsiniz.');
        redirect('/bagis');
    }
}
