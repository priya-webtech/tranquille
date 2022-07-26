<x-app-layout>
    <!-- [ breadcrumb ] start -->
    @livewire('breadcrumb', ['title' => 'Blocked List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   
    <div class="row">
            <div class="col-lg-12 ">
                <div class="card user-profile-list table-bg">
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="blocked-list-table" class="table nowrap display dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>User Name</th>
                                        <th>Complement By</th>
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

        var table = $('#blocked-list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('blocked') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'blockuser', name: 'blockuser'  ,"defaultContent": ''},
                { data: 'username', name: 'username'  ,"defaultContent": ''},
                { data: 'complaintinfo.block_reason', name: 'complaintinfo.block_reason'  ,"defaultContent": ''},
                { data: 'complaintinfo.user_type', name: 'complaintinfo.user_type'  ,"defaultContent": ''},
                { data: 'created_at', name: 'created_at'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });        
        $('body').on('click', '.deleteBlockedRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('blocked') }}"+'/'+id,
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

