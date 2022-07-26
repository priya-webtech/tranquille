<x-app-layout>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewire('breadcrumb', ['title' => 'User Info', 'breadcrumburl' => 'Info', 'breadcrumbtitle'=> 'Home'])

    <div class="row">
        <div class="col-lg-4">
            <div class="card user-card user-card-1">
                <div class="card-body pb-0">
                    <div class="float-end">
                        <a href="javascript:void(0)" class=" deleteUserRow"
                            value="{{ encrypt($user['id']) }}"> <span class="badge bg-light-danger"><i
                                    data-feather="trash-2"></i></a>
                    </div>
                    <div class="media user-about-block align-items-center mt-0 mb-3">
                        <div class="position-relative d-inline-block">
                            <h4>User Profile</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="media user-about-block align-items-center mt-0 mb-3">
                        <div class="position-relative d-inline-block">
                            <img class="img-radius img-fluid wid-120"
                                src="{{ url('/') . '/' . asset(isset($user['profile']) ? $user['profile'] : 'assets/image/dummy.png') }}"
                                alt="User image">
                            <div class="certificated-badge">
                            </div>
                        </div>
                        <div class="media-body ms-3">
                            <h6 class="mb-1">{{ $user['firstname'] }} {{ $user['lastname'] }}</h6>
                            <p class="mb-0 text-muted">{{ $user['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab"
                        role="tablist" aria-orientation="vertical">
                        <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab"
                            data-bs-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile"
                            aria-selected="true">
                            <span class="f-w-500">Profile Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                        <a class="nav-link list-group-item list-group-item-action orderinfo"
                            id="user-set-information-tab" data-bs-toggle="pill" href="#user-set-information" role="tab"
                            aria-controls="user-set-information" aria-selected="false">
                            <span class="f-w-500">Booking Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                        <a class="nav-link list-group-item list-group-item-action orderinfo" id="user-set-feedback-tab"
                            data-bs-toggle="pill" href="#user-set-feedback" role="tab" aria-controls="user-set-feedback"
                            aria-selected="false">
                            <span class="f-w-500">Review Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                        <a class="nav-link list-group-item list-group-item-action orderinfo"
                            id="user-set-notification-tab" data-bs-toggle="pill" href="#user-set-notification"
                            role="tab" aria-controls="user-set-notification" aria-selected="false">
                            <span class="f-w-500">Notification Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                        <a class="nav-link list-group-item list-group-item-action orderinfo" id="user-set-reffer-tab"
                            data-bs-toggle="pill" href="#user-set-reffer" role="tab" aria-controls="user-set-reffer"
                            aria-selected="false">
                            <span class="f-w-500">Reffer & Earn Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                        <a class="nav-link list-group-item list-group-item-action orderinfo"
                            id="user-set-transection-tab" data-bs-toggle="pill" href="#user-set-transection" role="tab"
                            aria-controls="user-set-transection" aria-selected="false">
                            <span class="f-w-500">Transection Detail</span>
                            <span class="float-end"><i class="feather icon-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="tab-content" id="user-set-tabContent">
                <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                    aria-labelledby="user-set-profile-tab">

                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Detail</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-5 pt-4">Personal Info</h5>
                            <table class="table table-borderless border-bottom">
                                <tbody>
                                    <tr>
                                        <td class="">Full Name</td>
                                        <td class="">:</td>
                                        <td class="">{{ $user['firstname'] }} {{ $user['lastname'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">Date of Birth</td>
                                        <td class="">:</td>
                                        <td class="">{{ $user['dob'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">Address</td>
                                        <td class="">:</td>
                                        <td class="">Street 110-B Kalani Bag, Dewas, M.P. INDIA</td>
                                    </tr>
                                    <tr>
                                        <td class="">Language Preffered</td>
                                        <td class="">:</td>
                                        <td class="">{{ $user['language'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">Phone</td>
                                        <td class="">:</td>
                                        <td class="">{{ isset($user['phone']) ? $user['phone'] : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">Email</td>
                                        <td class="">:</td>
                                        <td class="">{{ isset($user['email']) ? $user['email'] : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">Country</td>
                                        <td class="">:</td>
                                        <td class="">{{ $user['country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="">Location Address</td>
                                        <td class="">:</td>
                                        <td class="">{{ isset($user['addressdetails']['location_address']) ? $user['addressdetails']['location_address'] : '' }}</td>
                                    </tr>

                                </tbody>
                            </table>
                            @if ($user['addressdetails'])
                                <h5 class="mb-5 pt-2">Address Info</h5>
                                <div class="row ">
                                    <div class="col-md-4 mb-3">
                                        <div class="profile_f d-flex align-items-start card card-body rounded bg_theme">

                                            <div>
                                                {{-- <p class="mb-0">Home</p> --}}
                                                <h6>{{ isset($user['addressdetails']['address_line1']) ? $user['addressdetails']['address_line1'] : '' }}
                                                </h6>
                                            </div>
                                            <div>
                                                <h6>{{ isset($user['addressdetails']['address_line2']) ? $user['addressdetails']['address_line2'] : '' }}
                                                </h6>
                                            </div>
                                            <div>
                                                <h6>{{ isset($user['addressdetails']['city']) ? $user['addressdetails']['city'] : '' }} , {{ isset($user['addressdetails']['state']) ? $user['addressdetails']['state'] : '' }}
                                                </h6>
                                            </div>
                                            <div>
                                                <h6>{{ isset($user['addressdetails']['postcode']) ? $user['addressdetails']['postcode'] : '' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4 mb-3">
                                        <div class="profile_f d-flex align-items-start card card-body rounded bg_theme">

                                            <div>
                                                <p class="mb-0">Home</p>
                                                <h6>{{ isset($user['addressdetails']['address_line2']) ? $user['addressdetails']['address_line2'] : '' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4 mb-3">
                                        <div class="profile_f d-flex align-items-start card card-body rounded bg_theme">

                                            <div>
                                                <h6>{{ isset($user['addressdetails']['location_address']) ? $user['addressdetails']['location_address'] : '' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>  --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="user-set-information" role="tabpanel"
                    aria-labelledby="user-set-information-tab">
                    <div class="card">
                        <div class="card-header">
                            <h4><span class="p-l-5">Booking Detail</span></h4>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class=" table-card latest-activity-card b-radius">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="booking-list-table" class="table table-hover table-borderless"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>user name</th>
                                                    <th>service</th>
                                                    <th>treatment</th>
                                                    <th>date</th>
                                                    <th>time</th>
                                                    <th>status</th>
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

                <div class="tab-pane fade" id="user-set-feedback" role="tabpanel"
                    aria-labelledby="user-set-feedback-tab">
                    <div class="card">
                        <div class="card-header">
                            <h4><span class="p-l-5">Review Details</span></h4>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="table-card latest-activity-card b-radius">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="review-list-table" class="table table-hover table-borderless"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>User Name</th>
                                                    <th>owner Name</th>
                                                    <th>rating</th>
                                                    <th>review</th>
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

                <div class="tab-pane fade" id="user-set-notification" role="tabpanel"
                    aria-labelledby="user-set-notification-tab">
                    <div class="card">
                        <div class="card-header">
                            <h4><span class="p-l-5">Notification Details</span></h4>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="table-card latest-activity-card b-radius">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="notification-list-table" class="table table-hover table-borderless"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>User Name</th>
                                                    <th>title</th>
                                                    <th>message</th>
                                                    <th>status</th>
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

                <div class="tab-pane fade" id="user-set-reffer" role="tabpanel" aria-labelledby="user-set-reffer-tab">
                    <div class="card">
                        <div class="card-header">
                            <h4><span class="p-l-5">Reffer & Earn Details</span></h4>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class=" table-card latest-activity-card b-radius">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="reffer-list-table" class="table table-hover table-borderless"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>reffer by</th>
                                                    <th>reffer to</th>
                                                    <th>email</th>
                                                    <th>phone</th>
                                                    <th>amount</th>
                                                    <th>platform</th>
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

                <div class="tab-pane fade" id="user-set-transection" role="tabpanel"
                    aria-labelledby="user-set-transection-tab">
                    <div class="card">
                        <div class="card-header">
                            <h4><span class="p-l-5">Transection Details</span></h4>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="table-card latest-activity-card b-radius">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="transection-list-table" class="table table-hover table-borderless"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>user name</th>
                                                    <th>Vendor name</th>
                                                    <th>booking id</th>
                                                    <th>amount id</th>
                                                    <th>transaction id</th>
                                                    <th>date</th>
                                                    <th>status</th>
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

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#booking-list-table').DataTable({
                // "processing": true,
                // "serverSide": true,
                // "pageLength": 5,
                // "searching": false,
                // "ordering": false,
                // "bLengthChange": false,
                // "retrieve": true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('bookinglist') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": ''
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
                        data: 'booking_time',
                        name: 'booking_time',
                        "defaultContent": ''
                    },
                    {
                        data: 'statusinfo.status',
                        name: 'statusinfo.status',
                        "defaultContent": ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "defaultContent": ''
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
            var orderTable = $('#review-list-table').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ratinglist') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ownername',
                        name: 'ownername',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ratings',
                        name: 'ratings',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'review',
                        name: 'review',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "defaultContent": ''
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
            var orderTable = $('#notification-list-table').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userNotification') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        "defaultContent": ''
                    },
                    {
                        data: 'message',
                        name: 'message',
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
                        "defaultContent": ''
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
            var orderTable = $('#reffer-list-table').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userReffer') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'byname',
                        name: 'byname',
                        "defaultContent": ''
                    },
                    {
                        data: 'toname',
                        name: 'toname',
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
                        data: 'amount',
                        name: 'amount',
                        "defaultContent": ''
                    },
                    {
                        data: 'share_via',
                        name: 'share_via',
                        "defaultContent": ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "defaultContent": ''
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
            var orderTable = $('#transection-list-table').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userTransection') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": ''
                    },
                    {
                        data: 'vendor',
                        name: 'vendor',
                        "defaultContent": ''
                    },
                    {
                        data: 'booking_id',
                        name: 'booking_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        "defaultContent": ''
                    },
                    {
                        data: 'transaction_id',
                        name: 'transaction_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'transaction_at',
                        name: 'transaction_at',
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
                        "defaultContent": ''
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $('body').on('click', '.deleteBooking', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('booking') }}" + '/' + id,
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

        $('body').on('click', '.deleteUserRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = '{{ url('users') }}';
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
                        window.location = url;
                    }, 5000);
                },
            });
        });

        $('body').on('click', '.deleteNotificationRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('notification') }}" + '/' + id,
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

        $('body').on('click', '.deleteReview', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('feedback') }}" + '/' + id,
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

        $('body').on('click', '.deleteRefferRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('reffer') }}" + '/' + id,
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

        $('body').on('click', '.deletePaymentRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('payment') }}" + '/' + id,
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
