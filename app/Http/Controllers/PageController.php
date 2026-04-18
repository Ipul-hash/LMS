<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    #===========
    # Ini buat route page Admin
    #===========
    public function dashboard()
    {return view('admin.dashboard');}
    public function dataMatkul()
    {return view('admin.datamatkul');}
    public function dataKelas()
    {return view('admin.manajemenkelas');}
    public function manajemenSidebar()
    {return view('admin.manajemensidebar');}
    public function manajemenRuangan()
    {return view('admin.manajemenruangan');}

    #===========
    # Ini buat route page Mahasiswa
    #===========
    public function krsMahasiswa()
    {return view('mahasiswa.krsmahasiswa');}
    public function kelasSaya()
    {return view('mahasiswa.kelassaya');}

    #===========
    # Ini buat route page Dosen
    #===========
    public function krsApprove()
    {return view('dosen.approvekrs');}
    public function kelasDosen()
    {return view('dosen.kelasdosen');}

    public function login()
    {
        return view('auth.index');
    }
}