<x-app-layout>
   <!-- [ breadcrumb ] start -->
   @livewire('breadcrumb', ['title' => 'Companion List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   <div class="row">
      <div class="col-lg-12 createCompanionSection">
         <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h3 class="mb-0">Add New User</h3>
               <div class="text-end">
                  <button class="btn btn-outline-primary f16" onclick="hidecreateform();"> User List</button>
               </div>
            </div>
            <div class="card-body">
               <form method="POST" enctype="multipart/form-data" id="signup-companion-form"> @csrf
                  <input type="hidden" name="id" id="user_id" />
                  <div class="row">
                     <div class="col-md-12 border-bottom pb-2">
                        <div class="d-flex align-items-center">
                           <h4 class="m-r-10">Photos</h4> <small>Maximum upload 5 photos (no nude)</small> </div>
                        <div class="change-profile pt-4 pb-4">
                           <div class="w-auto d-inline-block d-flex five_v">
                              <div class="profile-dp">
                                 <div class="position-relative d-inline-block">
                                    <input id="files" type="file" name="image1" onchange="readURL1(this);"> <img class="img-fluid border-r-6 wid-100" src="assets/images/bg1.png" alt="User image" id="profilepreview1"> </div>
                                 <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                              </div>
                              <div class="profile-dp">
                                 <div class="position-relative d-inline-block">
                                    <input id="files" type="file" name="image2" onchange="readURL2(this);"> <img class="img-fluid border-r-6 wid-100" src="assets/images/bg1.png" alt="User image" id="profilepreview2"> </div>
                                 <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                              </div>
                              <div class="profile-dp">
                                 <div class="position-relative d-inline-block">
                                    <input id="files" type="file" name="image3" onchange="readURL3(this);"> <img class="img-fluid border-r-6 wid-100" src="assets/images/bg1.png" alt="User image" id="profilepreview3"> </div>
                                 <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                              </div>
                              <div class="profile-dp">
                                 <input id="files" type="file" name="image4" onchange="readURL4(this);">
                                 <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="assets/images/bg1.png" alt="User image" id="profilepreview4"> </div>
                                 <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                              </div>
                              <div class="profile-dp">
                                 <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="assets/images/bg2.png" alt="User image" id="profilepreview">
                                    <input id="files" type="file" name="image" onchange="readURL(this);"> </div>
                              </div>
                              <div class="profile-dp1 btn btn-light-secondary w_100">
                                 <div class="chnage-b text-center mt-3">
                                    <p class="f14">First image will show as a profile image </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 pt-4">
                        <h4>Add new Hotel</h4>
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="form-label"> User Name * </label>
                                 <input type="text" class="form-control" name="username" id="username" placeholder="Enter your User Name"> </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="form-label"> Full Name * </label>
                                 <input type="text" class="form-control" name="name" id="name" placeholder="Enter your Full Name"> </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="form-label">Email</label>
                                 <input type="text" class="form-control" name="email" id="email" placeholder="Email"> </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="form-label"> Contact: </label>
                                 <div class="input-group mb-3">
                                    <select name="mobile_code" id="mobile_code" class="form-control"> @if($countries) @foreach($countries as $country)
                                       <option value="{!! $country->phonecode !!}">{!! $country->phonecode !!}</option> @endforeach @endif </select>
                                    <div class="input-group-append">
                                       <input type="text" class="form-control" name="phone_nuber" id="phone_nuber" placeholder="Enter phone number"> </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Date of Birth*</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-group date">
                                       <input type="text" class="form-control" placeholder="Date of Birth*" id="pc-datepicker-2" name="dob" /> 
                                       <span class="input-group-text">
                                          <i class="feather icon-calendar"></i>
                                       </span> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label class="form-label">Password</label>
                                 <input type="password" class="form-control" name="password" placeholder="Password"> </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Country</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="country_id" id="countryname" onchange="getstatelist();">
                                       <option selected disabled>-- Select Country --</option> @if($countries) @foreach($countries as $country)
                                       <option value="{!! $country->id !!}">{!! $country->name !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">State</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="state_id" id="statename" onchange="getcitylist();">
                                       <option selected disabled>-- Select State --</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">City</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="city_id" id="cityname">
                                       <option selected disabled>-- Select City --</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Height</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="height" id="height">
                                       <option selected disabled>-- Select Height --</option> @if($heights) @foreach($heights as $height)
                                       <option value="{!! $height->height !!}">{!! $height->height !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Body type</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="body_type" id="body_type">
                                       <option selected disabled>-- Select Body type --</option> @if($bodytypes) @foreach($bodytypes as $bodytype)
                                       <option value="{!! $bodytype->body_types !!}">{!! $bodytype->body_types !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Cup Zizes</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="cup_size" id="cup_size">
                                       <option selected disabled>-- Select Cup Sizes--</option> @if($cupsizes) @foreach($cupsizes as $cupsize)
                                       <option value="{!! $cupsize->cup_sizes !!}">{!! $cupsize->cup_sizes !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Language</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="languages" id="languages">
                                       <option selected disabled>-- Select Language --</option> @if($languages) @foreach($languages as $language)
                                       <option value="{!! $language->languages !!}">{!! $language->languages !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Ethnicitys</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="ethnicity" id="ethnicity">
                                       <option selected disabled>-- Select Ethnicitys --</option> @if($ethnicitys) @foreach($ethnicitys as $ethnicity)
                                       <option value="{!! $ethnicity->ethnicitys !!}">{!! $ethnicity->ethnicitys !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">Hair colour</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select class="js-example-basic-single form-control" name="hair_colour" id="hair_colour">
                                       <option selected disabled>-- Select Hair colour --</option> @if($haircolors) @foreach($haircolors as $haircolor)
                                       <option value="{!! $haircolor->hair_colors !!}">{!! $haircolor->hair_colors !!}</option> @endforeach @endif </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group row">
                                 <label class="form-label col-lg-12 col-sm-12">About Me</label>
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea class="form-control" rows="3" name="aboutus" id="aboutus"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="text-end">
                           <button type="submit" class="btn  btn-block bg_button" id="btn-save">Save Companion</button>
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
               <a href="javascript:void(0);" class="btn btn-outline-primary f16 createuserData">
                  <i class="fas fa-plus"></i>Add Companion
               </a> 
            </div>
            <div class="card-body">
               <div class="dt-responsive table-responsive">
                  <table id="user-list-table" class="table nowrap display dataTable no-footer">
                     <thead>
                        <tr>
                           <th>Serial No.</th>
                           <th>User Name</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Birth Date</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody> </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- form-picker-custom Js -->
   <script src="{{ url('/').'/'.asset('assets/js/pages/companion-validation.js') }}"></script>
   <script type="text/javascript">
   $(document).ready(function() {
      $('.createCompanionSection').hide();
   });

   function hidecreateform() {
      $('.createCompanionSection').hide();
   }
   $(function() {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      var table = $('#user-list-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ url('companion') }}",
         columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
         }, {
            data: 'profile_pic',
            name: 'profile_pic',
            "defaultContent": ''
         }, {
            data: 'email',
            name: 'email',
            "defaultContent": ''
         }, {
            data: 'phone_nuber',
            name: 'phone_nuber',
            "defaultContent": ''
         }, {
            data: 'dob',
            name: 'dob',
            "defaultContent": ''
         }, {
            data: 'action',
            name: 'action',
            orderable: false
         }, ],
         order: [
            [0, 'desc']
         ]
      });
   });
   $("form#signup-companion-form").submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      var country = $("#countryname option:selected");
      var state = $("#statename option:selected");
      var city = $("#cityname option:selected");
      formData.append('country_name', country.text());
      formData.append('state_name', state.text());
      formData.append('city_name', city.text());
      $.ajax({
         type: "POST",
         url: "{{ route('companion.store') }}",
         data: formData,
         dataType: "JSON",
         processData: false,
         contentType: false,
         success: function(response) {
            if(response) {
               hidecreateform()
               $('#signup-companion-form').trigger("reset");
            }
         },
         error: function(error) {
            console.log(error);
         }
      });
   });
   $(document).on('click', '.editCompanionRow', function() {
      var base_url = $('.baseurl').data('baseurl');
      var id = $(this).attr('value');
      $.ajax({
         url: base_url + '/companion/' + id + '/edit',
         dataType: "json",
         success: function(data) {
            $('#name').val(data.name);
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#phone_nuber').val(data.phone_nuber);
            $("#mobile_code").val(data.mobile_code).change();
            $('#countryname').val(data.companiondetail.country_id).change();
            $('#statename').val(data.companiondetail.state_id).change();
            $('#cityname').val(data.companiondetail.city_id).change();
            $('#height').val(data.companiondetail.height).change();
            $('#body_type').val(data.companiondetail.body_type).change();
            $('#languages').val(data.companiondetail.languages).change();
            $('#cup_size').val(data.companiondetail.cup_size).change();
            $('#hair_colour').val(data.companiondetail.hair_colour).change();
            $('#ethnicity').val(data.companiondetail.ethnicity).change();
            $('#profilepreview').attr('src', data.profile_pic);
            $('#profilepreview1').attr('src', data.companiondetail.profile_pic1);
            $('#profilepreview2').attr('src', data.companiondetail.profile_pic2);
            $('#profilepreview3').attr('src', data.companiondetail.profile_pic3);
            $('#profilepreview4').attr('src', data.companiondetail.profile_pic4);
            $('#user_id').val(data.id);
            $('#aboutus').val(data.aboutus);
            $('#pc-datepicker-2').val(data.dob);
            $("#password").prop("required", false);
            var title = 'Edit';
            $('.modal-title').text(title);
            $('.createCompanionSection').show();
            window.scrollTo({
               top: 0,
               behavior: 'smooth'
            });
            $('#action_button').val('Edit');
         }
      })
   });
   $('.createuserData').click(function() {
      $('#user_id').val('');
      $('#signup-companion-form').trigger("reset");
      $('.createCompanionSection').show();
      $('.modal-title').text('Add New');
      window.scrollTo({
         top: 0,
         behavior: 'smooth'
      });
   });
   $('body').on('click', '.deleteCompanionRow', function() {
      var id = $(this).attr("value");
      var token = $("meta[name='csrf-token']").attr("content");
      if(!confirm("Are You sure want to delete ?")) {
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
            if(data.status == 'success') {
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

   function readURL(input) {
      if(input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#profilepreview').attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
      }
   }

   function readURL1(input) {
      if(input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#profilepreview1').attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
      }
   }

   function readURL2(input) {
      if(input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#profilepreview2').attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
      }
   }

   function readURL3(input) {
      if(input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#profilepreview3').attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
      }
   }

   function readURL4(input) {
      if(input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#profilepreview4').attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
      }
   }

   function getstatelist() {
      var country_id = $("select[name=country_id]").val();
      if(country_id) {
         $.ajax({
            url: "{{ url('getState') }}",
            dataType: "json",
            type: "POST",
            data: {
               _token: "{{csrf_token()}}",
               country_id: country_id
            },
            success: function(res) {
               $("#statename").empty();
               $("#cityname").empty();
               $.each(res, function(key, value) {
                  $('#statename').append($("<option></option>").attr("value", value.id).text(value.name));
               });
            }
         });
      }
   }

   function getcitylist() {
      var state_id = $("select[name=state_id]").val();
      if(state_id) {
         $.ajax({
            url: "{{ url('getCity') }}",
            dataType: "json",
            type: "POST",
            data: {
               _token: "{{csrf_token()}}",
               state_id: state_id
            },
            success: function(res) {
               $("#cityname").empty();
               $.each(res, function(key, value) {
                  $('#cityname').append($("<option></option>").attr("value", value.id).text(value.name));
               });
            }
         });
      }
   }
   </script>
</x-app-layout>