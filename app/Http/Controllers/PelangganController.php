<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pelanggan::orderBy('nama', 'asc')->get();
        return \view('pelanggan', [
            'data' => $data,
        ]);
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
        $request->validate([
            'nama' => 'required|max:25',
            'email' => 'required|email|max:255',
            'hp' => 'required|min:10|max:13',
        ]);
        Pelanggan::create($request->only(
            'nama',
            'email',
            'hp',
        ));
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Pelanggan::findOrFail($id);
        return \view('pelanggan', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|max:25',
            'email' => 'required|email|max:255',
            'hp' => 'required|min:10|max:13',
        ]);
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->only(
            'nama',
            'email',
            'hp',
        ));
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil dihapus.');
    }
}
