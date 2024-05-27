<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\OrderFileController;
use App\Http\Controllers\BankBranchController;

class BankController extends Controller
{
    public $banks;
    public $query;
    public $command;

    public function __construct()
    {

        $this->query = new Client(['base_uri' => 'https://localhost:8443/api/']);
        $this->command = new Client(['base_uri' => 'https://localhost:7443/api/']);

        $resBank = $this->query->request('GET', 'Bank', ["verify" => false]);
        // echo $res->getStatusCode();
        $bodyBank = $resBank->getBody();

        $contentBank = json_encode($bodyBank->getContents());
        $data1Bank = json_decode($contentBank, true); // Convert JSON to an associative array
        $dataBank = json_decode($data1Bank, true); // Convert JSON to an associative array
        $this->banks = collect($dataBank['bankInfos']);

    }

    public function index()
    {
        //
    }

    public function store(Request $request){

        $bankData = [
            'bankName' => $request->bankName,
            'shortName' => $request->shortName,
            'description' => $request->description,
        ];
        $response = $this->command->request("POST",'Bank', [
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

    public function show($id)
    {
        $bank = Bank::find($id);
        $orderFile = new OrderFileController;
        $branch = new BankBranchController;
        $formCheck = new FormCheckController;
        $productType = new ProductTypeController;
        $productConfiguration = new ProductConfigurationController;
        $checkInventory = new CheckInventoryController;

        $orderFiles = $orderFile->show($id);
        $results = $branch->show($id);
        $formChecks = $formCheck->show($id);
        $productTypes = $productType->show($id);
        $productConfigurations = $productConfiguration->show($id);
        $checkInventories = $checkInventory->show($id);

        return view("banks.show", compact("bank", "orderFiles", "results","formChecks","productTypes","productConfigurations","checkInventories"));
    }

    public function update(Request $request, $id){
        try {
            $updatedBankData = [
                'id' => $id,
                'bankName' => $request->bankName,
                'shortName' => $request->shortName,
                'description' => $request->description,
            ];
            $response = $this->command->request("PUT",'Bank/id/'. $id, [
                'json' => $updatedBankData,
                'verify' => false,
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
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

    public function destroy($id){

        try {
            $response = $this->command->request("DELETE",'Bank/id/'. $id, [
                "verify" => false
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                toastr()->success('Bank deleted successfully!');
                return redirect("/");
            } else {
                toastr()->error('Error adding bank: ' . $response->getBody());
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error("Error on Deletion!" . $e->getMessage());
            return back();
        }
    }
}
