<x-app-layout>
   <!-- [ breadcrumb ] start -->
   @livewire('breadcrumb', ['title' => 'Location', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h3 class="mb-0">Location</h3>
            </div>
            <div class="card-body">
               <form method="POST" id="MasterDataLocationForm" enctype="multipart/form-data"> @csrf
               <div class="row">
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <h4>Country </h4>
                           <div class="form-check">
                              <input type="checkbox" class="mb-3 form-check-input" id='checkall' />
                           </div>
                        </div>
                        <div class="card-body">
                              <div class="form-group row">
                                 <div class="col-12" id="countryDisplayList">
                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <h4>State <span class="f16 selectedState"></span></h4>
                           <div class="form-check">
                              <input type="checkbox" class="mb-3 form-check-input" id='checkall1' />
                           </div>
                        </div>
                        <div class="card-body">
                              <div class="form-group row">
                                 <div class="col-12" id="stateDisplayList">
                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <h4>City <span class="f16 selectedCity"></span></h4>
                           <div class="form-check">
                              <input type="checkbox" class="mb-3 form-check-input" id='checkall2' />
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                              <a href="javascript:void(0);" class="btn btn-sm bg_button" onclick="cityStoreInSession();">Store Change</a>
                            </div>
                              <div class="form-group row">
                                 <div class="col-12" id="cityDisplayList">

                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <div class="text-end">
                     <button type="submit" class="btn  btn-block bg_button">Save Location</button>
                  </div>
               </div>
            </form>
            </div>
         </div>
      </div>
   </div>
   <script type="text/javascript">
    function cityStoreInSession()
    {
      var country = [];
      var state = [];
      var city = [];
      $('input.countrycheckbox:checkbox:checked').each(function () {
          console.log($(this).val());
          country.push($(this).val());
      });
      $('input.checkbox1:checkbox:checked').each(function () {
          state.push({
            country: $("span.selectedState").text(), 
            name:  $(this).val()
        });
      });
      $('input.checkbox2:checkbox:checked').each(function () {
          city.push({
            country: $("span.selectedState").text(), 
            state:  $("span.selectedCity").text(),
            name:  $(this).val()
        });
      });
      $.ajax({
        url: "{{ url('locationStoreInSession') }}",
        type: "POST",
        data: {
           _token: "{{csrf_token()}}",
           country: country,
           state: state,
           city: city,
        },
        success: function (res) {
          console.log(res)
        },
      });
    }

    function getDBCountryList(callback) {
      var country;
      $.ajax({
        url: "{{ url('getCountryListName') }}",
        dataType: "json",
        type: "GET",
        success: function (res) {
           country = res;
            callback(country);
        },
      });
    }

    function getDBStateList(country,callback) {
      var states;
      $.ajax({
        url: "{{ url('getStateListName') }}",
        type: "POST",
        data: {
           _token: "{{csrf_token()}}",
           country: country
        },
        success: function (res) {
          states = res;
          callback(states);
        },
      });
    }

    function getDBCityList(country, state ,callback) {
      var states;
      $.ajax({
        url: "{{ url('getCityListName') }}",
        type: "POST",
        data: {
           _token: "{{csrf_token()}}",
           country: country,
           state: state
        },
        success: function (res) {
          states = res;
          callback(states);
        },
      });
    }

      $("form#MasterDataLocationForm").submit(function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
            type: "POST",
            url: "{{ route('locationDataStore') }}",
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(response) {
              location.reload();
            },
            error: function(error) {
              console.log(error);
            }
          });
        });

    $(document).ready(function(){
      getDBCountryList(function(country) {
          $.ajax({
           url: "https://countriesnow.space/api/v0.1/countries/codes",
           type: 'Get',
           success: function (res) {
            $('#stateDisplayList').empty();
            $('#cityDisplayList').empty();
              $.each(res.data, function(key, value) {
                var ischecked = '';
                var bgclass = '';
                if(country.includes(value.name)){
                  ischecked = 'checked';
                  bgclass = 'companion_bg';
                }
                 $('#countryDisplayList').append($('<div class="form-check check_box '+bgclass+'">'+
                   '<label class="form-check-label countrylabel">'+ value.name +'</label>'+
                   '<input class="form-check-input countrycheckbox" type="checkbox" name="country['+key+'][country]" value="'+ value.name.trim() +'" id="'+ value.name.trim() +'"'+ischecked+'>'+
                   '</div>'));
              });
           },
        });
      });
   });
    /*========== Get State List =============*/
    $(document).on('click', '.countrylabel', function() {
      var country = $(this).text();
      var selectChecked = (this.checked ? 'checked' : '');
      getDBStateList(country, function(states) {
        $.ajax({
           url: "https://countriesnow.space/api/v0.1/countries/states",
           dataType: "json",
           type: "POST",
           data: {country: country},
           success: function(res) {
              $('.selectedState').empty();
              $('#stateDisplayList').empty();
              $('.selectedCity').empty();
              $('#cityDisplayList').empty();
              $('.selectedState').append(country);
              $.each(res.data.states, function(key, value) {
                var ischecked = '';
                var bgclass = '';
                if(states.includes(value.name.trim())){
                  ischecked = 'checked';
                  bgclass = 'companion_bg';
                }
                 $('#stateDisplayList').append($('<div class="form-check check_box '+bgclass+'">'+
                                         '<label class="form-check-label statelabel">'+ value.name.trim() +'</label>'+
                                         '<input class="form-check-input checkbox1" type="checkbox" name="state" value="'+ value.name.trim() +' "id="'+ value.name.trim() +'" '+ischecked+'>'+
                                         '</div>'));
              });
           }
        });
      });
   });
    $(document).on('click', '.countrycheckbox', function() {
    var checked = $(this).is(":checked");
    if (checked) {
      $(".checkbox1").each(function() {
        $(this).prop("checked", true);
      });
    } else {
      $(".checkbox1").each(function() {
        $(this).prop("checked", false);
      });
    }
  });
   /*========== Get City List =============*/
  $(document).on('click', '.statelabel', function() {
    var state = $(this).text();
    var country = $("span.selectedState").text();
    getDBCityList(country, state, function(cities) {
      $.ajax({
         url: "https://countriesnow.space/api/v0.1/countries/state/cities",
         dataType: "json",
         type: "POST",
         data: {country: country, state: state},
         success: function(res) {
            $('.selectedCity').empty();
            $('#cityDisplayList').empty();
            $('.selectedCity').append(state);
            $.each(res.data, function(key, value) {
              var ischecked = '';
              var bgclass = '';
              if(cities.includes(value)){
                ischecked = 'checked';
                bgclass = 'companion_bg';
              }
               $('#cityDisplayList').append($('<div class="form-check check_box">'+
                   '<label class="form-check-label '+bgclass+'">'+ value.trim() +'</label>'+
                   '<input class="form-check-input checkbox2" type="checkbox" name="cities[]" value="'+ value.trim() +'" '+ischecked+'>'+
                   '</div>'));
            });
         }
      });
    });
   });

  $(document).on('click', '.checkbox1', function() {
    var selectChecked = (this.checked ? 'checked' : '');
    var state = $(this).attr("id");
    var country = $("span.selectedState").text();
    getDBCityList(country, state, function(cities) {
      $.ajax({
          url: "https://countriesnow.space/api/v0.1/countries/state/cities",
         dataType: "json",
         type: "POST",
         data: {country: country, state: state},
         success: function(res) {
            $('.selectedCity').empty();
            $('#cityDisplayList').empty();
            $('.selectedCity').append(state);
            $.each(res.data, function(key, value) {
              var ischecked = '';
              if(cities.includes(value)){
                ischecked = 'checked';
              }
               $('#cityDisplayList').append($('<div class="form-check check_box">'+
                   '<label class="form-check-label">'+ value.trim() +'</label>'+
                   '<input class="form-check-input checkbox2" type="checkbox" name="cities[]" value="'+ value.trim() +'" '+selectChecked+'>'+
                   '</div>'));
            });
         }
      });
    });
  });
   
    // Select With Checkbox(Extra Feature)
  $("#checkall").change(function() {
    var checked = $(this).is(":checked");
    if (checked) {
      $(".countrycheckbox").each(function() {
        $(this).prop("checked", true);
      });
    } else {
      $(".countrycheckbox").each(function() {
        $(this).prop("checked", false);
      });
    }
  });


  // Select With Checkbox(Extra Feature)
  $("#checkall1").change(function() {
    var checked = $(this).is(":checked");
    if (checked) {
      $(".checkbox1").each(function() {
        $(this).prop("checked", true);
      });
    } else {
      $(".checkbox1").each(function() {
        $(this).prop("checked", false);
      });
    }
  });


   // Select With Checkbox(Extra Feature)
  $("#checkall2").change(function() {
    var checked = $(this).is(":checked");
    if (checked) {
      $(".checkbox2").each(function() {
        $(this).prop("checked", true);
      });
    } else {
      $(".checkbox2").each(function() {
        $(this).prop("checked", false);
      });
    }
  });
   </script> 
</x-app-layout>