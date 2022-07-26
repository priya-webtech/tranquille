<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Song List </h4>
                    <button type="button" class="btn btn-primary mb-2 createsongssData pull-right" data-toggle="modal" data-target="#createSongModel">Add Song</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ajax-songss-datatable" class="display dataTable no-footer" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Image</th>
                                    <th>Song</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Genere</th>
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
    <div id="createSongModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Song</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
            
                <div class="modal-body">
                     <form method="POST" action="{{ route('songs.store') }}" enctype="multipart/form-data" id="storeSongData">
                        @csrf
                        <input type="hidden" name="id" id="songs_id" />
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>User <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        @if(@isset($users ))
                                            @foreach($users as $user)
                                            <option value="{!! $user['id'] !!}">{!! $user['name'].' '.$user['lastname'] !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Artist <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="artist" id="artist" placeholder="Artist" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Cover Photo</label>
                                    <input type="file" class="form-control" name="image" id="image" placeholder="Cover Photo" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Song <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="songfile" id="songfile" required accept=".mp3,audio/*">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Genere </label>
                                    <textarea class="form-control" name="genere" rows="3" id="genere"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tags</label>
                                    <textarea class="form-control" name="tags" rows="3" id="tags"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Lyrics </label>
                                    <textarea class="form-control" name="lyrics" rows="4" id="lyrics"></textarea>
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

        var table = $('#ajax-songss-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('songs') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'cover_photo', name: 'cover_photo'  ,"defaultContent": ''},
                { data: 'songs', name: 'songs'  ,"defaultContent": ''},
                { data: 'title', name: 'title'  ,"defaultContent": ''},
                { data: 'artist', name: 'artist'  ,"defaultContent": ''},
                { data: 'genere', name: 'genere'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $(document).on('click', '.editSongRow', function(){
          var base_url =$('.baseurl').data('baseurl');
          var id = $(this).attr('value');
          $.ajax({
            url: base_url + '/songs/'+id+'/edit',
           dataType:"json",
           success:function(data)
           {
            $('#title').val(data.title);
            $('#artist').val(data.artist);
            $('#cover_photo').val(data.cover_photo);
            $('#genere').val(data.genere);
            $('#tags').val(data.tags);
            $('#lyrics').val(data.lyrics);
            $('#user_id').val(data.user_id);
            $('#songs_id').val(data.id);
            $("#songfile").prop("required", false);
            var title = 'Edit' ;
            $('.modal-title').text(title);
            $('#action_button').val('Edit');
            $('#createSongModel').modal('show');
           }
          })
         });

        $('.createsongsData').click(function () {
            $('#songs_id').val('');
            $('#storeSongData').trigger("reset");
            $('.modal-title').text('Add New');
        });
        
        $('body').on('click', '.deleteSongRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('songs') }}"+'/'+id,
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
