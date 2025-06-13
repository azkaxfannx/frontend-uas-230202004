<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProdiServices
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.backend.base_url');
    }

    public function getAll()
    {
        $response = Http::get("{$this->baseUrl}/prodi");
        return $response->successful() ? $response->json() : [];
    }

    public function find($id)
    {
        $response = Http::get("{$this->baseUrl}/prodi/{$id}");
        return $response->successful() ? $response->json() : null;
    }

    public function store($data) {
        $response = Http::post("{$this->baseUrl}/prodi", $data->all());
        return $response->successful() ? $response->json() : null;
    }

    // public function edit($id) {
    //     $response = Http::get("{$this->baseUrl}/prodi/{$id}");
    //     return $response->successful() ? $response->json() : null;
    // }

    public function update($data, $id) {
        $response = Http::put("{$this->baseUrl}/prodi/$id", $data->all());
        return $response->successful() ? $response->json() : null;
    }

    public function destroy($id) {
        $response = Http::delete("{$this->baseUrl}/prodi/$id");
        return $response->successful() ? $response->json() : null;
    }
}