{{-- @extends('layouts.app') --}}
{{-- @section('content') --}}
<x-app-layout>

    @livewire('breadcrumb', ['title' => 'Approval', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <div class="row">
        <div class="col-md-12">
            <div class="card table-card latest-activity-card b-radius">
                <div class="card-body d-flex align-items-center justify-content-between">
                        <h3>Approval List</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="approval-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Shop Name</th>
                                    <th>Owner Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#approval-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('approval') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'shopname',
                        name: 'shopname',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'firstname',
                        name: 'firstname',
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

        $(document).on('click', '.editUserRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/approval/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#firstname').val(data.firstname);
                    $('#lastname').val(data.lastname);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#id').val(data.id);
                    $("#password").prop("required", false);
                    var title = 'Edit User';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('#createUserModel').modal('show');
                }
            })
        });

        $('.createuserData').click(function() {
            $('#id').val('');
            $('#storeUserData').trigger("reset");
            $('.modal-title').text('Add New');
        });

        $('body').on('click', '.deleteUserRow', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
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
                    }, 5000);
                },
            });
        });

        $('body').on('click', '.vendoractive', function() {
            var id = $(this).attr("id");
            var active = $(this).attr("value");
            var status = '';
            if (active == 'N') {
                status = 'Active ?';
            } else {
                status = 'Inactive ?';
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
    </script>
</x-app-layout>

{{-- @endsection --}}

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
@endpush
