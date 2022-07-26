<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Vendor', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])



    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Vendors List</h3>
                    <div class="text-end user-new"><a href="{{ url('vendors/create') }}"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Vendor</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="vendor-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th> No</th>
                                    <th>Shop Name</th>
                                    <th>Owner Name</th>
                                    <th>Phone</th>
                                    <th>validity</th>
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
    {{-- <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Vendor</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Vendor List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="vendor_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> First Name * </label>
                                            <input type="text" class="form-control" name="firstname" id="firstname"
                                                placeholder="Enter your First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Last Name * </label>
                                            <input type="text" class="form-control" name="lastname" id="lastname"
                                                placeholder="Enter Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Phone: </label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    placeholder="Enter phone number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
    </div> --}}

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

            var table = $('#vendor-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('vendors') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        "defaultContent": ''
                    },
                    {
                        data: 'firstname',
                        name: 'firstname',
                        "defaultContent": ''
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        "defaultContent": ''
                    },
                    {
                        data: 'vendordetails.membershipvalid',
                        name: 'vendordetails.membershipvalid',
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
            var url = '{{ url('') }}' + '/vendors/' + id + '/edit';
            // alert(url)
            window.location = url;
        });
        // $(document).on('click', '.editCategoryRow', function() {
        //     var base_url = $('.baseurl').data('baseurl');
        //     var id = $(this).attr('value');
        //     $.ajax({
        //         url: base_url + '/vendors/' + id + '/edit',
        //         dataType: "json",
        //         success: function(data) {
        //             $('#firstname').val(data.firstname);
        //             $('#lastname').val(data.lastname);
        //             $('#email').val(data.email);
        //             $('#phone').val(data.phone);
        //             $('#vendor_id').val(data.id);
        //             $('#password').val(data.password);
        //             $("#password").prop("required", false);
        //             // $("#image").prop("required", false);
        //             var title = 'Edit';
        //             $('.modal-title').text(title);
        //             $('#action_button').val('Edit');
        //             $('.createUserSection').show();
        //         }
        //     })
        // });

        $('.createuserData').click(function() {
            $('#vendor_id').val('');
            $('#storeUserData').trigger("reset");
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
                url: "{{ url('vendors') }}" + '/' + id,
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

        $('body').on('click', '.vendoractive', function() {
            var id = $(this).attr("id");
            var active = $(this).attr("value");
            var status = '';
            if (active == 'N') {
                status = 'Active ?';
            } else {
                status = 'Inactive ?';
            }
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want " + status)) {
                return false;
            }
            $.ajax({
                url: "{{ url('vendors-active') }}",
                type: 'POST',
                data: {
                    _token: token,
                    id: id,
                    active: active
                },
                success: function(data) {
                    $('.message').empty();
                    $('.alert').show();
                    if (data.status == 'success') {
                        $('.alert').addClass("alert-success");
                    } else {
                        $('.alert').addClass("alert-danger");
                    }
                    $('.message').append(data.message);
                    table.draw();
                },
            });
        });

        //vendor details
        $(document).on('click', '.vendorDetail', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            var url = '{{ url('') }}' + '/vendors/' + id;
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
