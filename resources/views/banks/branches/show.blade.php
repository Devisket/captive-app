
@if(count($results) > 0)
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

                @forelse ($results['branches'] as $result)
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

                                <a href="{{ route("branches.edit", $result["id"] . '+' . $results["bankId"])}}" data-id="" class="btn btn-sm text-secondary"
                                data-toggle="modal" data-target="#updateModal"
                                 title="{{$result["id"]}}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route("branches.destroy", $result["id"])}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <input type="hidden" name="bankId" value="{{$results["bankId"]}}">
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
@else
    <div class="jumbotron">
        <h1 class="text-center"> NO BRANCHES ON THIS BANK </h1>
        <p class="text-center" >
            <button type="button" data-toggle="modal" data-target="#addBranchModal" class="btn btn-xs m-2 px-2 btn-primary"  title="Upload file for processing"><i class="fas fa-plus"></i> Add the first branch</button>
        </p>
    </div>
@endif

