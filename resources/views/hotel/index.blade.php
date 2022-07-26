<x-app-layout>
  <!-- [ breadcrumb ] start -->@livewire('breadcrumb', ['title' => 'Hotel List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
  <div class="row">
    <div class="col-lg-12 createHotelSection">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h3 class="mb-0"> <span class="pageSectionTitle"></span> Hotel</h3>
          <div class="text-end">
            <button class="btn btn-outline-primary f16" onclick="hidecreateform();"> Hotel List</button>
          </div>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" id="newHotelForm"> @csrf
            <input type="hidden" name="id" id="hotel_id" />
            <div class="row">
              <div class="col-md-12 pt-4">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"> Hotel Name * </label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Hotel Name"> </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"> Address * </label>
                      <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address"> </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">Phone Number</label>
                      <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number"> </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"> Price: </label>
                      <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price"> </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label"> Website URL: </label>
                      <input type="text" class="form-control" name="url" id="url" placeholder="Enter Website"> </div>
                  </div>
                  <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Type: </label>
                                        <input type="text" class="form-control"name="type" id="type" placeholder="Enter Type">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label"> Bedrooms: </label>
                                        <input type="text" class="form-control" name="bedrooms" id="bedrooms" placeholder="Enter Bedrooms">
                                    </div>
                                </div> -->
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label class="form-label col-lg-12 col-sm-12">Description</label>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Write description"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 pt-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <h4 class="m-r-10">Photos</h4> </div>
                    <div class="change-profile pt-4 pb-4">
                      <div class="w-auto d-inline-block d-flex five_v">
                        <div class="profile-dp">
                          <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="{{ url('/').'/'.asset('assets/images/bg1.png') }}" alt="User image"> </div>
                          <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                        </div>
                        <div class="profile-dp">
                          <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="{{ url('/').'/'.asset('assets/images/bg1.png') }}" alt="User image"> </div>
                          <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                        </div>
                        <div class="profile-dp">
                          <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="{{ url('/').'/'.asset('assets/images/bg1.png') }}" alt="User image"> </div>
                          <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                        </div>
                        <div class="profile-dp">
                          <div class="position-relative d-inline-block"> <img class="img-fluid border-r-6 wid-100" src="{{ url('/').'/'.asset('assets/images/bg1.png') }}" alt="User image"> </div>
                          <div class="chnage-b text-center mt-3"> <a class="btn w-100 btn-outline-primary" href="#!">Delete</a> </div>
                        </div>
                        <div class="profile-dp">
                          <div class="position-relative d-inline-block"> 
                            <img class="img-fluid border-r-6 wid-100" src="{{ url('/').'/'.asset('assets/images/bg2.png') }}" alt="User image"> 
                            <input type="file" name="hotel_image[]" id="hotel_image" class="form-control" multiple> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12  pt-4 ">
                    <div class="d-flex align-items-center">
                      <h4 class="m-r-10">Amenities</h4> </div>
                    <div class="change-profile pt-4 pb-4">
                      <div class="form-group row">
                        <div class="col-12">
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">
                              <div class="d-inline-block text-center">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/1.png') }}"></p> <span>Kitchen</span> </div>
                            </label>
                          </div>
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label mr-0" for="inlineCheckbox2">
                              <div class="d-inline-block text-center">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/2.png') }}"></p> <span>Parking</span> </div>
                            </label>
                          </div>
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox3" value="option2">
                            <label class="form-check-label mr-0" for="inlineCheckbox3">
                              <div class="d-inline-block text-center">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/3.png') }}"></p> <span>Wifi</span> </div>
                            </label>
                          </div>
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox4" value="option2">
                            <label class="form-check-label mr-0" for="inlineCheckbox4">
                              <div class="d-inline-block text-center">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/4.png') }}"></p> <span>TV</span> </div>
                            </label>
                          </div>
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox5" value="option2">
                            <label class="form-check-label" for="inlineCheckbox5">
                              <div class="d-inline-block">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/5.png') }}"></p> <span>AC</span> </div>
                            </label>
                          </div>
                          <div class="form-check form-check-inline mr-0 position-relative">
                            <input class="form-check-input coustom" type="checkbox" id="inlineCheckbox6" value="option2">
                            <label class="form-check-label" for="inlineCheckbox6">
                              <div class="d-inline-block text-center">
                                <p class="mb-0"><img src="{{ url('/').'/'.asset('assets/images/6.png') }}"></p> <span>AC</span> </div>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn  btn-block bg_button">Save Hotel</button>
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
          <a href="javascript:void(0);" class="btn btn-outline-primary f16 createHotelData"> <i class="fas fa-plus"></i>Add Hotel </a>
        </div>
        <div class="card-body">
          <div class="dt-responsive table-responsive">
            <table id="hotel-list-table" class="table nowrap display dataTable no-footer">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Price</th>
                  <th>URL</th>
                  <th>Type</th>
                  <th>Bedrooms</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody> </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
    $('.createHotelSection').hide();
  });

  function hidecreateform() {
    $('.createHotelSection').hide();
  }
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var table = $('#hotel-list-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('hotel') }}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false
      }, {
        data: 'name',
        name: 'name',
        "defaultContent": ''
      }, {
        data: 'address',
        name: 'address',
        "defaultContent": ''
      }, {
        data: 'phone_number',
        name: 'phone_number',
        "defaultContent": ''
      }, {
        data: 'price',
        name: 'price',
        "defaultContent": ''
      }, {
        data: 'url',
        name: 'url',
        "defaultContent": ''
      }, {
        data: 'type',
        name: 'type',
        "defaultContent": ''
      }, {
        data: 'bedrooms',
        name: 'bedrooms',
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
  $(document).on('click', '.editHotelRow', function() {
    var base_url = $('.baseurl').data('baseurl');
    var id = $(this).attr('value');
    $.ajax({
      url: base_url + '/hotel/' + id + '/edit',
      dataType: "json",
      success: function(data) {
        $('#name').val(data.name);
        $('#address').val(data.address);
        $('#phone_number').val(data.phone_number);
        $('#price').val(data.price);
        $('#url').val(data.url);
        $('#type').val(data.type);
        $('#bedrooms').val(data.bedrooms);
        $('#hotel_id').val(data.id);
        $("#image").prop("required", false);
        $('.pageSectionTitle').text('Edit ');
        $('.createHotelSection').show();
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }
    })
  });
  $('.createHotelData').click(function() {
    $('#hotel_id').val('');
    $('#newHotelForm').trigger("reset");
    $('.createHotelSection').show();
    $('.pageSectionTitle').text('Add ');
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  $('body').on('click', '.deleteHotelRow', function() {
    var id = $(this).attr("value");
    var token = $("meta[name='csrf-token']").attr("content");
    if(!confirm("Are You sure want to delete ?")) {
      return false;
    }
    $.ajax({
      url: "{{ url('hotel') }}" + '/' + id,
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
  $("form#newHotelPlanForm").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: "{{ route('hotel.store') }}",
      data: formData,
      dataType: "JSON",
      processData: false,
      contentType: false,
      success: function(response) {
        if(response) {
          hidecreateform()
          $('#newHotelPlanForm').trigger("reset");
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
  </script>
</x-app-layout>