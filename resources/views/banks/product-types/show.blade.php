
@if(count($productTypes) > 0)
<div class="table table-responsive">
    <table class="table table-sm table-bordered" width="100%">
        <thead  style="background-color:#191bd2;color:aliceblue">
            <tr class="text-center">
                <th colspan="2">PRODUCT TYPE / CONFIGURATIONS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productTypes as $productType)
                <tr style="background-color:#81e9f9">
                    <td class="pl-3">
                        <button type="button" class="btn btn-xs btn-outline-primary"><i class="fas fa-plus"></i> Add configuration for {{$productType["productTypeName"]}}</button>
                    </td>
                    <td class="pl-3"></td>
                    <td>
                    </td>
                </tr>
                @php
                    $configurations = $productConfigurations->where("productTypeId","=",$productType["productTypeId"]);
                @endphp
                @forelse ($configurations as $configuration)
                    <tr>
                        <td class="pl-4">{{$productType["productTypeName"]}}</td>
                        <td class="text-center">{{$configuration["configurationName"]}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-sm text-secondary" title="Edit Branch Info"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-sm text-primary"  title="View Branch Info"><i class="fas fa-eye"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="pl-4">n/a</td>
                        <td class="text-center">n/a</td>
                        <td class="text-center">n/a</td>
                    </tr>
                @endforelse

            @empty
                <tr>
                    <td colspan="5">
                        <div class="jumbotron">
                            <h1 class="text-center bg-danger">
                                NO PRODUCT TYPE RECORD
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
        <h1 class="text-center"> NO PRODUCT TYPE RECORD </h1>
    </div>
@endif

