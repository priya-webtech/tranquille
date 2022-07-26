<x-app-layout>
    <!-- [ breadcrumb ] start -->
    @livewire('breadcrumb', ['title' => 'Notification List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=>
    'Home'])


    <!-- Large modal -->
    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add Notification</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Notification List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('notification.store') }}" enctype="multipart/form-data"
                        id="storeNotificationData">
                        @csrf
                        <input type="hidden" name="id" id="notification_id" />
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> User <span class="text-danger"> *</span></label>
                                            <select name="user_id" id="user_id" class="form-control" required>
                                                {{-- @if (@isset($users)) --}}
                                                @foreach ($users as $user)
                                                <option>Select User</option>
                                                    <option value="{!! $user['id'] !!}">{!! $user['firstname'] !!} {!! $user['lastname'] !!}
                                                    </option>
                                                @endforeach
                                                {{-- @endif --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"> Title <span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Message<span class="text-danger"> *</span></label>
                                            <textarea name="message" id="message" class="form-control" rows="1" placeholder="Description" required></textarea>
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
                    <h3>Notification</h3>
                    <div class="text-end user-new"><a href="javascript:void(0);"
                        class="btn btn-outline-primary f16 createuserData"><i class="fas fa-plus"></i>
                        Add Notification</a>
                </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="notification-list-table" class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th style="width:60px;">No</th>
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

            var table = $('#notification-list-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('notification') }}",
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
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(document).on('click', '.editNotificationRow', function() {
            var base_url = $('.baseurl').data('baseurl');
            var id = $(this).attr('value');
            $.ajax({
                url: base_url + '/notification/' + id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#title').val(data.title);
                    $('#status').val(data.status);
                    $('#message').val(data.message);
                    $('#notification_id').val(data.id);
                    $("#user_id").val(data.user_id).change();
                    $("#user_id").val(data.user_id).prop('disabled', true);
                    // $("#user_id").append($("<option selected = 'selected'></option>").val(data.user_id).html(data.user_id));
                    var title = 'Edit';
                    $('.modal-title').text(title);
                    $('#action_button').val('Edit');
                    $('.createUserSection').show();
                }
            })
        });

        $('.createuserData').click(function() {
            $('#notification_id').val('');
            $('#storeNotificationData').trigger("reset");
            $('.createUserSection').show();
            $('.modal-title').text('Add New');
            $("#user_id").prop('disabled', false);

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
