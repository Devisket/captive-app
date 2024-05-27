
@extends('adminlte::page')
@section('title', 'Bank Details')
@section('plugins.KrajeeFileinput', true)
@section('content_header')
    <h1></h1>
@stop
@php
    try {





        try{
            $resProductType = $client->request('GET', 'ProductType/' . $id , ["verify" => false]);
            $bodyProductType = $resProductType->getBody();
            $contentProductType = json_encode($bodyProductType->getContents());
            $data1contentProductType = json_decode($contentProductType, true); // Convert JSON to an associative array
            $dataContentProductType = json_decode($data1contentProductType, true); // Convert JSON to an associative array
            if($dataContentProductType != null){
                $productTypes = $dataContentProductType['productTypes'];
            }else{
                $productTypes = collect();
            };
        } catch (GuzzleHttp\Exception\RequestException $e) {
            $productTypes = collect();
        }

        try{
            $resProductConfigurations = $client->request('GET', 'ProductType/' . $id . '/configuration' , ["verify" => false]);
            $bodyProductConfigurations = $resProductConfigurations->getBody();
            $contentProductConfigurations = json_encode($bodyProductConfigurations->getContents());
            $data1contentProductConfigurations = json_decode($contentProductConfigurations, true); // Convert JSON to an associative array
            $dataContentProductConfigurations = json_decode($data1contentProductConfigurations, true); // Convert JSON to an associative array
            if($dataContentProductConfigurations != null){
                $productConfigurations = collect($dataContentProductConfigurations['productConfigurations']);
            }else{
                $productConfigurations = collect();
            };
        } catch (GuzzleHttp\Exception\RequestException $e) {
            $productConfigurations = collect();
        }
    } catch (GuzzleHttp\Exception\RequestException $e) {
        $client = "NO DETAILS";
    }

@endphp

