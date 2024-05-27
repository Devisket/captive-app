@if(count($checkInventories) > 0)
    <div class="table table-responsive">
        <table class="table table-sm text-sm table-bordered" width="100%">
            <thead class="bg-info">
                <tr class="text-center">
                    <th rowspan="2" class="align-middle">BRANCH</th>
                    <th rowspan="2" class="align-middle">FORM CHECK</th>
                    <th rowspan="2" class="align-middle">STD PIECES</th>
                    <th colspan="3">USED SERIES</th>
                    <th colspan="3">AVAILABLE SERIES</th>
                    <th rowspan="2" class="align-middle">TOTAL BOOKLETS</th>
                </tr>
                <tr class="text-center">
                    <th>QTY</th>
                    <th>START</th>
                    <th>END</th>
                    <th>QTY</th>
                    <th>START</th>
                    <th>END</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checkInventories as $checkInventory)
                {{-- @php
                    dd($checkInventories);
                @endphp --}}
                    <tr>
                        <td class="pl-3">{{$checkInventory["BranchName"]}}</td>
                        <td class="pl-3">{{$checkInventory["FormCheck"]}}</td>
                        <td class="text-center">{{$checkInventory["Quantity"]}}</td>
                        <td class="text-center" style="background-color:#f5c3c3">{{$checkInventory["usedBooklet"]}}</td>
                        <td class="text-center px-2" style="background-color:#f5c3c3">{{$checkInventory["usedStart"]}}</td>
                        <td class="text-center px-2" style="background-color:#f5c3c3">{{$checkInventory["usedEnd"]}}</td>
                        <td class="text-center" style="background-color:#d6ffe5">{{$checkInventory["availableBooklet"]}}</td>
                        <td class="text-center px-2" style="background-color:#d6ffe5">{{$checkInventory["availableStart"]}}</td>
                        <td class="text-center px-2" style="background-color:#d6ffe5">{{$checkInventory["availableEnd"]}}</td>
                        <td class="text-center"
                            title="Can Add Quantity if the number of booklet is equal or less than 20 pcs.">
                            @if($checkInventory["isAvailable"])
                                {{$checkInventory["total"]}} pcs
                            @else
                            <form action="{{ route("check_inventories.store")}}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="formCheckId" value="{{$checkInventory["formCheckId"]}}">
                                    <input type="hidden" name="branchId"  value="{{$checkInventory["branchId"]}}">
                                    <x-adminlte-input style="max-width: 60px" fgroup-class="py-0 my-0 mx-auto" type="number" name="quantity" igroup-size="sm">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button class="btn" theme="primary" type="submit" icon="fas fa-save"></x-adminlte-button>
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-white">
                                                <span class="pl-2">{{$checkInventory["total"]}} <strong class="text-primary pl-3">+</strong> </span>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="jumbotron">
        <h1 class="text-center"> NO FOUND CHECK INVENTORY </h1>
    </div>
@endif
