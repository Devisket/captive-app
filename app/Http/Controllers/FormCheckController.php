<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\ValidationException;

class FormCheckController extends Controller
{
    public $query;
    public $command;

    public function __construct()
    {

        $this->query = new Client(['base_uri' => 'https://localhost:8443/api/']);
        $this->command = new Client(['base_uri' => 'https://localhost:7443/api/']);
    }

    public function show($id)
    {

        $resFormCheck = $this->query->request('GET', 'FormChecks/bank/' . $id , ["verify" => false]);
        $bodyFormCheck = $resFormCheck->getBody();
        $contentFormCheck = json_encode($bodyFormCheck->getContents());
        $data1contentFormCheck = json_decode($contentFormCheck, true); // Convert JSON to an associative array
        $dataContentFormCheck = json_decode($data1contentFormCheck, true); // Convert JSON to an associative array
        if($dataContentFormCheck != null){
            $formChecks = $dataContentFormCheck['bankFormChecks'];
        }else{
            $formChecks = collect();
        };

        return $formChecks;


    }

    public function store(Request $request)
    {

        try{

            $rules = [
                'bankId' => "required",
                'productTypeId' => "required",
                'checkType' => "required|max:1|string",
                'formType' => "required|integer",
                'description' =>"required|string",
                'quantity' => "required|integer|max:200",
                'fileInitial' => "required|string",
                'bankId' => "required",
            ];

            $this->validate($request, $rules);

            $bankData = [
                'bankId' => $request->bankId,
                'productTypeId' => $request->productTypeId,
                'checkType' => $request->checkType,
                'formType' => $request->formType,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'fileInitial' => $request->fileInitial,
                'bankId' => $request->bankId,
            ];
            $response = $this->command->request("POST",'FormChecks/Bank/' . $request->bankId , [
                'json' => $bankData,
                'verify' => false,
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                $message = 'Form Check added successfully!';
            } else {
                $message = 'Error adding Form Check: ' . $response->getBody();
            }
            toastr()->success($message);
            return back();
        }catch(ValidationException $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
