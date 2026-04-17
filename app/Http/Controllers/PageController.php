<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function dataMatkul()
    {
        return view('admin.datamatkul');
    }

    public function dataKelas()
    {
        return view('admin.manajemenkelas');
    }

    public function manajemenSidebar()
    {
        return view('admin.manajemensidebar');
    }

    public function login()
    {
        return view('auth.index');
    }
}