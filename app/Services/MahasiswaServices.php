<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MahasiswaServices
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.base_url');
    }

    public function getAll()
    {
        $response = Http::get("{$this->baseUrl}/mahasiswa");
        return $response->successful() ? $response->json() : [];
    }

    public function find($id)
    {
        $response = Http::get("{$this->baseUrl}/mahasiswa/{$id}");
        return $response->successful() ? $response->json() : null;
    }

    public function store($data) {
        $response = Http::post("{$this->baseUrl}/mahasiswa", $data->all());
        return $response->successful() ? $response->json() : null;
    }

    // public function edit($id) {
    //     $response = Http::get("{$this->baseUrl}/mahasiswa/{$id}");
    //     return $response->successful() ? $response->json() : null;
    // }

    public function update($data, $id) {
        $response = Http::put("{$this->baseUrl}/mahasiswa/$id", $data->all());
        return $response->successful() ? $response->json() : null;
    }

    public function destroy($id) {
        $response = Http::delete("{$this->baseUrl}/mahasiswa/$id");
        return $response->successful() ? $response->json() : null;
    }
}