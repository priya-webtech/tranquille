<x-app-layout>
    <!-- <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, welcome back!</h4>
                <span>Role Table</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            
        </div>
    </div> -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role List </h4>
                    <button type="button" class="btn btn-primary mb-2 createrolesData pull-right" data-toggle="modal" data-target="#createRoleModel">Add Role</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-role-datatable" class="display dataTable no-footer" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
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
    <!-- Large modal -->
    <div id="createRoleModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Role</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
            
                <div class="modal-body">
                    <form method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data" id="storeRoleData">
                         @csrf
                    <input type="hidden" name="id" id="role_id" />
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary">
                     </form>
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

        var table = $('#ajax-role-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('roles') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $(document).on('click', '.editRoleRow', function(){
          var base_url =$('.baseurl').data('baseurl');
          var id = $(this).attr('value');
          $.ajax({
            url: base_url + '/roles/'+id+'/edit',
           dataType:"json",
           success:function(data)
           {
            $('#name').val(data.name);
            $('#role_id').val(data.id);
            var title = 'Edit' ;
            $('.modal-title').text(title);
            $('#action_button').val('Edit');
            $('#createRoleModel').modal('show');
           }
          })
         });

        $('.createrolesData').click(function () {
            $('#role_id').val('');
            $('#storeRoleData').trigger("reset");
            $('.modal-title').text('Add New');
        });
        
        $('body').on('click', '.deleteRoleRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('roles') }}"+'/'+id,
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
