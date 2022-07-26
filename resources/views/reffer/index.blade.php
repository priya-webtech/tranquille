<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Language', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <!-- Large modal -->
    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <!-- <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Reffer</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData" onclick="hidecreateform();">
                            Reffer List</button>
                    </div>
                </div> -->

                <div class="card-body">
                    <form method="POST" action="{{ route('reffer.store') }}" enctype="multipart/form-data" id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="reffer_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Reffer By <span class="text-danger">*</span></label>
                                            <select name="referralby" id="referralby" class="form-control ">
                                                <option value="">Select User</option>
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
                                            <label class="form-label">Reffer To <span class="text-danger">*</span></label>
                                            <select name="referralto" id="referralto" class="form-control ">
                                                <option value="">Select User</option>
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
                                            <label class="form-label">Email <span class="text-danger"> *</span></label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Phone <span class="text-danger"> *</span></label>
                                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Amount <span class="text-danger"> *</span></label>
                                            <input type="tel" class="form-control" name="amount" id="amount" placeholder="Amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Reefral Code <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="referral_code" id="referral_code" placeholder="Reefral Code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Referral Date <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="referral_date" id="referral_date" placeholder="2022-03-31" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Plateform <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="share_via" id="share_via" placeholder="Plateform" required>
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
                <!-- <div class="card-body d-flex align-items-center justify-content-between">
                    <h3>Reffer</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);" class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Reffer</a>
                    </div>
                </div> -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="language-list-table" class="table table-hover table-borderless">
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

            var table = $('#language-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('reffer') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(document).on('click', '.editLanguageRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/reffer/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#name').val(data.name);
                    $('#status').val(data.status);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                    $('#amount').val(data.amount);
                    $('#share_via').val(data.share_via);
                    $('#referral_date').val(data.referral_date);
                    $('#referral_code').val(data.referral_code);
                    $('#referralby').val(data.referralby).change();
                    $('#referralto').val(data.referralto).change();
                    $('#reffer_id').val(data.id);
                    $("#image").prop("required", false);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#reffer_id').val('');
            $('#signup-user-form').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteLanguageRow', function() {
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