<?php

namespace App\Http\Controllers;

use App\Services\MahasiswaServices;
use App\Services\ProdiServices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class Mahasiswa extends Controller
{
    protected $mahasiswa;
    protected $prodi;

    public function __construct(MahasiswaServices $mahasiswa, ProdiServices $prodi)
    {
        $this->mahasiswa = $mahasiswa;
        $this->prodi = $prodi;
    }

    public function index()
    {
        $data = $this->mahasiswa->getAll();
        return view('mahasiswa.index', compact('data'));
    }

    public function create() {
        $prodi = $this->prodi->getAll();
        return view('mahasiswa.create', compact('prodi'));
    }

    public function store(Request $request) {
        if ($this->mahasiswa->store($request)) {
            return redirect('/mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan.');
        }
        return redirect('/mahasiswa')->with('error', 'Gagal menambahkan mahasiswa.');
    }

    public function edit($npm) {
        $data1 = $this->mahasiswa->find($npm);
        $data2 = $this->prodi->getAll();
        return view('mahasiswa.edit', compact('data1', 'data2'));
    }

    public function update(Request $request, $npm) {
        if ($this->mahasiswa->update($request, $npm)) {
        return redirect('/mahasiswa')->with('success', 'Mahasiswa berhasil diperbarui.');
        }
        return redirect('/mahasiswa')->with('error', 'Gagal memperbarui mahasiswa.');
    }
    
    public function destroy($npm) {
        if ($this->mahasiswa->destroy($npm)) {
        return redirect('/mahasiswa')->with('success', 'Mahasiswa berhasil dihapus.');
        }
        return redirect('/mahasiswa')->with('error', 'Gagal menghapus mahasiswa.');
    }

    public function export() {
        $data = $this->mahasiswa->getAll();
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('data'));
        return $pdf->download('data-mahasiswa.pdf');
    }
}