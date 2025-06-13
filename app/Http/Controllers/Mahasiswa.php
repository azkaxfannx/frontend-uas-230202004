<?php

namespace App\Http\Controllers;

use App\Services\MahasiswaServices;
use App\Services\ProdiServices;
use Illuminate\Http\Request;

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
        $this->mahasiswa->store($request);
        return redirect('/mahasiswa');
    }

    public function edit($npm) {
        $data1 = $this->mahasiswa->find($npm);
        $data2 = $this->prodi->getAll();
        return view('mahasiswa.edit', compact('data1', 'data2'));
    }

    public function update(Request $request, $npm) {
        $this->mahasiswa->update($request, $npm);
        return redirect('/mahasiswa');
    }
    
    public function destroy($npm) {
        $this->mahasiswa->destroy($npm);
        return redirect('/mahasiswa');
    }
}