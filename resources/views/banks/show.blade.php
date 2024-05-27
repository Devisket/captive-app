
@extends('adminlte::page')
@section('title', 'Bank Details')
@section('plugins.KrajeeFileinput', true)
@section('plugins.BootstrapSelect', true)
@section('content_header')
<div class="card-header py-0">
    <div class="card-title">
        <h2 title="{{ $bank->Id }}">
            {{$bank->BankName}} ( {{$bank->ShortName}} )
        </h2>
        <p>{{$bank->BankDescription}} <small><em>(Created {{Carbon\Carbon::parse($bank->CreatedDate)->diffForHumans()}} )</em></small></p>
    </div>
    @php
        $config = [
            "title" => "Select options...",
            "liveSearch" => true,
            "liveSearchPlaceholder" => "Search...",
            "showTick" => true,
            "actionsBox" => true,
        ];
        $withInsu = 0;
        foreach ($checkInventories as $check) {
            if(!$check["isAvailable"]){
                $withInsu++;
            }
        }
    @endphp
    <div class="card-tools">
        <div class="d-flex">


            <div class="dropdown dropleft">
                <button class="btn text-primary" type="button" role="button" data-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                      </svg>
                </button>
                <div class="dropdown-menu px-2">

                    <button type="button" class="btn btn-sm btn-secondary my-1" data-toggle="modal" data-target="#updateBankModal" style="width:100%">
                        <small><i class="fas fa-edit"></i> <span>UPDATE BANK</span></small>
                    </button>
                    <form id="deleteBankForm" action="{{ route("banks.destroy", $bank->Id) }}" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-sm btn-danger my-1" style="width:100%" onclick="if(!confirm('Confirm to update bank!')){ event.preventDefault() }" title="DELETE BANK PERMANENTLY">
                            <small><i class="fas fa-trash"></i> <span>DELETE BANK</span></small>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
        <div class="card">
            <div class="card-header">
                <div class="card-title">

                        <button type="button"
                            @if ($withInsu == 0)
                                data-toggle="modal" data-target="#uploadOrderFile"
                                class="btn btn-xs m-2 px-2 btn-outline-success class_orderFilesLink hiddenButtonTool"
                                title="Upload file for processing"
                            @else
                                class="btn btn-xs m-2 px-2 btn-outline-danger class_orderFilesLink hiddenButtonTool"
                                onclick="alert('ADD CHECK INVENTORY FIRST')"
                            @endif
                            >
                            <i class="fas fa-upload"></i> Upload Order File
                        </button>

                    <button type="button" id="addBranchBtnId" data-toggle="modal" data-target="#addBranchModal" class="btn btn-xs m-2 px-2 btn-outline-primary class_branchesLink hiddenButtonTool">
                        <small><i class="fas fa-plus"></i> <span>ADD BRANCH</span></small>
                    </button>

                    <button type="button" id="addFormCheckBtnId" data-toggle="modal" data-target="#addFormChecks" class="btn btn-xs m-2 px-2 btn-outline-primary class_formChecksLink hiddenButtonTool">
                        <small><i class="fas fa-plus"></i> <span>ADD FORM CHECK</span></small>
                    </button>

                    <button type="button" id="addProductTypeBtnId" data-toggle="modal" data-target="#addProductTypeModal" class="btn btn-xs m-2 px-2 btn-outline-primary class_productTypesLink hiddenButtonTool">
                        <small><i class="fas fa-plus"></i> <span>ADD PRODUCT TYPE</span></small>
                    </button>

                </div>
                <div class="card-tools">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a id="orderFilesLink" href="#orderFiles" class="active nav-link py-1" data-toggle="tab"> ORDER FILES</a>
                        </li>
                        <li class="nav-item">
                            <a id="branchesLink" href="#branches" class="nav-link py-1" data-toggle="tab"> BRANCHES</a>
                        </li>
                        <li class="nav-item">
                            <a id="formChecksLink" href="#formChecks" class="nav-link py-1" data-toggle="tab">FORM CHECKS</a>
                        </li>
                        <li class="nav-item">
                            <a id="productTypesLink" href="#productTypes" class="nav-link py-1" data-toggle="tab">PRODUCT TYPES</a>
                        </li>
                        <li class="nav-item">
                            <a id="" href="#checkInventories" class="nav-link py-1" data-toggle="tab">Check Inventory</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="orderFiles">
                        @include("banks.order-files.show")
                    </div>
                    <div class="tab-pane" id="branches">
                        @include("banks.branches.show")
                    </div>
                    <div class="tab-pane" id="formChecks">
                        @include("banks.form-checks.show")
                    </div>
                    <div class="tab-pane" id="productTypes">
                        @include("banks.product-types.show")
                    </div>
                    <div class="tab-pane" id="checkInventories">
                        @include("banks.check-inventories.show")
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">

                </div>
            </div>
        </div>
    <x-adminlte-modal id="updateBankModal" title="UPDATE BANK" size="md" theme="teal"
        icon="fas fa-bell" v-centered static-backdrop scrollable>
        <form id="updateBankForm" action="{{ route("banks.update", $bank->Id)}}" method="post">
            @csrf
            @method("PATCH")
            <div>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="bankName">Bank Name </label>
                        <input type="text" id="bankName" name="bankName" value="{{ $bank["bankName"] }}" class="form-control form-control-sm">
                        <input type="hidden" name="bankId" value="{{ $bank->Id }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <label for="shortName">Short Name </label>
                        <input type="text" id="shortName" name="shortName" value="{{ $bank["bankShortName"]}}" class="form-control form-control-sm">
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
                        <input type="hidden" name="bankId" value="{{ $bank->Id }}">
                        <x-adminlte-button type="submit" class="float-right" theme="success" icon="fas fa-save" label="UPDATE" onclick="if(!confirm('Confirm to update bank!')){ event.preventDefault() }"/>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" class="mr-auto"  label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </form>
    </x-adminlte-modal>

    <x-adminlte-modal id="addProductTypeModal" title="Add Product Type to {{ $bank['bankName'] }}" size="md" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable >
        <form id="productTypeForm"
            action="{{ route("product_types.store")}}"
            method="post">
            @csrf
            @method("POST")
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <input type="hidden" name="bankId" value="{{$bank->Id}}">
                    <x-adminlte-input id="productTypeInputName" name="productName" fgroup-class="col-sm-12"  igroup-size="sm" label="Product Name"/>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-adminlte-button  type="submit" theme="success" class="float-right"  label="SUBMIT"/>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button  theme="outline-danger" class="mr-auto btn-xs" label="X" data-dismiss="modal"/>
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

    <x-adminlte-modal id="addFormChecks" title="Add Form Checks to {{ $bank['bankName'] }}" size="md" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable >
        <form id="addFormChecksForm" action="{{ route("form_checks.store") }}" method="post">
            @csrf
            <div>

                <div class="row">
                    <x-adminlte-select-bs id="productTypeId" name="productTypeId" label="Product Type"
                         igroup-size="sm" :config="$config" fgroup-class="col-12">
                         @foreach ($productTypes as $productType)
                            <option value="{{$productType["productTypeId"]}}">{{$productType["productTypeName"]}}</option>
                         @endforeach
                    </x-adminlte-select-bs>
                </div>
                <div class="row">
                    <x-adminlte-input id="checkTypeInputId" name="checkType" fgroup-class="col-sm-12"  igroup-size="sm" label="Check Type"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="formTypeInputId" name="formType" fgroup-class="col-sm-12"  igroup-size="sm" label="Form Type"/>
                </div>
                <div class="row">
                    <x-adminlte-input id="descriptionInputId" name="description" fgroup-class="col-sm-12"  igroup-size="sm" label="Description"/>
                </div>
                <div class="row">
                    <x-adminlte-input type="number" min="1" max="200" id="quantityInputId" name="quantity" fgroup-class="col-sm-6"  igroup-size="sm" label="Quantity"/>
                    <x-adminlte-input id="fileInitialInputId" name="fileInitial" fgroup-class="col-sm-6"  igroup-size="sm" label="File Initial"/>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <input type="hidden" name="bankId" value="{{ $bank->Id }}">
                        <x-adminlte-button type="submit" class="float-right" theme="success" icon="fas fa-save" label="SAVE" onclick="if(!confirm('Confirm to add form check!')){ event.preventDefault() }"/>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="danger" class="mr-auto"  label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </form>
    </x-adminlte-modal>


    <x-adminlte-modal id="uploadOrderFile" title="UPLOAD ORDER FILE" size="md" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable>
        <form id="uploadFileFormId"
            action="https://localhost:7443/api/OrderFile/upload"
            method="post"
            target="_blank"
            enctype="multipart/form-data">
            @csrf
            @method("POST")
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <input type="hidden" id="uploadBankIdInput" name="bankId" value="{{$bank->Id}}">
                    <x-adminlte-input-file-krajee type="file" id="uploadFileInput" name="files"
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
        $('#updateModal').bind("show.bs.modal", function(e){
            var link = $(e.relatedTarget);
            $(this).find(".modal-body").load(link.attr("href"));
        })
    });



    $(document).ready(function() {
        $(".nav-link").each(function(){
            $(".hiddenButtonTool").hide();
            var navId = $(this).attr("id");
            if($(this).hasClass("active")){
                $(".class_" + navId).show();
            }else{
                $(".class_" + navId).hide();
            }
            $(this).on("click",function(){
                $(".hiddenButtonTool").hide();
                var navId = $(this).attr("id");
                $(".class_" + navId).show();
            })
        })

         // Check if there's an activeTab item in the local storage
        var activeTab = localStorage.getItem('activeTab');
        var activeBtn = localStorage.getItem('activeBtn');
        if (activeTab) {
        console.log(activeTab)
            // If there is, activate the tab
            $('a[href="' + activeTab + '"]').tab('show');
        }
        if (activeBtn) {
            // If there is, activate the tab
            var btnClass = $(".class_" + activeBtn);
            console.log(btnClass)
            btnClass.show();
        }

        // When a tab is shown, update the activeTab item in the local storage
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
            localStorage.setItem('activeBtn', $(e.target).attr('id'));
        });

    });

</script>


@stop
