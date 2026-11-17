<?php

namespace App\Http\Controllers\Admin;

class KmsSederhanaController extends KmsDokumenListController
{
    public function index()
    {
        $v = parent::index();
        return view('admin.kms-pedoman.sederhana', $v->getData());
    }
}