@section('content')
    @if($client == "NO DETAILS")
        <dic class="card">
            <div class="card-body">
                <div class="jumbotron">
                    <h1>THIS BANK HAS NO DETAILS!</h1>
                </div>
            </div>
        </dic>
    @else
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2 title="{{ $bank['id'] }}">{{$bank["bankName"]}}

                    </h2>
                    <p>{{$bank["bankDescription"]}} <small><em>(Created {{Carbon\Carbon::parse($bank["createdDate"])->diffForHumans()}} )</em></small></p>
                </div>
                <div class="card-tools">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#orderFiles" class="nav-link active py-1" data-toggle="tab">ORDER FILES</a>
                        </li>
                        <li class="nav-item">
                            <a href="#branches" class="nav-link  py-1" data-toggle="tab">BRANCHES</a>
                        </li>
                        <li class="nav-item">
                            <a href="#formChecks" class="nav-link py-1" data-toggle="tab">FORM CHECKS</a>
                        </li>
                        <li class="nav-item">
                            <a href="#productTypes" class="nav-link py-1" data-toggle="tab">PRODUCT TYPES</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane "id="branches">
                        <div class="table table-responsive">
                            <table class="table table-sm table-bordered" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>BRSTN</th>
                                        <th>BRANCH NAME</th>
                                        <th>ADDRESS 1</th>
                                        <th>ADDRESS 2</th>
                                        <th>ADDRESS 3</th>
                                        <th>ADDRESS 4</th>
                                        <th>ADDRESS 5</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($results as $result)
                                        <tr>
                                            <td class="pl-3">{{$result["brstn"]}}</td>
                                            <td class="pl-3">{{$result["branchName"]}}</td>
                                            <td class="pl-3">{{$result["branchAddress1"]}}</td>
                                            <td class="pl-3">{{$result["branchAddress2"]}}</td>
                                            <td class="pl-3">{{$result["branchAddress3"]}}</td>
                                            <td class="pl-3"></td>
                                            <td class="pl-3"></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route("branches.show", $result["id"]) }}" data-id="" class="btn btn-sm text-secondary"
                                                    {{-- data-toggle="modal" data-target="#updateModal" --}}
                                                     title="{{$result["id"]}}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="/branch-delete">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$result["id"]}}">
                                                        <input type="hidden" name="bankId" value="{{$bank["id"]}}">
                                                        <button type="submit" class="btn btn-sm text-danger mx-1" title="Delete Branch Info"
                                                        onclick="if(!confirm('Are you sure you want to permantly delete this bank branch?')){ event.preventDefault() }">
                                                            <i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <div class="jumbotron">
                                                    <h1 class="text-center bg-danger">
                                                        NO FOUND ORDER FILES
                                                    </h1>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="formChecks">

                    </div>
                    <div class="tab-pane active" id="orderFiles">
                        <h2><button type="button" data-toggle="modal" data-target="#uploadOrderFile" class="btn btn-xs m-2 px-2 btn-outline-success float-right"  title="Upload file for processing"><i class="fas fa-upload"></i> Upload Order File</button></h2>
                        <div class="table table-responsive">
                            <table class="table table-sm table-bordered" width="100%">
                                {{-- <thead class="bg-secondary">
                                    <tr class="text-center">
                                        <th></th>
                                        <th colspan="2">BATCH NO.</th>
                                        <th colspan="2">FILE NAME</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @if(count($orderFiles))
                                        @foreach ($orderFiles['batches'] as $key=>$orderFile)
                                            <tr>
                                                <td colspan="5" style="background-color: #f4eebe">
                                                    <button type="button" class="btn btn-sm text-success" onclick="if(!confirm('Confirm to download this batch!')){ event.preventDefault() }">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm mx-3 hiddenIconClass" id="hiddenIcon{{$key}}">
                                                            <i class="fas fa-folder text-primary showingIcon"></i>
                                                            <i class="fas fa-folder-open text-danger hiddenIcon"></i>
                                                    </button>
                                                    <strong class="">
                                                        Batch No.  {{$key + 1}}
                                                    </strong>
                                                    <em class="float-right px-4">
                                                        {{Carbon\Carbon::parse($orderFile["uploadDate"])->format("l, M d, Y")}}
                                                    </em>
                                                </td>
                                            </tr>
                                            @foreach ($orderFile["orderFiles"] as $key2=>$file)
                                                <tr class="hiddenIcon class_hiddenIcon{{$key}}" style="background-color: #e1f7fe" >
                                                    <td class="pl-3" colspan="2">
                                                        <button type="button" class="btn btn-sm mx-3 hiddenIconClass2" id="hiddenIcon2{{$key}}-{{$key2}}">
                                                            <i class="fas fa-folder text-primary showingIcon"></i>
                                                            <i class="fas fa-folder-open text-danger hiddenIcon"></i>
                                                        </button>
                                                        {{$file["batchFileId"]}}
                                                    </td>
                                                    <td class="text-center">{{$file["fileName"]}}</td>
                                                    <td class="text-center" colspan="2">{{$file["fileStatus"]}}</td>
                                                </tr>
                                                @if(is_array($file["checkOrders"]))
                                                    <tr class="hiddenIcon class2_hiddenIcon2{{$key}}-{{$key2}}">
                                                        <td></td>
                                                        <td>BRSTN</td>
                                                        <td>ACCOUNT NAME</td>
                                                        <td>DELIVERY TO:</td>
                                                        <td>QUANTITY</td>
                                                    </tr>
                                                    @foreach ($file["checkOrders"] as $orders)
                                                        <tr class="hiddenIcon class2_hiddenIcon2{{$key}}-{{$key2}}">
                                                            <td></td>
                                                            <td>{{$orders['brstn']}}</td>
                                                            <td>{{$orders['accountName']}}</td>
                                                            <td>{{$orders['deliveringBRSTN']}}</td>
                                                            <td>{{$orders['quantity']}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    {{ $file["checkOrders"]}}
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="productTypes">

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">

                    <button type="button" id="addBranchBtnId" data-toggle="modal" data-target="#addBranchModal" class="btn btn-sm btn-primary mx-1">
                        <small><i class="fas fa-plus"></i> <span>ADD BRANCH</span></small>
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary mx-1" data-toggle="modal" data-target="#updateBankModal">
                        <small><i class="fas fa-edit"></i> <span>UPDATE BANK</span></small>
                    </button>

                    <form action="/bank/delete" method="GET">
                        @csrf
                        <input type="hidden" name="bank_id" value="{{ $bank["id"]}}">
                        <button type="submit" onclick="if(!confirm('Are you sure you want to permantly delete this bank?')){ event.preventDefault() }" class="btn btn-sm btn-danger mx-1" title="DELETE BANK PERMANENTLY">
                            <small><i class="fas fa-trash"></i> <span>DELETE BANK</span></small>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <x-adminlte-modal id="updateBankModal" title="UPDATE BANK" size="md" theme="teal"
        icon="fas fa-bell" v-centered static-backdrop scrollable>
        <form id="updateBankForm" action="/bank/update" method="GET">
            @csrf
            <div>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="bankName">Bank Name </label>
                        <input type="text" id="bankName" name="bankName" value="{{ $bank["bankName"] }}" class="form-control form-control-sm">
                        <input type="hidden" name="bankId" value="{{ $bank["id"] }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="shortName">Short Name </label>
                        <input type="text" id="shortName" name="shortName" value="" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <label for="description">Bank Description</label>
                        <input type="text" id="description" name="description" value="{{ $bank["bankDescription"] }}" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <x-adminlte-button type="submit" class="float-right" theme="success" icon="fas fa-save" label="UPDATE" onclick="if(!confirm('Confirm to update bank!')){ event.preventDefault() }"/>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" class="mr-auto"  label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="addBranchModal" title="Add Branch to {{ $bank['bankName'] }}" size="md" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable >
        <form id="addBranchForm" action="{{ route("branches.store") }}" method="post">
            @csrf
            <div>
                <div class="row">
                    <x-adminlte-input id="brstnCode" name="brstnCode" fgroup-class="col-sm-4" igroup-size="sm" label="BRSTN"/>
                    <x-adminlte-input id="branchName" name="branchName" fgroup-class="col-sm-8"  igroup-size="sm" label="Branch Name"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="branchAddress1" name="branchAddress1" fgroup-class="col-sm-12"  igroup-size="sm" label="Branch Address 1"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="branchAddress2" name="branchAddress2" fgroup-class="col-sm-12"  igroup-size="sm" label="Branch Address 2"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="branchAddress3" name="branchAddress3" fgroup-class="col-sm-12"  igroup-size="sm" label="Branch Address 3"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="branchAddress4" name="branchAddress4" fgroup-class="col-sm-12"  igroup-size="sm" label="Branch Address 4"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="branchAddress5" name="branchAddress5" fgroup-class="col-sm-12"  igroup-size="sm" label="Branch Address 5"/>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <input type="hidden" name="bankId" value="{{ $bank["id"] }}">
                        <x-adminlte-button type="submit" class="float-right" theme="success" icon="fas fa-save" label="UPDATE" onclick="if(!confirm('Confirm to update bank!')){ event.preventDefault() }"/>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" class="mr-auto"  label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </form>
    </x-adminlte-modal>


    <div class="modal fade" id="updateModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePClabel">UPDATE DETAILS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>


    <x-adminlte-modal id="uploadOrderFile" title="UPLOAD ORDER FILE" size="md" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable>
    <form id="uploadFileFormId"
        action="https://localhost:7443/api/OrderFile/upload"
        method="post"
        target="_blank()"
        enctype="multipart/form-data">
        @csrf
        @method("POST")
        <div class="row">
            <div class="col-sm-12 mt-4">
                <input type="hidden" name="bankId" value="{{$bank["id"]}}">
                <x-adminlte-input-file-krajee type="file" id="files" name="files"
                    igroup-size="sm" data-msg-placeholder="Choose multiple files..."
                    data-show-cancel="true" data-show-close="true" multiple/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <x-adminlte-button id="uploadFileBtnId" type="submit" theme="success" class="float-right"  label="UPLOAD"/>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button  theme="outline-danger" class="mr-auto" label="X" data-dismiss="modal"/>
        </x-slot>
    </form>
</x-adminlte-modal>
@stop

@section('css')
<style>
    table tbody tr td {
        padding-left: 10px;
    }
</style>
@stop

@section('js')


<script>
    $(document).ready(function () {

        $(".hiddenIcon").hide();
        $(".hiddenIconClass").each(function(){
            $(this).on("click", function(){
                var id = $(this).attr("id");
                $(".class_" + id).toggle();
                $(this).children().toggle();
            })
        })
        $(".hiddenIconClass2").each(function(){
            $(this).on("click", function(){
                var id2 = $(this).attr("id");
                $(".class2_" + id2).toggle();
                $(this).children().toggle();
            })
        })

        $('#updateBranchBtnId').bind("show.bs.modal", function(e){
            var link = $(e.relatedTarget);
            $(this).find(".modal-body").load(link.attr("href"));
        })
    });

</script>

@stop
