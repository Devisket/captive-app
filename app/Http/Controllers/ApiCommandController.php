<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApiCommandController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://localhost:7443/api/']);
    }

    public function storeBank(Request $request){

        $bankData = [
            'bankName' => $request->bankName,
            'shortName' => $request->shortName,
            'description' => $request->description,
        ];
        $response = $this->client->request("POST",'Bank', [
            'json' => $bankData,
            'verify' => false,
        ]);

        if ($response->getStatusCode() === 200) {
            $message = 'Bank added successfully!';
        } else {
            $message = 'Error adding bank: ' . $response->getBody();
        }
        toastr()->success($message);
        return back();
    }

    public function updateBank(Request $request){

        try {
            $id = $request->bankId;
            $updatedBankData = [
                'id' => $id,
                'bankName' => $request->bankName,
                'shortName' => $request->shortName,
                'description' => $request->description,
            ];
            $response = $this->client->request("PUT",'Bank/id/'. $id, [
                'json' => $updatedBankData,
                'verify' => false,
            ]);

            if ($response->getStatusCode() === 200) {
                toastr()->success("Updated successfully!");
                return back();
            } else {
                toastr()->error("Error on update! " . $response->getBody());
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error("Error on Deletion!" . $e->getMessage());
            return back();
        }

    }

    public function deleteBank(Request $request)
    {

    }
}
