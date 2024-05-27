<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
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
    public function store(Request $request){

        $bankData = [
            'productName' => $request->productName,
        ];
        $response = $this->command->request("POST",'ProductType/bank/'. $request->bankId , [
            'json' => $bankData,
            'verify' => false,
        ]);

        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
            $message = 'Product type added successfully!';
        } else {
            $message = 'Error adding product type: ' . $response->getBody();
        }
        toastr()->success($message);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resProductType = $this->query->request('GET', 'ProductType/' . $id , ["verify" => false]);
        $bodyProductType = $resProductType->getBody();
        $contentProductType = json_encode($bodyProductType->getContents());
        $data1contentProductType = json_decode($contentProductType, true); // Convert JSON to an associative array
        $dataContentProductType = json_decode($data1contentProductType, true); // Convert JSON to an associative array
        if($dataContentProductType != null){
            $productTypes = $dataContentProductType['productTypes'];
        }else{
            $productTypes = collect();
        };

        return $productTypes;

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
