<x-app-layout>
    {{-- <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Service</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Service List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="service_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label"> Service Name <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="service_name"
                                                id="service_name" placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Rank</label>
                                            <input type="text" class="form-control" name="rank" id="rank"
                                                placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Service Image<span class="text-danger"> *</span></label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                placeholder="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label"> Small Image </label>
                                            <div class="input-group-append">
                                                <input type="file" class="form-control" name="image1" id="image1"
                                                    placeholder="small Image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-start">
                                            <button type="submit" class="btn btn-block bg_button">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

       <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add Service</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Service List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="service_id" />
                        <div class="row align-items-center">
                            <div class="col-md-4 m-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Service Name * </label>
                                            <input type="text" class="form-control" name="service_name"
                                                id="service_name" placeholder="Enter Category name like: Cleaning" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                placeholder="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-block bg_button">Save Service </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Service</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="service-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th style="width:50px"> No</th>
                                    <th>Image</th>
                                    <th>Service Name</th>
                                    <th class="text-end">Action</th>
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
        $(document).ready(function() {
            $('.createUserSection').hide();
        });


        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#service-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('service') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'service_image',
                        name: 'service_image',
                        "defaultContent": ''
                    },
                    {
                        data: 'service_name',
                        name: 'service_name',
                        "defaultContent": ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(document).on('click', '.editCategoryRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/service/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#service_name').val(data.service_name);
                    $('#rank').val(data.rank);
                    $('#service_image').val(data.service_image);
                    $('#small_image').val(data.small_image);
                    $('#service_id').val(data.id);
                    $("#image").prop("required", false);
                    $("#image1").prop("required", false);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#service_id').val('');
            $('#storeUserData').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteCategoryRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('service') }}" + '/' + id,
                type: 'DELETE',
                data: {
                    _token: token,
                    id: id
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.alert-success').show();
                    } else {
                        $('.alert-success').show();
                    }
                    $('.alert-message').append(data.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 5000);
                },
            });
        });

        function hidecreateform() {
            $('.createUserSection').hide();
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profilepreview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
