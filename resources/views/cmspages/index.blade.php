<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pages List </h4>
                    <button type="button" class="btn btn-primary mb-2 createPagesData pull-right" data-toggle="modal" data-target="#createPagesModel">Add Pages</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-Pages-datatable" class="display dataTable no-footer" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Status</th>
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
    <div id="createPagesModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Pages</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
            
                <div class="modal-body">
                     <form method="POST" action="{{ route('cms.store') }}" enctype="multipart/form-data" id="storePagesData">
                        @csrf
                        <input type="hidden" name="id" id="cms_id" />
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pages Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cms_name" id="cms_name" placeholder="Title" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image" id="image" placeholder="Image" required>
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

        var table = $('#ajax-Pages-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('cms') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'cms_image', name: 'cms_image'  ,"defaultContent": ''},
                { data: 'cms_name', name: 'cms_name'  ,"defaultContent": ''},
                { data: 'status', name: 'status'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $(document).on('click', '.editPagesRow', function(){
          var base_url =$('.baseurl').data('baseurl');
          var id = $(this).attr('value');
          $.ajax({
            url: base_url + '/cms/'+id+'/edit',
           dataType:"json",
           success:function(data)
           {
            $('#cms_name').val(data.cms_name);
            $('#description').val(data.description);
            $('#cms_image').val(data.cms_image);
            $('#cms_id').val(data.id);
            $("#image").prop("required", false);
            var title = 'Edit' ;
            $('.modal-title').text(title);
            $('#action_button').val('Edit');
            $('#createPagesModel').modal('show');
           }
          })
         });

        $('.createPagesData').click(function () {
            $('#cms_id').val('');
            $('#storePagesData').trigger("reset");
            $('.modal-title').text('Add New');
        });
        
        $('body').on('click', '.deletePagesRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('cms') }}"+'/'+id,
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
