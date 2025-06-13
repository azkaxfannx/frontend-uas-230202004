<?php

namespace App\Http\Controllers;

use App\Services\ProdiServices;
use Illuminate\Http\Request;

class Prodi extends Controller
{
    protected $prodi;

    public function __construct(ProdiServices $prodi)
    {
        $this->prodi = $prodi;
    }

    public function index()
    {
        $data = $this->prodi->getAll();
        return view('prodi.index', compact('data'));
    }

    public function create() {
        return view('prodi.create');
    }

    public function store(Request $request) {
        if ($this->prodi->store($request)) {
            return redirect('/prodi')->with('success', 'Prodi berhasil ditambahkan.');
        }
        return redirect('/prodi')->with('error', 'Gagal menambahkan prodi.');
    }

    public function edit($kode_prodi) {
        $prodi = $this->prodi->find($kode_prodi);
        return view('prodi.edit', compact('prodi'));
    }

    public function update(Request $request, $kode_prodi) {
        if ($this->prodi->update($request, $kode_prodi)) {
        return redirect('/prodi')->with('success', 'Prodi berhasil diperbarui.');
        }
        return redirect('/prodi')->with('error', 'Gagal memperbarui prodi.');
    }
    
    public function destroy($kode_prodi) {
        if ($this->prodi->destroy($kode_prodi)) {
        return redirect('/prodi')->with('success', 'Prodi berhasil dihapus.');
        }
        return redirect('/prodi')->with('error', 'Gagal menghapus prodi.');
    }
}