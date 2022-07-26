<x-app-layout>
    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ url('/').'/'.asset(isset($user->profile_pic) ? 'profile_images/'.$user->profile_pic : 'images/profile/profile.png') }}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">

                            </div>
                        </div>
                    </div>
                    <div class="profile-blog mb-5">
                        <div class="profile-personal-info">
                            <h4 class="text-primary mb-4">Personal Information</h4>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Full Name <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->name) ? $user->name : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">User Name <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->username) ? $user->username : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->email) ? $user->email : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Phone Number<span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->mobile_code) ? $user->mobile_code : ''!!} {!! isset($user->phone_nuber) ? $user->phone_nuber : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Date of Birth <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->dob) ? $user->dob : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Age <span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->age) ? $user->age : ''!!}</span>
                                </div>
                            </div>

                            <h4 class="text-primary mb-4">Active Membership</h4>
                            <div class="row mb-2">
                                <div class="col-5">
                                    <h5 class="f-w-500">Name<span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-5"><span>{!! isset($user['activeMembership']['membershipPlanInfo']['plan_name']) ? $user['activeMembership']['membershipPlanInfo']['plan_name'] : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5">
                                    <h5 class="f-w-500">Amount <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-5"><span>{!! isset($user['activeMembership']['amount']) ? $user['activeMembership']['amount'] : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5">
                                    <h5 class="f-w-500">Start Date <span class="pull-right">:</span>
                                    </h5>
                                </div>
                               <div class="col-5"><span>{!! isset($user['activeMembership']['plan_start_date']) ? $user['activeMembership']['plan_start_date'] : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5">
                                    <h5 class="f-w-500">End Date <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-5"><span>{!! isset($user['activeMembership']['plan_end_date']) ? $user['activeMembership']['plan_end_date'] : ''!!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link show active">Booking</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link">Membership</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link ">Complaints</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <div class="table-responsive">
                                            <table id="user-Booking-datatable" class="display dataTable no-footer" >
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Companion Name</th>
                                                        <th>Booking Date</th>
                                                        <th>Booking Time</th>
                                                        <th>Booking Hours</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="table-responsive">
                                        <table id="user-Membership-datatable" class="display dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Txn Id</th>
                                                    <th>Amount</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="profile-settings" class="tab-pane fade ">
                                    <div class="pt-3">
                                        <div class="table-responsive">
                                            <table id="user-Complaints-datatable" class="display dataTable no-footer" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Blocked User</th>
                                                        <th>Reason</th>
                                                        <th>User Type</th>
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
    </div>
    <script type="text/javascript">
      $(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        }); 

        var table = $('#user-Booking-datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              url: "{{ url('userBooking') }}",
              data: function (d) {
                    d.user_id = '{{$user->id }}'
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'companioninfo.username', name: 'companioninfo.username'  ,"defaultContent": ''},
                { data: 'booking_date', name: 'booking_date'  ,"defaultContent": ''},
                { data: 'booking_time', name: 'booking_time'  ,"defaultContent": ''},
                { data: 'booking_hours', name: 'booking_hours'  ,"defaultContent": ''},
                { data: 'status', name: 'status'  ,"defaultContent": ''},
            ],
            order: [[0, 'desc']]
        });

        var table2 = $('#user-Membership-datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              url: "{{ url('userMembership') }}",
              data: function (d) {
                    d.user_id = '{{$user->id }}'
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'txn_id', name: 'txn_id'  ,"defaultContent": ''},
                { data: 'amount', name: 'amount'  ,"defaultContent": ''},
                { data: 'plan_start_date', name: 'plan_start_date'  ,"defaultContent": ''},
                { data: 'plan_end_date', name: 'plan_end_date'  ,"defaultContent": ''},
            ],
            order: [[0, 'desc']]
        });

        var table3 = $('#user-Complaints-datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              url: "{{ url('userComplaints') }}",
              data: function (d) {
                    d.user_id = '{{$user->id }}'
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'blockuserinfo.username', name: 'blockuserinfo.username'  ,"defaultContent": ''},
                { data: 'block_reason', name: 'block_reason'  ,"defaultContent": ''},
                { data: 'user_type', name: 'user_type'  ,"defaultContent": ''},
            ],
            order: [[0, 'desc']]
        });
    });
    </script> 
</x-app-layout>

