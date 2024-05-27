<div class="card">
    <div class="card-body">
        <form id="addBranchForm" action="{{ route("branches.update", $branch["id"])}}" method="post">
            @csrf
            @method("PATCH")
            <div>
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="brstnId">BRSTN</label>
                            <input type="text" value="{{$branch["brstn"]}}" name="brstnCode" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="branchName">BRANCH NAME</label>
                            <input type="text" value="{{$branch["branchName"]}}" name="branchName" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branchAddress1">Address 1</label>
                            <input type="text" class="form-control form-control-sm" value="{{$branch["branchAddress1"]}}" name="branchAddress1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branchAddress2">Address 2</label>
                            <input type="text" class="form-control form-control-sm" value="{{$branch["branchAddress2"]}}" name="branchAddress2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branchAddress3">Address 3</label>
                            <input type="text"  class="form-control form-control-sm" value="{{$branch["branchAddress3"]}}" name="branchAddress3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branchAddress4">Address 4</label>
                            <input type="text"  class="form-control form-control-sm" value="{{$branch["branchAddress4"]}}" name="branchAddress4">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branchAddress5">Address 5</label>
                            <input type="text" class="form-control form-control-sm" value="{{$branch["branchAddress5"]}}" name="branchAddress5">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-4">
                        <input type="text" name="bankId" value="{{ $bankId }}">
                        <button type="submit" class="float-right btn btn-success " onclick="if(!confirm('Confirm to update bank!')){ event.preventDefault() }"><i class="fas fa-save"></i> UPDATE </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
