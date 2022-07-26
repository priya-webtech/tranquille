<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Subscription', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    {{-- <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Subscription</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Subscription List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('subscription.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="subscription_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Plan Name <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="plan_name" id="plan_name"
                                                placeholder="Plan Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Plan Type<span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="plan_type" id="plan_type"
                                                placeholder="/month">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Amount<span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="amount" id="amount"
                                                    placeholder="10.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Days <span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="days" id="days"
                                                    placeholder="30">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Description </label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="description"
                                                    id="description" placeholder="Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="form-label"> Portfolio </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="portfolio"
                                                    id="portfolio" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="form-label"> Calendar </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="calendar"
                                                    id="calendar" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Available </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="available"
                                                    id="available" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Long Bio </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="long_bio"
                                                    id="long_bio" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Profile Bg </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="profile_bg"
                                                    id="profile_bg" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Performance </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="performance"
                                                    id="performance" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Account Data </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="account_data"
                                                    id="account_data" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Liability </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="liability"
                                                    id="liability" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label"> Dbs Option </label>
                                            <div class="input-group-append">
                                                <input type="checkbox" class="form-control1" name="dbs_option"
                                                    id="dbs_option" value="1">
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
                    <h3 class="mb-0">Add New Subscription</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Subscription List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('subscription.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="subscription_id" />
                        <div class="row align-items-center">
                            <div class="col-md-4 card m-auto">
                                <div class="row card-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Plan Name * </label>
                                            <input type="text" class="form-control" name="plan_name" id="plan_name"
                                                placeholder="VVIP">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Features</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input input-warning" type="checkbox"
                                                name="portfolio" id="portfolio" value="1">
                                            <label class="form-check-label" for="portfolio">6 Image Portfolio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input input-warning" type="checkbox"
                                                name="calendar" id="calendar" value="1">
                                            <label class="form-check-label" for="calendar">Calendar Sync</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="available" id="available" value="1">
                                            <label class="form-check-label" for="available"> Available Now </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="long_bio" id="long_bio" value="1">
                                            <label class="form-check-label" for="long_bio"> Long Bio </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="profile_bg" id="profile_bg" value="1">
                                            <label class="form-check-label" for="profile_bg"> Profile Background Image
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="performance" id="performance" value="1">
                                            <label class="form-check-label" for="performance"> Performance Stats
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="account_data" id="account_data" value="1">
                                            <label class="form-check-label" for="account_data"> End of Year Account Data
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="liability" id="liability" value="1">
                                            <label class="form-check-label" for="liability"> Public Liability Insurance
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="dbs_option" id="dbs_option" value="1">
                                            <label class="form-check-label" for="dbs_option"> DBS (CRB) Option
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Monthly Price </label>
                                            <input type="text" class="form-control" name="monthly_price"
                                                id="monthly_price" placeholder="5.25">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Yearly Price </label>
                                            <input type="text" class="form-control" name="yearly_price"
                                                id="yearly_price" placeholder="50.50">
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
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Subscription</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Subscription</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="subscription-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th> No</th>
                                    <th>Plan Name</th>
                                    <th>Plan Type</th>
                                    <th>Amount</th>
                                    <th>Portfolio</th>
                                    <th>Calendar</th>
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
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Subscription</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        @foreach ($subscription as $row)
                            <div class="col-sm-12 col-md-3 ">
                                <div class="border rounded card box-shadow-none">

                                    <div class="card-body">
                                        <h4 class="font-weight-bold mb-3">{{ $row['plan_name'] }}</h4>
                                        <div class="row align-items-center m-b-5">
                                            <div class="col-auto">
                                                <h6>Discount</h6>
                                            </div>
                                            <div class="col text-end">
                                                <h6 class="m-b-0"><b>20%</b></h6>
                                            </div>
                                        </div>

                                        <div class="row align-items-center m-b-5">
                                            <div class="col-auto">
                                                <h6>/month</h6>
                                            </div>
                                            <div class="col text-end">
                                                <h6 class="m-b-0">$ {{ $row['monthly_price'] }}</h6>
                                            </div>
                                        </div>

                                        <div class="row align-items-center m-b-5">
                                            <div class="col-auto">
                                                <h6>/Year</h6>
                                            </div>
                                            <div class="col text-end">
                                                <h6 class="m-b-0">$ {{ $row['yearly_price'] }}</h6>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['portfolio'] == 1) fa-check-circle text-success  @else($row['portfolio'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">6 Image Portfolio</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['calendar'] == 1) fa-check-circle text-success  @else($row['calendar'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Calendar Sync</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['available'] == 1) fa-check-circle text-success  @else($row['available'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Available Now</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['long_bio'] == 1) fa-check-circle text-success  @else($row['long_bio'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Long Bio</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['profile_bg'] == 1) fa-check-circle text-success  @else($row['profile_bg'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Profile Background Image</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['performance'] == 1) fa-check-circle text-success  @else($row['performance'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Performance Stats</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['account_data'] == 1) fa-check-circle text-success  @else($row['account_data'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">End of Year Account Data</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['liability'] == 1) fa-check-circle text-success  @else($row['liability'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">Public Liability Insurance</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i
                                                class="fas @if ($row['dbs_option'] == 1) fa-check-circle text-success  @else($row['dbs_option'] == 0) fa-times-circle text-secondary @endif m-r-10"></i>
                                            <h6 class="m-b-0">DBS (CRB) Option</h6>
                                        </div>
                                        {{-- <div class="d-flex align-items-center">
                                            <div class="dropdown-primary dropdown open">
                                                <button class="btn btn-light arrow-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="feather icon-more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                    <a href="javascript:void(0)" class="dropdown-item editCategoryRow" value="{{encrypt($row->id)}}">Edit</a>
                                                    <a href="javascript:void(0)" class="dropdown-item deleteSubscriptionRow" value="{{encrypt($row->id)}}">Delete</a>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <button type="button" class="btn btn-shadow btn-dark w-100 editCategoryRow" value="{{encrypt($row->id)}}">Edit</button>
                                        <button type="button" class="btn w-100 mt-2 trash deleteSubscriptionRow" value="{{encrypt($row->id)}}"> <i data-feather="trash-2"></i> Delete</button>
                                    </div>

                                </div>
                            </div>
                        @endforeach
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

            var table = $('#subscription-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('subscription') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'plan_name',
                        name: 'plan_name',
                        "defaultContent": ''
                    },
                    {
                        data: 'plan_type',
                        name: 'plan_type',
                        "defaultContent": ''
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        "defaultContent": ''
                    },
                    {
                        data: 'portfolio',
                        name: 'portfolio',
                        "defaultContent": ''
                    },
                    {
                        data: 'calendar',
                        name: 'calendar',
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

        $('body').on('click', '.deleteSubscriptionRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('subscription') }}" + '/' + id,
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

        $(document).on('click', '.editCategoryRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/subscription/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#plan_name').val(data.plan_name);
                    $('#plan_type').val(data.plan_type);
                    // $('#amount').val(data.amount);
                    // $('#days').val(data.days);
                    // $('#description').val(data.description);
                    $('#monthly_price').val(data.monthly_price);
                    $('#yearly_price').val(data.yearly_price);
                    if (data.portfolio == 1) {
                        $('#portfolio').prop("checked", true)
                    }
                    if (data.calendar == 1) {
                        $('#calendar').prop("checked", true)
                    }
                    if (data.available == 1) {
                        $('#available').prop("checked", true)
                    }
                    if (data.long_bio == 1) {
                        $('#long_bio').prop("checked", true)
                    }
                    if (data.profile_bg == 1) {
                        $('#profile_bg').prop("checked", true)
                    }
                    if (data.performance == 1) {
                        $('#performance').prop("checked", true)
                    }
                    if (data.account_data == 1) {
                        $('#account_data').prop("checked", true)
                    }
                    if (data.liability == 1) {
                        $('#liability').prop("checked", true)
                    }
                    if (data.dbs_option == 1) {
                        $('#dbs_option').prop("checked", true)
                    }
                    $('#subscription_id').val(data.id);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#subscription_id').val('');
            $('#storeUserData').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        function hidecreateform() {
            $('.createUserSection').hide();
        }
    </script>
</x-app-layout>
