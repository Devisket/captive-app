<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductConfigurationController extends Controller
{
    public $query;
    public $command;

    public function __construct()
    {

        $this->query = new Client(['base_uri' => 'https://localhost:8443/api/']);
        $this->command = new Client(['base_uri' => 'https://localhost:7443/api/']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $resProductConfigurations = $this->query->request('GET', 'ProductType/' . $id . '/configuration' , ["verify" => false]);
        $bodyProductConfigurations = $resProductConfigurations->getBody();
        $contentProductConfigurations = json_encode($bodyProductConfigurations->getContents());
        $data1contentProductConfigurations = json_decode($contentProductConfigurations, true); // Convert JSON to an associative array
        $dataContentProductConfigurations = json_decode($data1contentProductConfigurations, true); // Convert JSON to an associative array
        if($dataContentProductConfigurations != null){
            $productConfigurations = collect($dataContentProductConfigurations['productConfigurations']);
        }else{
            $productConfigurations = collect();
        };
        return $productConfigurations;
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
