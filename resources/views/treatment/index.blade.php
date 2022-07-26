<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Treatment', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add Treatment</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Treatment List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('treatments.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="treatment_id" />
                        <div class="row align-items-center">
                            <div class="col-md-4 m-auto">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Treatment Name <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="treatment_name"
                                                id="treatment_name" placeholder="Enter Category name like: Cleaning">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Service Name <span class="text-danger"> *</span></label>
                                            <select name="service_id" id="service_id" class="form-control ">
                                                {{-- <option value="">Select Service</option> --}}
                                                @foreach ($service as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->service_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label"> Treatment Name * </label>
                                            <input type="text" class="form-control" name="treatment_name"
                                                id="treatment_name" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Rank</label>
                                            <input type="text" class="form-control" name="rank" id="rank"
                                                placeholder="Rank">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label"> Treatment Image </label>
                                            <div class="input-group-append">
                                                <input type="file" class="form-control" name="image" id="image"
                                                    placeholder="Title">
                                            </div>
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
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input input-warning" class="form-control1" name="feature"
                                            id="feature" value="1" type="checkbox">
                                            <label class="form-check-label">Feature</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-block bg_button">Save Treatment</button>
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
                    <h3>Treatment</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="treatment-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th> No</th>
                                    <th>Service Name</th>
                                    <th>Treatment Name</th>
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
        $(document).ready(function() {
            $('.createUserSection').hide();
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var table = $('#treatment-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('treatments') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'service_id',
                        name: 'service_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'treatment_name',
                        name: 'treatment_name',
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
                url: base_url + '/treatments/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#treatment_name').val(data.treatment_name);
                    $('#service_id').val(data.service_id);
                    $('#treatment_image').val(data.treatment_image);
                    $('#rank').val(data.rank);
                    if (data.feature == 1) {
                        $('#feature').prop("checked", true)
                    } else {
                        $('#feature').prop("checked", false)
                    }
                    $('#treatment_id').val(data.id);
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
            $('#treatment_id').val('');
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
                url: "{{ url('treatment') }}" + '/' + id,
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
