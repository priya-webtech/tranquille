<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Product', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <!-- Large modal -->
    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Product</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData" onclick="hidecreateform();">
                            Product List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data" id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="product_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Service Id <span class="text-danger"> *</span></label>
                                            <select name="service_id" id="service_id" class="form-control " onchange="dropdowntreatment()">
                                                <option value="">Select Service</option> 
                                                @foreach ($service as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->service_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Treatment Id <span class="text-danger"> *</span></label>
                                            <select name="treatment_id" id="treatment_id" class="form-control ">
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Treatment Id * </label>
                                            <select name="treatment_id" id="treatment_id" class="form-control ">
                                                {{-- <option value="">Select Treatment</option> --}}
                                                @foreach ($treatment as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->treatment_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Brand Name<span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Image <span class="text-danger"> *</span></label>
                                            <div class="input-group-append">
                                                <input type="file" class="form-control" name="image" id="image" placeholder="Image" required>
                                            </div>
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
                    <h3>Product</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);" class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                            Add Product</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="product-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th> No</th>
                                    <th>Service</th>
                                    <th>Treatment</th>
                                    <th>Brand</th>
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

            var table = $('#product-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('product') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'service_id',
                        name: 'service_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'treatment_id',
                        name: 'treatment_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'brand_image',
                        name: 'brand_image',
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
                url: base_url + '/product/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#service_id').val(data.service_id);
                    $('#brand_name').val(data.brand_name);
                    // dropdowntreatment();
                    $('#brand_image').val(data.brand_image);
                    $('#product_id').val(data.id);
                    // $('#treatment_id').val(data.treatment_id);
                    // $("#treatment_id").val(data.treatment_id).change();
                    // $("#treatment_id").append($("<option selected = 'selected'></option>").val(data.treatment_id).html(data.treatment_id));
                    $.each(data.treatments, function(key, value) {
                        var selected = data.treatment_id === value.id ? 'selected' : '';
                        $("#treatment_id").append('<option value="' + value.id + '" ' + selected + '>' + value.treatment_name + '</option>');
                    });
                    $("#image").prop("required", false);
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#product_id').val('');
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
                url: "{{ url('product') }}" + '/' + id,
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
                                $("#treatment_id").append('<option value="' + value.id + '">' + value.treatment_name + '</option>');
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