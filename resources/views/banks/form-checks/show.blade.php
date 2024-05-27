@php
    // dd($formChecks);
@endphp

@if(count($formChecks) > 0)
    <div class="table table-responsive">
        <table class="table table-sm table-bordered" width="100%">
            <thead>
                <tr class="text-center">
                    <th>DESCRIPTION</th>
                    <th>CHECK TYPE</th>
                    <th>FORM TYPE</th>
                    <th>QUANTITY</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($formChecks as $formCheck)
                    <tr>
                        <td class="pl-3">{{$formCheck["description"]}}</td>
                        <td class="text-center">{{$formCheck["checkType"]}}</td>
                        <td class="text-center">{{$formCheck["formType"]}}</td>
                        <td class="text-center">{{$formCheck["quanitity"]}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-sm text-danger mx-1" title="Delete Form Check"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="jumbotron">
                                <h1 class="text-center bg-danger">
                                    NO FOUND FORM CHECKS
                                </h1>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@else
    <div class="jumbotron">
        <h1 class="text-center"> NO FOUND FORM CHECKS </h1>
        <p class="text-center" >
            <button type="button" data-toggle="modal" data-target="#addFormChecks" class="btn btn-xs m-2 px-2 btn-success "  title="Upload file for processing"><i class="fas fa-upload"></i> Add Form Check</button>
        </p>
    </div>
@endif


