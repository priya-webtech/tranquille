<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Offer', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <!-- Large modal -->
    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Offer</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Offer List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('offer.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="offer_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Offer Title <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="offer_title"
                                                id="offer_title" placeholder="Offer Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Discount <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="discount" id="discount"
                                                placeholder="Discount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Vendor Name<span class="text-danger"> *</span></label>
                                            <select name="vendor_id" id="vendor_id" class="form-control ">
                                                 <option value="">Select Vendor</option> 
                                                @foreach ($user as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->firstname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Image<span class="text-danger"> *</span></label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                placeholder="Image" required>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
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
                <h3>Offer</h3>
                <div class="text-end user-new"><a href="javascript:void(0);"
                        class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                        Add Offer</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="offer-list-table" class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th> No</th>
                                <th>Vendor name</th>
                                <th>Offer Title</th>
                                <th>Discount</th>
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

            var table = $('#offer-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('offer') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'vendor_id',
                        name: 'vendor_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'offer',
                        name: 'offer',
                        "defaultContent": ''
                    },
                    {
                        data: 'discount',
                        name: 'discount',
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
            $.ajax({
                url: base_url + '/offer/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#offer_title').val(data.offer_title);
                    $('#discount').val(data.discount);
                    $('#offer_image').val(data.offer_image);
                    $('#offer_id').val(data.id);
                    $('#vendor_id').val(data.vendor_id)
                    // $("#vendor_id").append($("<option selected = 'selected'></option>").val(data.vendor_id).html(data.vendor_id));
                    $("#image").prop("required", false);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#offer_id').val('');
            $('#signup-user-form').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteCategoryRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('offer') }}" + '/' + id,
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
