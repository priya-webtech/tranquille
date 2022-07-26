<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Booking', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Booking</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Booking List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="booking_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> User Name <span class="text-danger">
                                                    *</span></label>
                                            <select name="user_id" id="user_id" class="form-control ">
                                                <option>Select User</option>
                                                @foreach ($users as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->firstname }} {{ $data->lastname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Vendor Name <span class="text-danger">
                                                    *</span></label>
                                            <select name="vendor_id" id="vendor_id" class="form-control ">
                                                <option>Select Vendor</option>
                                                @foreach ($vendors as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->firstname }} {{ $data->lastname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Booking Date<span class="text-danger">
                                                    *</span></label>
                                            <input type="text" class="form-control" name="booking_date"
                                                id="booking_date" placeholder="Booking Date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Booking Time </label>
                                            <input type="text" class="form-control" name="booking_time"
                                                id="booking_time" placeholder="01:10:00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Address </label>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="address" id="address"
                                                    placeholder="Address" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Order Id</label>
                                            <input type="text" class="form-control" name="orderid" id="orderid"
                                                placeholder="Order Id" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Final Amount</label>
                                            <input type="text" class="form-control" name="final_amount"
                                                id="final_amount" placeholder="Final Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Employee Name<span class="text-danger">
                                                    *</span></label>
                                            <select name="employee_id" id="employee_id" class="form-control" onchange="dropdowntreatment()">
                                                <option value="">Select Employee</option>
                                                @foreach ($employee as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->employee_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Service<span class="text-danger">
                                                    *</span></label>
                                            <select name="service_id" id="service_id" class="form-control" onchange="dropdowntreatment()">
                                                <option value="">Select Service</option>
                                                @foreach ($services as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->service_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Treatment<span class="text-danger">
                                                    *</span></label>
                                                    <select name="treatment_id" id="treatment_id" class="form-control ">
                                                    </select>
                                            {{-- <select name="treatment_id" id="treatment_id" class="form-control ">
                                                <option value="">Select Treatment</option>
                                                @foreach ($treatments as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->treatment_name }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
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
                    <h3>Booking</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Booking</a>
                    </div>
                    {{-- <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn btn-outline-primary createuserData" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><i class="fas fa-plus"></i>
                                Add Booking
                            </button>
                        </div>
                </div> --}}
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="booking-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User Name</th>
                                    <th>Shop Name</th>
                                    <th>Service</th>
                                    <th>Treatment</th>
                                    <th>Date</th>
                                    <th>time</th>
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

            var table = $('#booking-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('booking') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
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
                        data: 'booking_time',
                        name: 'booking_time',
                        "defaultContent": ''
                    },
                    {
                        data: 'status',
                        name: 'status',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
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

        $(document).on('click', '.editBooking', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/booking/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#user_id').val(data.user_id);
                    $('#vendor_id').val(data.vendor_id);
                    $('#booking_date').val(data.booking_date);
                    $('#address').val(data.address);
                    $('#employee_id').val(data.employee_id);
                    $('#booking_time').val(data.booking_time);
                    $('#booking_id').val(data.id);
                    $('#orderid').val(data.orderid);
                    $('#service_id').val(data.service_id);
                    $.each(data.treatments, function(key, value) {
                        var selected = data.treatment_id === value.id ? 'selected' : '';
                        $("#treatment_id").append('<option value="' + value.id + '" ' + selected + '>' + value.treatment_name + '</option>');
                    });
                    // $('#treatment_id').val(data.treatment_id);
                    $('#final_amount').val(data.final_amount);
                    // $("#image1").prop("required", false);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#booking_id').val('');
            $('#signup-user-form').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
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

        // dropdown
        function dropdowntreatment() {
            var service_id = $("#service_id").val();;
            if (service_id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('treatmentDropdown') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'service_id': service_id
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res) {
                            $("#treatment_id").empty();
                            $("#treatment_id").append('<option>Select Treatment</option>');
                            $.each(res, function(key, value) {
                                $("#treatment_id").append('<option value="' + value.id + '">' + value
                                    .treatment_name + '</option>');
                            });
                        } else {
                            $("#treatment_id").empty();
                        }
                    }
                });
            } else {
                $("#treatment_id").empty();
            }
        }
    </script>
</x-app-layout>
