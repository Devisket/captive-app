<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\RequestException;

class BankBranchController extends Controller
{

    public $bank;
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://localhost:7443/api/']);
    }
    public function store(Request $request)
    {
        $bankData = [
            'bankId' => $request->bankId,
            'branchName' => $request->branchName,
            'brstnCode' => $request->brstnCode,
            'branchAddress1' => $request->branchAddress1,
            'branchAddress2' => $request->branchAddress2,
            'branchAddress3' => $request->branchAddress3,
            'branchAddress4' => $request->branchAddress4,
            'branchAddress5' => $request->branchAddress5,
        ];
        $response = $this->client->request("POST",'Bank/' . $request->bankId . '/branch', [
            'json' => $bankData,
            'verify' => false,
        ]);

        if ($response->getStatusCode() === 200) {
            $message = 'Bank branch added successfully!';
        } else {
            $message = 'Error adding bank branch: ' . $response->getBody();
        }
        toastr()->success($message);
        return back();
    }

    public function destroy($id, Request $request)
    {
        try {
            $bankId = $request->bankId;
            $response = $this->client->request("DELETE",'Bank/'. $bankId . '/branch/' . $id, [
                "verify" => false
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                toastr()->success('Bank deleted successfully!');
                return back();
            } else {
                toastr()->error('Error adding bank: ' . $response->getBody());
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error("Error on Deletion!" . $e->getMessage());
            return back();
        }
    }

    public function update($id, Request $request)
    {
        try{

            $bankData = [
                'bankId' => $request->bankId,
                'branchId' => $id,
                'branchName' => $request->branchName,
                'brstnCode' => $request->brstnCode,
                'branchAddress1' => $request->branchAddress1,
                'branchAddress2' => $request->branchAddress2,
                'branchAddress3' => $request->branchAddress3,
                'branchAddress4' => $request->branchAddress4,
                'branchAddress5' => $request->branchAddress5,
            ];
            $response = $this->client->request("PUT",'Bank/' . $request->bankId . '/branch/' . $id, [
                'json' => $bankData,
                'verify' => false,
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                $message = 'Bank branch added successfully!';
            } else {
                $message = 'Error adding bank branch: ' . $response->getBody();
            }

            toastr()->success($message);
            return back();

        } catch (RequestException $e) {
            toastr()->error($e);
            return back();
        }


    }

    public function show($id){


        $bankController = new BankController;
        $client = $bankController->query;

        $resOrderFile = $client->request('GET', 'Bank/' . $id . '/branches' , ["verify" => false]);
        $bodyOrderFile = $resOrderFile->getBody();
        $contentOrderFile = json_encode($bodyOrderFile->getContents());
        $data1contentOrderFile = json_decode($contentOrderFile, true); // Convert JSON to an associative array
        $dataContentOrderFile = json_decode($data1contentOrderFile, true); // Convert JSON to an associative array
        if($dataContentOrderFile != null){
            $branches = $dataContentOrderFile;
            // $bankId = $branches["bankId"];
            // $branches = collect($branches["branches"]);
        }else{
            $branches = collect([]);
        };
        // if(count($branches) > 0){
        //     $details = $branches->map(function($branch) use ($bankId){
        //             dd($branch);
        //         return [
        //             'id' => $branch['id'],
        //             'brstn' => $branch['brstn'],
        //             'branchName' => $branch['branchName'],
        //             'branchAddress1' => $branch['branchAddress1'],
        //             'branchAddress2' => $branch['branchAddress2'],
        //             'branchAddress3' => $branch['branchAddress3'],
        //             'branchAddress4' => $branch['branchAddress4'],
        //             'branchAddress5' => $branch['branchAddress5'],
        //         ];
        //     });
        // }
        return $branches;

    }

    public function edit($id){
        $ids = explode('+', $id);
        $branchId = $ids[0];
        $bankId = $ids[1];

        $data = $this->show($bankId);
        $branch = collect($data["branches"])->where("id","=",$branchId)->first();
        return view("banks.branches.update", compact("bankId", "branch"));
    }

}
