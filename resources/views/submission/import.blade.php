<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Import excel</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6">
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none !important;">
                    <button type="submit" class="btn btn-success" id="import_excel" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>