<x-app-layout>
   @livewire('breadcrumb', ['title' => 'Vendor Add', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

   <div class="row mt-5">
      <div class="col-md-12">
         <div class="">
            <!-- <div class="card-body">
                        <h3 class="mb-0">Vendor Add</h3>
                    </div> -->
            <div class="modal-body1">

               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-header">
                           <h3 class="mb-0">Vendor Add</h3>
                        </div>
                        <form class="card-body" method="POST" action="{{ route('vendors.store') }}"
                           enctype="multipart/form-data" id="storeCategoryData">
                           @csrf
                           <input type="hidden" name="id" id="vendor_id" />
                           <div class="row align-items-center">
                              <div class="form-group col-md-3">
                                 <label>Saloon Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="firm_name" id="firm_name"
                                    placeholder="Saloon Name">
                              </div>
                              <div class="form-group col-md-3">
                                 <label>First Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="firstname" id="firstname"
                                    placeholder="First Name" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Last Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="lastname" id="lastname"
                                    placeholder="Last Name" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Phone <span class="text-danger">*</span></label>
                                 <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone"
                                    required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Email <span class="text-danger">*</span></label>
                                 <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Website <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="website" id="website"
                                    placeholder="Website" required>
                              </div>
                              
                              <div class="form-group col-md-3">
                                 <label>Language <span class="text-danger">*</span></label>
                                 <select class="form-control js-example-basic-single new_s" multiple="multiple"
                                    name="language[]" id="language" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{-- <option>Select Language</option> --}}
                                    @foreach ($language as $data)
                                    <option value="{{ $data->name }}">
                                       {{ $data->name }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>

                              
                              <div class="col-md-12">
                              
                                <h4 class="p-l-0 mb-0">Password</h4>
                                <hr>
                              </div>

                              <div class="form-group col-md-3">
                                 <label>Password <span class="text-danger">*</span></label>
                                 <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password" required>
                              </div>

                              <div class="col-md-12">
                                <h4 class="p-l-0 mb-0">Service</h4>
                                <hr>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Service <span class="text-danger">*</span></label>
                                 <select class="form-control" name="service_id" id="service_id"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <option>Select Service</option>
                                    @foreach ($service as $data)
                                    <option value="{{ $data->id }}">
                                       {{ $data->service_name }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Service Type<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="service_type" id="service_type"
                                    placeholder="Service Type" required>
                              </div>

                              <div class="col-md-12">
                                <h4 class="p-l-0 mb-0">Address</h4>
                                <hr>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Address 1 <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="address_line1" id="address_line1"
                                    placeholder="Address 1" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Address 2 <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="address_line2" id="address_line2"
                                    placeholder="Address 2" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Location Address <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="location_address" id="location_address"
                                    placeholder="Location Address" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Country <span class="text-danger">*</span></label>
                                 <select class="form-control" name="country" id="country" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <option>Select Country</option>
                                    @foreach ($country as $data)
                                    <option value="{{ $data->country_name }}">
                                       {{ $data->country_name }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>
                              {{-- <div class="form-group col-md-3">
                                <label>Latitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    placeholder="Latitude" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Longitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                    placeholder="Longitude">
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>State <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="state" id="state" placeholder="State"
                                    required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>City <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="city" id="city" placeholder="City"
                                    required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Postcode <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="postcode" id="postcode"
                                    placeholder="Postcode" required>
                              </div>
                              <div class="col-md-12">
                                <h4 class="p-l-0 mb-0">Why Choose You</h4>
                                <hr>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Why Choose You <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="why_you" id="why_you"
                                    placeholder="Why Choose You" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Logo <span class="text-danger">*</span></label>
                                 <input type="file" class="form-control" name="image" id="image" placeholder="Image"
                                    required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Demo Image <span class="text-danger">*</span></label>
                                 <input type="file" class="form-control" name="image1" id="image1" placeholder="Image"
                                    required>
                              </div>


                              <div class="col-md-12">
                                <h4 class="p-l-0 mb-0">Time</h4>
                                <hr>
                              </div>

                              <div class="form-group col-md-3">
                                 <label>Time Monday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeMonStart" id="pc-timepicker-1"
                                    placeholder="12:00 PM" required>
                              </div>

                              {{-- <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Simple Input</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input class="form-control" id="pc-timepicker-1" type="text" />
                                </div>
                            </div> --}}

                              <div class="form-group col-md-3">
                                 <label>Time Monday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeMonEnd" id="timeMonEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Monday  <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayMondayStatus" id="dayMondayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayMondayStatus" id="dayMondayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              <div class="form-group col-md-3">
                                 <label>Time Tuesday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeTueStart" id="timeTueStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Tuesday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeTueEnd" id="timeTueEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayTuesdayStatus" id="dayTuesdayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Tuesday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayTuesdayStatus" id="dayTuesdayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Wednesday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeWedStart" id="timeWedStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Wednesday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeWedEnd" id="timeWedEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayWednesdayStatus" id="dayWednesdayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Wednesday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayWednesdayStatus" id="dayWednesdayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Thursday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeThuStart" id="timeThuStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Thursday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeThuEnd" id="timeThuEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayThursdayStatus" id="dayThursdayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Thursday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayThursdayStatus" id="dayThursdayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Friday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeFriStart" id="timeFriStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Fri End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeFriEnd" id="timeFriEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayFridayStatus" id="dayFridayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Friday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayFridayStatus" id="dayFridayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Saturday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeSatStart" id="timeSatStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Saturday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeSatEnd" id="timeSatEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="daySaturdayStatus" id="daySaturdayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Saturday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="daySaturdayStatus" id="daySaturdayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Sunday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeSunStart" id="timeSunStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Sunday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeSunEnd" id="timeSunEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="daySundayStatus" id="daySundayStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Sunday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="daySundayStatus" id="daySundayStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                              <div class="form-group col-md-3">
                                 <label>Time Monday Friday Start <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeMonFriStart" id="timeMonFriStart"
                                    placeholder="12:00 PM" required>
                              </div>
                              <div class="form-group col-md-3">
                                 <label>Time Monday Friday End <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="timeMonFriEnd" id="timeMonFriEnd"
                                    placeholder="10:00 PM" required>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-check">
                                    <input class="form-check-input input-warning" class="form-control1"
                                       name="dayMonFriStatus" id="dayMonFriStatus" value="1" type="checkbox">
                                    <label class="form-check-label">Status</label>
                                 </div>
                              </div>
                              <div class="col-md-3"></div>
                              {{-- <div class="form-group col-md-3">
                                <label>Day Monday Friday Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="dayMonFriStatus" id="dayMonFriStatus"
                                    data-bs-toggle="dropdown" aria-expanded="false" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div> --}}
                           </div>

                           <div class="card-footer p-0 pt-3">
                              <button type="submit" class="btn btn-primary">Submit</button>
                           </div>


                        </form>

                     </div>
                  </div>

               </div>




            </div>
         </div>
      </div>
   </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




</x-app-layout>