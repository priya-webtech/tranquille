<x-app-layout>
    <!-- [ breadcrumb ] start -->
    @livewire('breadcrumb', ['title' => 'Membership List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   
    <div class="row">
            <div class="col-lg-12 ">
                <div class="card user-profile-list table-bg">
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="membership-list-table" class="table nowrap display dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>User Name</th>
                                        <th>Txn Id</th>
                                        <th>Amount</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
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

        var table = $('#membership-list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('companionMembership') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name'  ,"defaultContent": ''},
                { data: 'txn_id', name: 'txn_id'  ,"defaultContent": ''},
                { data: 'amount', name: 'amount'  ,"defaultContent": ''},
                { data: 'plan_start_date', name: 'plan_start_date'  ,"defaultContent": ''},
                { data: 'plan_end_date', name: 'plan_end_date'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $(document).on('click', '.editMembershipRow', function(){
          var base_url =$('.baseurl').data('baseurl');
          var id = $(this).attr('value');
          $.ajax({
            url: base_url + '/membership/'+id+'/edit',
           dataType:"json",
           success:function(data)
           {
            $('#membership_name').val(data.membership_name);
            $('#description').val(data.description);
            $('#membership_image').val(data.membership_image);
            $('#membership_id').val(data.id);
            $("#image").prop("required", false);
            var title = 'Edit' ;
            $('.modal-title').text(title);
            $('#action_button').val('Edit');
            $('#createMembershipModel').modal('show');
           }
          })
         });

        $('.createMembershipData').click(function () {
            $('#membership_id').val('');
            $('#storeMembershipData').trigger("reset");
            $('.modal-title').text('Add New');
        });
        
        $('body').on('click', '.deleteMembershipRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('membership') }}"+'/'+id,
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