<?php

namespace App\Controllers;

class ProfileController extends BaseController
{
    public function index(): string
    {
        return $this->page('Profile/ProfilePage', [
            'pageTitle' => 'Profil Saya',
        ]);
    }
}
