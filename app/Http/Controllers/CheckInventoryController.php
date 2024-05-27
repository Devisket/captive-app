<?php

namespace App\Http\Controllers;

use App\Models\CheckInventory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInventoryController extends Controller
{

    public $banks;
    public $query;
    public $command;

    public function __construct()
    {
        $this->query = new Client(['base_uri' => 'https://localhost:8443/api/']);
        $this->command = new Client(['base_uri' => 'https://localhost:7443/api/']);
    }

    public function store(Request $request){
        $bankData = [
            'formCheckId' => $request->formCheckId,
            'branchId' => $request->branchId,
            'quantity' => $request->quantity,
            'withSeries' => true,
        ];
        $response = $this->command->request("POST",'CheckInventory/AddInventory', [
            'json' => $bankData,
            'verify' => false,
        ]);

        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
            $message = 'Added successfully!';
            toastr()->success($message);
        } else {
            $message = 'Error adding check inventory: ' . $response->getBody();
            toastr()->error($message);
        }
        return back();
    }

    public function show($id){
        $inventories = CheckInventory::select(
                    'Quantity',
                    'FormCheckId',
                    'BranchId')
                ->groupBy(
                    'Quantity',
                    'FormCheckId',
                    'BranchId'
                    )
                ->get();
        $checkInventories = $inventories->map(function($inv){
                $available = CheckInventory::where("BranchId","=",$inv->BranchId)
                    ->where("FormCheckId","=",$inv->FormCheckId)
                    ->where("Quantity","=", $inv->Quantity)
                    ->where("CheckOrderId","=", null)
                    ->orderBy("StarSeries","asc")
                    ->get();

                $availableStart = 0;
                $availableEnd = 0;
                $availableBooklet = 0;
                $isAvailable = false;
                if(count($available) > 0){
                    $availableStart = $available[0]->StarSeries;
                    $availableEnd = $available[count($available) - 1]->EndSeries;
                    $availableBooklet = (+$availableEnd - +$availableStart + 1) / $inv->Quantity;
                    if($availableBooklet >= 20){
                        $isAvailable = true;
                    }
                }

                $used = CheckInventory::where("BranchId","=",$inv->BranchId)
                    ->where("FormCheckId","=",$inv->FormCheckId)
                    ->where("Quantity","=", $inv->Quantity)
                    ->where("CheckOrderId","!=", null)
                    ->orderBy("StarSeries","asc")
                    ->get();
                $usedStart = 0;
                $usedEnd = 0;
                $usedBooklet = 0;
                if(count($used) > 0){
                    $usedStart = $used[0]->StarSeries;
                    $usedEnd = $used[count($used) - 1]->EndSeries;
                    $usedBooklet = (+$usedEnd - +$usedStart + 1) / $inv->Quantity;
                }
                $total = +$usedBooklet + +$availableBooklet;
            return [
                'formCheckId' => $inv->FormCheckId,
                'branchId' => $inv->BranchId,
                'BranchName' => $inv->branch->BranchName,
                'FormCheck' => $inv->formCheck->Description,
                'Quantity' => $inv->Quantity,
                'availableStart' => $availableStart,
                'availableEnd' => $availableEnd,
                'availableBooklet' => $availableBooklet,
                'usedStart' => $usedStart,
                'usedEnd' => $usedEnd,
                'usedBooklet' => $usedBooklet,
                'isAvailable' => $isAvailable,
                'total' => $total,
            ];
        });
        return $checkInventories;
    }

}
