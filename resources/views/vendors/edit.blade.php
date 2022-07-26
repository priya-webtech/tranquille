<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Vendor Edit', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                  <div class="card-header">
                           <h3 class="mb-0">Vendor Add</h3>
                        </div>
                <div class="modal-body">
                    {{-- <form method="PUT"  class="card-body" action="{{ route('vendors.update', encrypt($vendor->id)) }}" enctype="multipart/form-data"
                    id="storeCategoryData"> --}}
                    {!! Form::model($vendor, [
    'route' => ['vendors.update', encrypt($vendor->id)],
    'method' => 'PUT',
    'files' => true,
]) !!}
                    @csrf
                    {{-- <input type="hidden" name="_method" value="PUT"> --}}
                    {{-- <input type="hidden" name="id" id="vendor_id" /> --}}
                    <div class="row align-items-center">
                        <div class="form-group col-md-3">
                            <label>Saloon Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firm_name" id="firm_name"
                                value="{{ $vendorservice->firm_name }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firstname" id="firstname"
                                value="{{ $vendor->firstname }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lastname" id="lastname"
                                value="{{ $vendor->lastname }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="phone"
                                value="{{ $vendor->phone }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $vendor->email }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Website <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="website" id="website"
                                value="{{ $vendorservice->website }}">
                        </div>
                        {{-- <div class="form-group col-md-3">
                            <label>Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="country" id="country" value="{{ $vendorservice->country }}">
                        </div> --}}
                        
                        <div class="form-group col-md-3">
                            <label>Language <span class="text-danger">*</span></label>
                            <select class="form-control js-example-basic-single" multiple="multiple" name="language[]"
                                id="language" data-bs-toggle="dropdown" aria-expanded="false">
                                <option value="{{ $vendor['language'] }}">{{ $vendor['language'] }}</option> 
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
                                placeholder="Password">
                        </div>
                        <div class="col-md-12">
                              
                                <h4 class="p-l-0 mb-0">Service</h4>
                                <hr>
                              </div>
                        <div class="form-group col-md-3">
                            <label>Service <span class="text-danger">*</span></label>
                            <select class="form-control" name="service_id" id="service_id" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <option value="{{ $servicename['service_id'] }}">
                                    {{ $servicename['serviceinfo']['service_name'] }}
                                </option>
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
                                value="{{ $vendorservice->service_type }}">
                        </div>

                        <div class="col-md-12">
                              
                              <h4 class="p-l-0 mb-0">Address</h4>
                              <hr>
                            </div>

                        <div class="form-group col-md-3">
                            <label>Address 1<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address_line1" id="address_line1"
                                value="{{ $address->address_line1 }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Address 2 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address_line2" id="address_line2"
                                value="{{ $address->address_line2 }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Location Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="location_address" id="location_address"
                                value="{{ $address->location_address }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Country <span class="text-danger">*</span></label>
                            <select class="form-control" name="country" id="country" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <option value="{{ $vendor['country'] }}">{{ $vendor['country'] }}
                                </option>
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
                                value="{{ $address->latitude }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Longitude <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="longitude" id="longitude"
                                value="{{ $address->longitude }}">
                        </div> --}}
                        <div class="form-group col-md-3">
                            <label>State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" id="state"
                                value="{{ $address->state }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" id="city"
                                value="{{ $address->city }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Postcode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="postcode" id="postcode"
                                value="{{ $address->postcode }}">
                        </div>
                        <div class="col-md-12">
                              
                              <h4 class="p-l-0 mb-0">Why Choose You</h4>
                              <hr>
                            </div>
                        <div class="form-group col-md-3">
                            <label>Why Choose You <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="why_you" id="why_you"
                                value="{{ $vendorservice->why_you }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Logo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Image">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Demo Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image1" id="image1" placeholder="Image">
                        </div>

                        <div class="col-md-12">
                              
                              <h4 class="p-l-0 mb-0">Time</h4>
                              <hr>
                            </div>

                        <div class="form-group col-md-3">
                            <label>Time Monday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeMonStart" id="timeMonStart"
                                value="{{ $business->timeMonStart }}">
                        </div>
                        {{-- pc-timepicker-1 --}}
                        <div class="form-group col-md-3">
                            <label>Time Monday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeMonEnd" id="timeMonEnd"
                                value="{{ $business->timeMonEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayMondayStatus" id="dayMondayStatus" type="checkbox"
                                    value="{{ $business->dayMondayStatus }}"
                                    {{ $business->dayMondayStatus == 1 ? 'checked=checked' : 1 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Tuesday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeTueStart" id="timeTueStart"
                                value="{{ $business->timeTueStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Tuesday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeTueEnd" id="timeTueEnd"
                                value="{{ $business->timeTueEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayTuesdayStatus" id="dayTuesdayStatus" type="checkbox"
                                    value="{{ $business->dayTuesdayStatus }}"
                                    {{ $business->dayTuesdayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Wednesday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeWedStart" id="timeWedStart"
                                value="{{ $business->timeWedStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Wednesday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeWedEnd" id="timeWedEnd"
                                value="{{ $business->timeWedEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayWednesdayStatus" id="dayWednesdayStatus" type="checkbox"
                                    value="{{ $business->dayWednesdayStatus }}"
                                    {{ $business->dayWednesdayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Thursday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeThuStart" id="timeThuStart"
                                value="{{ $business->timeThuStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Thursday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeThuEnd" id="timeThuEnd"
                                value="{{ $business->timeThuEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayThursdayStatus" id="dayThursdayStatus" type="checkbox"
                                    value="{{ $business->dayThursdayStatus }}"
                                    {{ $business->dayThursdayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Friday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeFriStart" id="timeFriStart"
                                value="{{ $business->timeFriStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Fri End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeFriEnd" id="timeFriEnd"
                                value="{{ $business->timeFriEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayFridayStatus" id="dayFridayStatus" type="checkbox"
                                    value="{{ $business->dayFridayStatus }}"
                                    {{ $business->dayFridayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Saturday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeSatStart" id="timeSatStart"
                                value="{{ $business->timeSatStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Saturday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeSatEnd" id="timeSatEnd"
                                value="{{ $business->timeSatEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="daySaturdayStatus" id="daySaturdayStatus" type="checkbox"
                                    value="{{ $business->daySaturdayStatus }}"
                                    {{ $business->daySaturdayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Sunday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeSunStart" id="timeSunStart"
                                value="{{ $business->timeSunStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Sunday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeSunEnd" id="timeSunEnd"
                                value="{{ $business->timeSunEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="daySundayStatus" id="daySundayStatus" type="checkbox"
                                    value="{{ $business->daySundayStatus }}"
                                    {{ $business->daySundayStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="form-group col-md-3">
                            <label>Time Monday Friday Start <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeMonFriStart" id="timeMonFriStart"
                                value="{{ $business->timeMonFriStart }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Time Monday Friday End <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="timeMonFriEnd" id="timeMonFriEnd"
                                value="{{ $business->timeMonFriEnd }}">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input input-warning" class="form-control1"
                                    name="dayMonFriStatus" id="dayMonFriStatus" type="checkbox"
                                    value="{{ $business->dayMonFriStatus }}"
                                    {{ $business->dayMonFriStatus == 1 ? 'checked=checked' : 0 }}>
                                <label class="form-check-label">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        {{-- <div class="form-group col-md-3">
                            <label>Day Monday Friday Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="dayMonFriStatus" id="dayMonFriStatus" data-bs-toggle="dropdown" aria-expanded="false">
                                <option value="{{ $business->dayMonFriStatus }}">{{ $business->dayMonFriStatus }}
                                </option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div> --}}
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            // $('#language').val(data.language).change();
            $("#language").append($("<option selected = 'selected'></option>").val(data.language).html(data
                .language));
        });
    </script> --}}
</x-app-layout>
