<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Dashboard', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])


    <div class="row">

        <!-- all details start -->
        <div class="scrool">
            <div class="row">
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-one b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Active  User</h6>
                                    <h3 class="m-b-0 text-white f18">{!! $activevendors !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo1.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-two b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Total  User</h6>
                                    <h3 class="m-b-0 text-white f18">{!! $users !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo1.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-three b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Total  Vendor</h6>
                                    <h3 class="m-b-0 text-white f18 ">{!! $vendors !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo1.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-four b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Today  Booking</h6>
                                    <h3 class="m-b-0 text-white f18">{!! $todaybooking !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo2.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-five b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Total  Booking</h6>
                                    <h3 class="m-b-0 text-white f18">{!! $totalbooking !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo2.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6">
                    <div class="card prod-p-card six-six b-radius">
                        <div class="card-body p_15 min_h">
                            <div class="row align-items-center ">
                                <div class="col">
                                    <h6 class="m-b-5 text-white">Total  Amount</h6>
                                    <h3 class="m-b-0 text-white f18">$ {!! $membershipamount !!}</h3>
                                </div>
                                <div class="col-auto">
                                    <img class="w-100"
                                        src="{{ url('/') . '/' . asset('assets/image/sixlogo3.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- all details end -->

        <!-- vendor request start -->
        <div class="scrool">
    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Approvel Request</h3>
                    {{-- <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn " data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                View All Request
                            </button>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="vendor-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Shop Name</th>
                                    <th>Owner Name</th>
                                    <th>Phone</th>
                                    <th>Membership</th>
                                    <th>Validity</th>
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
        <!-- vendor request end -->

        <!-- booking start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Booking</h3>
                    {{-- <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn " data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                View All Request
                            </button>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="booking-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>User Name</th>
                                    <th>Shop Name</th>
                                    <th>Service</th>
                                    <th>Treatment</th>
                                    <th>Date</th>
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
                    </div>

        <!-- booking end -->


    </div>
    <!-- [ Main Content ] end -->

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#vendor-list-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                ordering: false,
                searching: false,
                bInfo: false,
                ajax: "{{ url('vendorApproval') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        "defaultContent": ''
                    },
                    {
                        data: 'ownername',
                        name: 'ownername',
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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#booking-list-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                ordering: false,
                searching: false,
                bInfo: false,
                ajax: "{{ url('dashboardBooking') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": ''
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'serviceinfo.service_name',
                        name: 'serviceinfo.service_name',
                        "defaultContent": ''
                    },
                    {
                        data: 'treatmentinfo.treatment_name',
                        name: 'treatmentinfo.treatment_name',
                        "defaultContent": ''
                    },
                    {
                        data: 'booking_date',
                        name: 'booking_date',
                        "defaultContent": ''
                    },
                    {
                        data: 'status',
                        name: 'status',
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

        $('body').on('click', '.vendorInactive', function() {
            var id = $(this).attr("id");
            var active = $(this).attr("value");
            var status = '';
            if (active == 'Y') {
                status = 'Incative ?';
            } else {
                status = 'Ative ?';
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

        $('body').on('click', '.deleteUserRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('vendorApproval') }}" + '/' + id,
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

        $('body').on('click', '.deleteBooking', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('dashboardBooking') }}" + '/' + id,
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
    </script>
</x-app-layout>
