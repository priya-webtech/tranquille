<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Complaint List </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-Complaint-datatable" class="display dataTable no-footer" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>User Name</th>
                                    <th>Complaint By</th>
                                    <th>Reason</th>
                                    <th>User Type</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<script type="text/javascript">
      $(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        }); 

        var table = $('#ajax-Complaint-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('complaint') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'usersinfo.username', name: 'usersinfo.username'  ,"defaultContent": ''},
                { data: 'blockuserinfo.username', name: 'blockuserinfo.username'  ,"defaultContent": ''},
                { data: 'block_reason', name: 'block_reason'  ,"defaultContent": ''},
                { data: 'user_type', name: 'user_type'  ,"defaultContent": ''},
                { data: 'created_at', name: 'created_at'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $('body').on('click', '.deleteComplaintRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('complaint') }}"+'/'+id,
                type: 'DELETE',
                data: {_token: token,id: id},
                success: function (data) {
                        if(data.status == 'success')
                        {
                            $('.alert-success').show();
                        }
                        else
                        {
                            $('.alert-success').show();
                        }
                        $('.alert-message').append(data.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                },
            });
        });
    </script>  
</x-app-layout>
