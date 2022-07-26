<x-app-layout>
  <!-- [ breadcrumb ] start -->@livewire('breadcrumb', ['title' => 'User List', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-lg-3">
      <div class="card user-card user-card-1">
        <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab" data-bs-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile" aria-selected="true"> <span class="f-w-500">Companion</span> </a>
          <a class="nav-link list-group-item list-group-item-action" id="user-set-information-tab" data-bs-toggle="pill" href="#user-set-information" role="tab" aria-controls="user-set-information" aria-selected="false"> <span class="f-w-500">About Us</span> </a>
          <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab" data-bs-toggle="pill" href="#user-set-account" role="tab" aria-controls="user-set-account" aria-selected="false"> <span class="f-w-500">Privacy Policy</span> </a>
          <a class="nav-link list-group-item list-group-item-action" id="user-set-passwort-tab" data-bs-toggle="pill" href="#user-set-passwort" role="tab" aria-controls="user-set-passwort" aria-selected="false"> <span class="f-w-500">Safety Tips</span> </a>
          <a class="nav-link list-group-item list-group-item-action" id="user-set-email-tab" data-bs-toggle="pill" href="#user-set-email" role="tab" aria-controls="user-set-email" aria-selected="false"> <span class="f-w-500">Community Guidelines</span> </a>
        </div>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="tab-content" id="user-set-tabContent">
        <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel" aria-labelledby="user-set-profile-tab">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4>Companion</h4>
              <div class="text-end">
                <button type="submit" class="btn  btn-block bg_button">Save Companion</button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <h5>Personal Information</h5>
                <form method="POST" enctype="multipart/form-data" id="MasterDataForm"> @csrf
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Height <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="heights" value="{!! implode(',', $heights) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Body type <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="bodytypes" value="{!! implode(',', $bodytypes) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Languages <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="languages" value="{!! implode(',', $languages) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Cup size <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="cupsizes" value="{!! implode(',', $cupsizes) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Hair colour <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="haircolours" value="{!! implode(',', $haircolors) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="form-label">Ethnicity <span class="text-danger">*</span></label>
                      <input type="text" class="form-control p-4" name="ethnicity" value="{!! implode(',', $ethnicitys) !!}" data-role="tagsinput" /> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="text-end">
                      <button type="submit" class="btn  btn-block bg_button">Save Companion</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="user-set-information" role="tabpanel" aria-labelledby="user-set-information-tab">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4>About Us</h4>
            </div>
            <div class="card-body">
               <form method="POST" action="{{url('cmsPageStore')}}" id="MasterDataAboutForm" enctype="multipart/form-data"> @csrf
                <div class="row">
                  <input type="hidden" name="urlname" value="aboutus">
                  <input type="hidden" name="pagename" value="About Us">
                  <div class="col-md-12 dynamic-field" id="dynamic-field-1">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Heading</label>
                          <input type="text" id="field" class="form-control" name="heading" value="{{ isset($aboutus->heading) ? $aboutus->heading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Subheading</label>
                          <input type="text" id="field" class="form-control" name="subheading" value="{{ isset($aboutus->subheading) ? $aboutus->subheading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Paragraph</label>
                          <textarea type="text" class="form-control" name="paragraph" id="classic-editor" rows="4" cols="50" ckeditor="true">{!! isset($aboutus->paragraph) ? $aboutus->paragraph : '' !!}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="staresd">
                          <div class="imgup">
                            <h4><i class="fa fa-image"></i>Upload Photo</h4>
                            <input type="file" class="form-control" name="image"> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mt-3 append-buttons d-flex justify-content-end">
                    <div class="clearfix">
                      <button class="btn  btn-block bg_button" id="btn">Save Companion</button>
                    </div>
                  </div>
              </form>
            </div>
            <div class="card-footer text-end">
              <!-- <button class="btn  btn-block bg_button">Save Companion</button> -->
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="user-set-account" role="tabpanel" aria-labelledby="user-set-account-tab">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4>Privacy Policy</h4>
            </div>
            <div class="card-body">
               <form method="POST" id="MasterDataAboutForm" enctype="multipart/form-data"> @csrf
                <div class="row">
                  <input type="hidden" name="urlname" value="privacypolicy">
                  <input type="hidden" name="pagename" value="Privacy Policy">
                  <div class="col-md-12 dynamic-field" id="dynamic-field-1">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Heading</label>
                          <input type="text" id="field" class="form-control" name="heading" value="{{ isset($privacypolicy->heading) ? $privacypolicy->heading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Subheading</label>
                          <input type="text" id="field" class="form-control" name="subheading" value="{{ isset($privacypolicy->subheading) ? $privacypolicy->subheading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Paragraph</label>

                          <textarea type="text" class="form-control" name="paragraph" id="classic-editor2" ckeditor="true">{!! isset($privacypolicy->paragraph) ? $privacypolicy->paragraph : '' !!}</textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="staresd">
                          <div class="imgup">
                            <h4><i class="fa fa-image"></i>Upload Photo</h4>
                            <input type="file" class="form-control" name="image"> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mt-3 append-buttons d-flex justify-content-end">
                    <div class="clearfix">
                      <button class="btn  btn-block bg_button">Save Companion</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="user-set-passwort" role="tabpanel" aria-labelledby="user-set-passwort-tab">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4>Safety Tips</h4>
              <div class="text-end">
                <button type="submit" class="btn  btn-block bg_button">Save Companion</button>
              </div>
            </div>
            <div class="card-body">
               <form method="POST" id="MasterDataAboutForm" enctype="multipart/form-data"> @csrf
                <div class="row">
                  <input type="hidden" name="urlname" value="safety_tips">
                  <input type="hidden" name="pagename" value="Safety Tips">
                  <div class="col-md-12 dynamic-field" id="dynamic-field-1">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Heading</label>
                          <input type="text" id="field" class="form-control" name="heading" value="{{ isset($safetytips->heading) ? $safetytips->heading : ''}}"  /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Subheading</label>
                          <input type="text" id="field" class="form-control" name="subheading" value="{{ isset($safetytips->subheading) ? $safetytips->subheading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Paragraph</label>
                          <textarea type="text" class="form-control" name="paragraph" id="classic-editor3" ckeditor="true">{!! isset($safetytips->paragraph) ? $safetytips->paragraph : '' !!}</textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="staresd">
                          <div class="imgup">
                            <h4><i class="fa fa-image"></i>Upload Photo</h4>
                            <input type="file" class="form-control" name="image"> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mt-3 append-buttons d-flex justify-content-end">
                    <div class="clearfix">
                      <button class="btn  btn-block bg_button">Save Companion</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="user-set-email" role="tabpanel" aria-labelledby="user-set-email-tab">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4>Community Guidelines</h4>
              <div class="text-end">
                <button type="submit" class="btn  btn-block bg_button">Save Companion</button>
              </div>
            </div>
            <div class="card-body">
               <form method="POST" id="MasterDataAboutForm" enctype="multipart/form-data"> @csrf
                <div class="row">
                  <input type="hidden" name="urlname" value="guidelines">
                  <input type="hidden" name="pagename" value="Community Guidelines">
                  <div class="col-md-12 dynamic-field" id="dynamic-field-1">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Heading</label>
                          <input type="text" id="field" class="form-control" name="heading" value="{{ isset($guidelines->heading) ? $guidelines->heading : ''}}"/> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="field" class="form-label">Subheading</label>
                          <input type="text" id="field" class="form-control" name="subheading" value="{{ isset($guidelines->heading) ? $guidelines->heading : ''}}" /> 
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Paragraph</label>
                          <textarea type="text" class="form-control" name="paragraph" id="classic-editor4" ckeditor="true">{!! isset($guidelines->paragraph) ? $guidelines->paragraph : '' !!}</textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="staresd">
                          <div class="imgup">
                            <h4><i class="fa fa-image"></i>Upload Photo</h4>
                            <input type="file" class="form-control" name="image"> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mt-3 append-buttons d-flex justify-content-end">
                    <div class="clearfix">
                      <button class="btn  btn-block bg_button">Save Companion</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ sample-page ] end -->
  </div>

  <script src="{{ url('/').'/'.asset('assets/js/plugins/select2.full.min.js') }}"></script>
  <script src="{{ url('/').'/'.asset('assets/js/plugins/ckeditor.js') }}"></script>
  <script type="text/javascript">
    $(window).on('load', function() {
        $(function() {
            ClassicEditor.create(document.querySelector('#classic-editor'))
            .catch(error => {
                console.error(error);
            });

            ClassicEditor.create(document.querySelector('#classic-editor2'))
            .catch(error => {
                console.error(error);
            });

            ClassicEditor.create(document.querySelector('#classic-editor3'))
            .catch(error => {
                console.error(error);
            });

            ClassicEditor.create(document.querySelector('#classic-editor4'))
            .catch(error => {
                console.error(error);
            });
        });
    });
  </script>
  <script type="text/javascript">
  $("form#MasterDataForm").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      type: "POST",
      url: "{{ route('setting.store') }}",
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

  // $("form#MasterDataAboutForm").submit(function(e) {
  //   e.preventDefault();
  //   var formData = new FormData(this);
  //   console.log(formData);
  //   var formData = new FormData(this);
  //   $.ajax({
  //     type: "POST",
  //     url: "{{ route('cmsPageStore') }}",
  //     data: formData,
  //     dataType: "JSON",
  //     processData: false,
  //     contentType: false,
  //     success: function(response) {
  //       location.reload();
  //     },
  //     error: function(error) {
  //       console.log(error);
  //     }
  //   });
  // });
  </script>
  <script>
      $(function() {
          $(".skill-mlt-select").select2();
      });

      function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    $('.input-group').on('click', '.button-plus', function(e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
    });

  </script>
</x-app-layout>