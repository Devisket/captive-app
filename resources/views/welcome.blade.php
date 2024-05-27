@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>LANDING PAGE
        <small class="float-right">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBankModal">
                <i class="fas fa-plus"></i> <span>ADD BANK</span>
            </button>
        </small>
    </h1>

@stop

@section('content')
    <p>Select Banks to see details.</p>
    <blockquote>TO DO: </blockquote>

    <div class="modal fade" id="addBankModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-info">ADD BANK</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="addBankForm" action="{{ route("banks.store") }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <x-adminlte-input id="bankName" name="bankName" label="Bank Name" fgroup-class="col-md-12"  igroup-size="sm" required/>
                                    </div>
                                    <div class="row">
                                        <x-adminlte-input id="shortName" name="shortName" label="Short Name" fgroup-class="col-md-12"  igroup-size="sm" required/>
                                    </div>
                                    <div class="row">
                                        <x-adminlte-input id="description" name="description" label="Description" fgroup-class="col-md-12"  igroup-size="sm" required/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <x-adminlte-button type="submit" class="btn btn-sm float-right" theme="success" icon="fas fa-save" label="SAVE" onclick="if(!confirm('Confirm to add new bank!')){ event.preventDefault() }"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
<script>
    // $(document).ready(function () {
    //     $('#addBankForm').submit(function (event) {
    //         event.preventDefault(); // Prevent default form submission

    //         var bankName = $('#bankName').val(); // Get the updated bank name
    //         var description = $('#description').val(); // Get the updated description

    //         // Send an AJAX request to update the bank
    //         $.ajax({
    //             url: `https://localhost:7443/api/Bank`,
    //             type: 'POST',
    //             data: {
    //                 bankName: bankName,
    //                 description: description,
    //             },
    //             success: function (response) {
    //                 // Handle success (e.g., show a success message)
    //                 alert('Bank added successfully:', response);
    //             },
    //             error: function (error) {
    //                 // Handle errors (e.g., show an error message)
    //                 alert('Error adding bank:', error);
    //             },
    //         });
    //     });
    // });
</script>
@stop
