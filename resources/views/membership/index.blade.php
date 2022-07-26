<x-app-layout>

    @livewire('breadcrumb', ['title' => 'Membership', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <!-- Large modal -->
    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Membership</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Membership List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('membership.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="membership_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Vendor Name <span class="text-danger"> *</span></label>
                                            <select name="user_id" id="user_id" class="form-control ">
                                                {{-- <option value="">Select Vendor</option> --}}
                                                @foreach ($vendor as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->firstname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Plan Id <span class="text-danger"> *</span></label>
                                            <select name="plan_id" id="plan_id" class="form-control ">
                                                {{-- <option value="">Select Subscription</option> --}}
                                                @foreach ($plan as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->plan_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Transction Status</label>
                                            <input type="text" class="form-control" name="txn_status" id="txn_status"
                                                placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Amount <span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="amount" id="amount"
                                                    placeholder="Amount" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Transction Id</label>
                                            <input type="text" class="form-control" name="transaction_id"
                                                id="transaction_id" placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Description </label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="description"
                                                    id="description" placeholder="Description" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Start Date <span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="start_date"
                                                    id="start_date" placeholder="yy-mm-dd" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> End Date <span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="end_date" id="end_date"
                                                    placeholder="yy-mm-dd" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-end">
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

    <div class="row">
    <div class="col-md-12">
        <div class="card table-card latest-activity-card b-radius">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h3>Membership</h3>
                <div class="text-end user-new"><a href="javascript:void(0);"
                        class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                        Add Membership</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="membership-list-table" class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>Plan Name</th>
                                <th>Transection Id</th>
                                <th>Transection Status</th>
                                <th>Amount</th>
                                <th>Start</th>
                                <th>End</th>
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

            var table = $('#membership-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('membership') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'profile',
                        name: 'profile',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'plan_id',
                        name: 'plan_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'transaction_id',
                        name: 'transaction_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'txn_status',
                        name: 'txn_status',
                        "defaultContent": ''
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        "defaultContent": ''
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        "defaultContent": ''
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
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

        $(document).on('click', '.editMembershipRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/membership/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#user_id').val(data.user_id);
                    $('#description').val(data.description);
                    $('#plan_id').val(data.plan_id);
                    $('#transaction_id').val(data.transaction_id);
                    $('#amount').val(data.amount);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                    $('#txn_status').val(data.txn_status);
                    $('#membership_id').val(data.id);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#membership_id').val('');
            $('#storeUserData').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteMembershipRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('membership') }}" + '/' + id,
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
