<?php

namespace App\Http\Controllers\APi\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function listDosen()
    {
        $dosen = User::role('dosen')->select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dosen berhasil dimuat',
            'data' => $dosen
        ], 200);
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
