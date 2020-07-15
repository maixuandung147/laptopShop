{{-- Modal show chi tiết todo --}}
<div class="modal fade" id="show">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 157%;">
            <div class="modal-header">
                <h4 class="modal-title">Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">User_name</th>
                            <th scope="col">Full_Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Level</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Sex</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_detailr">
                        <tr>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>