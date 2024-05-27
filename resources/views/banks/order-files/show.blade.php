
@if(count($orderFiles) > 0)
    <div class="table table-responsive">
        <table class="table table-sm table-bordered" width="100%">
            <tbody>
                @foreach ($orderFiles['batches'] as $key=>$orderFile)
                    <tr>
                        <td colspan="5" style="background-color: #f4eebe">
                            {{-- <button type="button" class="btn btn-sm text-success" onclick="if(!confirm('Confirm to download this batch!')){ event.preventDefault() }">
                                <i class="fas fa-download"></i>
                            </button> --}}
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
                                {{-- {{$file["batchFileId"]}} --}}
                            </td>
                            <td class="text-left">{{$file["fileName"]}}</td>
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
            </tbody>
        </table>
    </div>
@else
    <div class="jumbotron">
        <h1 class="text-center"> NO ORDER FILE RECORD </h1>
        <p class="text-center" >
            <button type="button" data-toggle="modal" data-target="#uploadOrderFile" class="btn btn-xs m-2 px-2 btn-success "  title="Upload file for processing"><i class="fas fa-upload"></i> Upload Your First  Order File</button>
        </p>
    </div>
@endif

