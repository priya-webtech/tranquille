<x-app-layout>
    <!-- [ breadcrumb ] start -->
    @livewire('breadcrumb', ['title' => 'MembershipPlan List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   
    <div class="row">
        <div class="col-lg-12 createMembershipPlanSection">
             <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                   <h3 class="mb-0"> <span class="pageSectionTitle"></span> Membership Plan</h3>
                   <div class="text-end">
                      <button class="btn btn-outline-primary f16" onclick="hidecreateform();"> Membership Plan List</button>
                   </div>
                </div>
                <div class="card-body">
                   <form method="POST" enctype="multipart/form-data" id="newMembershipPlanForm"> 
                    @csrf
                      <input type="hidden" name="id" id="plan_id" />
                      <div class="row">
                         <div class="col-md-12 pt-4">
                            <h4> <span class="pageSectionTitle"></span> Membership Plan</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Plan Name * </label>
                                        <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Enter Plan Name"> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Plan Price * </label>
                                        <input type="text" class="form-control" name="plan_price" id="plan_price" placeholder="Enter Plan Price"> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Plan Duration</label>
                                        <input type="text" class="form-control" name="plan_duration" id="plan_duration" placeholder="Enter Plan Duration"> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Offers: </label>
                                        <input type="text" class="form-control" name="offers" id="offers" placeholder="Enter Offers">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="form-label col-lg-12 col-sm-12">User Type</label>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <select class="js-example-basic-single form-control" name="user_type" id="user_type">
                                                <option selected disabled>-- Select User Type --</option>
                                                <option value="User">User</option>
                                                <option value="Companion">Companion</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                               <button type="submit" class="btn  btn-block bg_button">Save Membership</button>
                            </div>
                         </div>
                      </div>
                   </form>
                </div>
             </div>
          </div>
            <div class="col-lg-12 ">
                
                <div class="card user-profile-list table-bg">
                    <div class="text-end user-new">
                        <a href="javascript:void(0);" class="btn btn-outline-primary f16 createMembershipPlanData">
                            <i class="fas fa-plus"></i>Add MembershipPlan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="plan-list-table" class="table nowrap display dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Plan Name</th>
                                        <th>Plan Price</th>
                                        <th>Plan Duration</th>
                                        <th>Offers</th>
                                        <th>User Type</th>
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
      $('.createMembershipPlanSection').hide();
   });

   function hidecreateform() {
      $('.createMembershipPlanSection').hide();
   }

      $(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        }); 

        var table = $('#plan-list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('plan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'plan_name', name: 'plan_name'  ,"defaultContent": ''},
                { data: 'plan_price', name: 'plan_price'  ,"defaultContent": ''},
                { data: 'plan_duration', name: 'plan_duration'  ,"defaultContent": ''},
                { data: 'offers', name: 'offers'  ,"defaultContent": ''},
                { data: 'user_type', name: 'user_type'  ,"defaultContent": ''},
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
            });
        });

        $(document).on('click', '.editMembershipPlanRow', function(){
          var base_url =$('.baseurl').data('baseurl');
          var id = $(this).attr('value');
          $.ajax({
            url: base_url + '/plan/'+id+'/edit',
           dataType:"json",
           success:function(data)
           {
            $('#plan_name').val(data.plan_name);
            $('#plan_price').val(data.plan_price);
            $('#plan_duration').val(data.plan_duration);
            $('#offers').val(data.offers);
            $("#user_type").val(data.user_type).change();
            $('#plan_id').val(data.id);
            $('.pageSectionTitle').text('Edit ');
            $('.createMembershipPlanSection').show();
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
           }
          })
         });

        $('.createMembershipPlanData').click(function () {
            $('#plan_id').val('');
            $('#newMembershipPlanForm').trigger("reset");
            $('.createMembershipPlanSection').show();
            $('.pageSectionTitle').text('Add ');
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
        });
        
        $('body').on('click', '.deleteMembershipPlanRow', function () {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if(!confirm("Are You sure want to delete ?")) {
               return false;
            }
            $.ajax({
                url: "{{ url('plan') }}"+'/'+id,
                type: 'DELETE',
                data: {_token: token,id: id},
                success: function (data) {
                    if(data.status == 'success')
                    {
                        $('.alert-success').show();
                    }
                    else
                    {
                        $('.alert-success').show();
                    }
                    $('.alert-message').append(data.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                },
            });
        });

        $("form#newMembershipPlanForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                 type: "POST",
                 url: "{{ route('plan.store') }}",
                 data: formData,
                 dataType: "JSON",
                 processData: false,
                 contentType: false,
                 success: function(response) {
                    if(response) {
                       hidecreateform()
                       $('#newMembershipPlanForm').trigger("reset");
                    }
                 },
                 error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>   
</x-app-layout>



