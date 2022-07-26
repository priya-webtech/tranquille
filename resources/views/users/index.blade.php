<x-app-layout>
    <!-- [ breadcrumb ] start -->
    @livewire('breadcrumb', ['title' => 'User List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="row vi_p">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New User</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            User List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="user_id" />
                        <div class="row align-items-center">
                            {{-- <div class="col-md-3">
                                <div class="change-profile text-center pt-4">
                                    <div class="w-auto d-inline-block">
                                        <a href="#!" class="dropdown-toggle1">
                                            <div class="profile-dp">
                                                <div class="position-relative d-inline-block">
                                                    <img class="img-radius img-fluid wid-100"
                                                        src="{{ url('/') . '/' . asset('assets/images/user/avatar-5.jpg') }}"
                                                        alt="User image" id="profilepreview">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="chnage-b text-center mt-3">
                                    <label for="files" class="btn btn-light-secondary">Choose Profile Image</label>
                                    <input id="files" style="visibility:hidden;" type="file" name="image"
                                        onchange="readURL(this);">
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> First Name<span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="firstname" id="firstname"
                                                placeholder="Enter your First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="lastname" id="lastname"
                                                placeholder="Enter Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Phone <span class="text-danger">*</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    placeholder="Enter phone number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select name="country" id="country" class="form-control ">
                                                <option value="">Select Country</option>
                                                @foreach ($country as $data)
                                                    <option value="{{ $data->country_name }}">
                                                        {{ $data->country_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Language <span class="text-danger">*</span></label>
                                            <select class="form-control js-example-basic-single w-100" multiple="multiple" 
                                                name="language[]" id="language" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%;">
                                                <option>Select Language</option>
                                                @foreach ($language as $data)
                                                    <option value="{{ $data->name }}">
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="text-end">
                                            <button type="submit" class="btn  btn-block bg_button">Submit</button>
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
                    <h3>Users</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add User</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="user-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Language</th>
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


    <!-- form-picker-custom Js -->
    <script src="{{ url('/') . '/' . asset('assets/js/pages/user-validation.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
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

            var table = $('#user-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('users') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'firstname',
                        name: 'firstname',
                        "defaultContent": ''
                    },
                    {
                        data: 'email',
                        name: 'email',
                        "defaultContent": ''
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        "defaultContent": ''
                    },
                    {
                        data: 'country',
                        name: 'country',
                        "defaultContent": ''
                    },
                    {
                        data: 'language',
                        name: 'language',
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

        $(document).on('click', '.editUserRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/users/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#firstname').val(data.firstname);
                    $('#lastname').val(data.lastname);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#user_id').val(data.id);
                    $('#password').val(data.password);
                    $('#country').val(data.country).change();
                    $("#language").append($("<option selected = 'selected'></option>").val(data.language).html(data.language));
                    // $("#country").append($("<option selected = 'selected'></option>").val(data.country).html(data.country));
                    $("#password").prop("required", false);
                    // $('#profilepreview').prop("src", data.profile);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#user_id').val('');
            $('#signup-user-form').trigger("reset");
            // $("#signup-user-form")[0].reset();
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteUserRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('users') }}" + '/' + id,
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

        //vendor details
        $(document).on('click', '.userDetail', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            var url = '{{ url('') }}' + '/users/' + id;
            window.location = url;
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
