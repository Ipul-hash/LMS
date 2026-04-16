<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    public function dataPengguna()
    {
        return view('admin.datapengguna');
    }

    public function manajemenRole()
    {
        return view('admin.manajemenrole');
    }

    public function manajemenSidebar()
    {
        return view('admin.manajemensidebar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
