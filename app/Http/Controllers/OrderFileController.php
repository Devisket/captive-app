<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BankController;

class OrderFileController extends Controller
{
    public function show($id)
    {
        $bankController = new BankController;
        $client = $bankController->query;
        $resOrderFile = $client->request('GET', 'OrderFile/' . $id , ["verify" => false]);
        $bodyOrderFile = $resOrderFile->getBody();
        $contentOrderFile = json_encode($bodyOrderFile->getContents());
        $data1contentOrderFile = json_decode($contentOrderFile, true); // Convert JSON to an associative array
        $dataContentOrderFile = json_decode($data1contentOrderFile, true); // Convert JSON to an associative array
        if($dataContentOrderFile != null){
            $orderFiles = $dataContentOrderFile;
        }else{
            $orderFiles = collect([]);
        };

        return $orderFiles;
    }
}
