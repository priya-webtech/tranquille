<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Reviews', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Review</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Review List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="feedback_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Booking<span class="text-danger">
                                                    *</span></label>
                                            <select name="booking_id" id="booking_id" class="form-control bookingid"
                                                onchange="dropdowntreatment()" required>
                                                <option>Select Booking</option>
                                                @foreach ($booking as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data['treatmentinfo']['treatment_name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> User Name <span class="text-danger">
                                                    *</span></label>
                                            <select name="reviewby" id="reviewby" class="form-control reviewby"
                                                onchange="dropdownuser()" required>
                                                <!-- <option >Select User</option>
                                                @foreach ($user as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->firstname }} {{ $data->lastname }}
                                                </option>
                                                @endforeach -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Vendor Name <span class="text-danger">
                                                    *</span></label>
                                            <select name="reviewto" id="reviewto" class="form-control" required>
                                                <!-- <option >Select Vendor</option>
                                                @foreach ($vendor as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->firstname }} {{ $data->lastname }}
                                                </option>
                                                @endforeach -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Treatment<span class="text-danger">
                                                    *</span></label>
                                            <div class="input-group-append">
                                                <select name="treatment_id" id="treatment_id" class="form-control"
                                                    required>
                                                    <option>Select Treatment</option>
                                                    @foreach ($treatment as $data)
                                                        <option value="{{ $data->id }}">
                                                            {{ $data->treatment_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Rating</label>
                                            <input type="number" class="form-control" name="rating" id="rating"
                                                min="1" max="5" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Review</label>
                                            <input type="text" class="form-control" name="review" id="review"
                                                placeholder="Review" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
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
                    <h3>Review</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                            class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Review</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="review-list-table" class="table table-hover table-borderless">
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

            var table = $('#review-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('feedback') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(document).on('click', '.editReviewRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/feedback/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    // $('#reviewby').val(data.reviewby);
                    // $('#reviewto').val(data.reviewto);
                    // $('#treatment_id').val(data.treatment_id);
                    // $("#reviewby").val(data.reviewby).change();
                    $('#feedback_id').val(data.id);
                    $('#booking_id').val(data.booking_id);
                    $('#rating').val(data.rating);
                    $('#review').val(data.review);
                    $("#reviewby").prop("required", false);
                    $("#reviewto").prop("required", false);
                    $("#booking_id").prop("required", false);
                    $("#treatment_id").prop("required", false);
                    // $("#reviewby").val(data.reviewby).prop('disabled', true);
                    // $("#reviewby").append($("<option selected = 'selected'></option>").val(data.reviewby).html(data.reviewby)).prop('disabled', true);
                    $("#reviewto").append($("<option selected = 'selected'></option>").val(data.reviewto).html(data.reviewto)).prop('disabled', true);
                    // $("#reviewto").val(data.reviewto).prop('disabled', true);
                    $("#booking_id").val(data.booking_id).prop('disabled', true);
                    $("#treatment_id").val(data.treatment_id).prop('disabled', true);
                    $.each(data.username, function(key, value) {
                        var selected = data.reviewby === value.userinfo.id ? 'selected' : '';
                        $("#reviewby").append('<option value="' + value.userinfo.id + '" ' + selected + '>' + value.userinfo.firstname + '</option>').prop('disabled', true);
                    });
                    // $.each(data.vendorname, function(key, value) {
                    //     var selected = data.reviewto === value.vendor.id ? 'selected' : '';
                    //     alert(value.vendor.id)
                    //     $("#reviewto").append('<option value="' + value.vendor.id + '" ' + selected + '>' + value.vendor.firstname + '</option>').prop('disabled', true);
                    // });
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#feedback_id').val('');
            // $('#signup-user-form').trigger("reset")
            $('#signup-user-form').each(function() {
                this.reset();
            });
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
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
            var booking_id = $("#booking_id").val();
            if (booking_id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('userDropdown') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'booking_id': booking_id
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res) {
                            $("#reviewby").empty();
                            $("#reviewby").append('<option>Select User</option>');
                            $.each(res, function(key, value) {
                                // alert(value.userinfo.firstname)
                                $("#reviewby").append('<option value="' + value.reviewby + '">' + value
                                    .userinfo.firstname + ' ' + value.userinfo.lastname +
                                    '</option>');
                            });
                        } else {
                            $("#reviewby").empty();
                        }
                    }
                });
            } else {
                $("#reviewby").empty();
            }
        }

        function dropdownuser() {
            var reviewby = $("#reviewby").val();
            if (reviewby) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('vendorDropdown') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'reviewby': reviewby
                    },
                    dataType: "json",
                    success: function(res) {
                        // alert(reviewby)
                        if (res) {
                            $("#reviewto").empty();
                            $("#reviewto").append('<option>Select Vendor</option>');
                            $.each(res, function(key, value) {
                                $("#reviewto").append('<option value="' + value.reviewto + '">' + value
                                    .vendor.firstname + ' ' + value.vendor.lastname + '</option>');
                            });
                        } else {
                            $("#reviewto").empty();
                        }
                    }
                });
            } else {
                $("#reviewto").empty();
            }
        }
    </script>
</x-app-layout>
