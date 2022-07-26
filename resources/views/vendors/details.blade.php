<x-app-layout>
    @livewire('breadcrumb', ['title' => 'Vendor Details', 'breadcrumburl' => 'dashboard', 'breadcrumbtitle'=> 'Home'])

    <div class="container1">

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card table-card latest-activity-card b-radius">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">Vendors Details</h3>
                    </div>
                    <div class="user-profile1 user-card mb-4">
                        <div class="card-header border-0 p-0 pb-0">
                            <div class="cover-img-block">
                                @if (isset($demologo) && !empty($demologo))
                                    <img class="img-fluid bg_v"
                                        src="{{ url('/') . '/' . asset($demologo['demo_image']) }}" alt="User image">
                                @else
                                    <img class="img-fluid bg_v"
                                        src="{{ url('/') . '/' . asset('assets/images/cover.jpg') }}"
                                        alt="User image">
                                @endif
                            </div>
                        </div>

                        <div class="card-body py-0">
                            <div class="user-about-block m-0">
                                <div class="row">
                                    <div class="col-md-4 m-auto text-center mt-n5">
                                        <div class="change-profile text-center">
                                            <div class="dropdown w-auto d-inline-block">
                                                <a class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <div class="profile-dp">
                                                        <div class="position-relative d-inline-block">
                                                            @if (isset($vendor) && !empty($vendor))
                                                                <img class="img-radius w_i_100"
                                                                    src="{{ url('/') . '/' . asset($vendor['logo']) }}"
                                                                    alt="User image">
                                                            @else
                                                                <img class="img-radius w_i_100"
                                                                    src="{{ url('/') . '/' . asset('assets/image/dummy.png') }}"
                                                                    alt="User image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <h5 class="mb-1">
                                            {{ isset($vendor['firm_name']) ? $vendor['firm_name'] : '' }}</h5>
                                        <p class="mb-2 text-muted">UI/UX Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-0">
                                <div class="card-body user-profile m-0">
                                    <ul class="nav nav-tabs mb-3 justify-content-center profile-tabs" id="myTab"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab"
                                                href="#about-me" role="tab" aria-controls="about-me"
                                                aria-selected="true">Profile
                                                Detail
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="treatment-tab" data-bs-toggle="tab"
                                                href="#treatment" role="tab" aria-controls="treatment"
                                                aria-selected="false">Treatments Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="booking-tab" data-bs-toggle="tab"
                                                href="#booking" role="tab" aria-controls="booking"
                                                aria-selected="false">Booking Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="notification-tab"
                                                data-bs-toggle="tab" href="#notification" role="tab"
                                                aria-controls="notification" aria-selected="false">Notification
                                                Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="membership-tab" data-bs-toggle="tab"
                                                href="#membership" role="tab" aria-controls="membership"
                                                aria-selected="false">Membership Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="review-tab" data-bs-toggle="tab"
                                                href="#review" role="tab" aria-controls="review"
                                                aria-selected="false">Review Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="offer-tab" data-bs-toggle="tab"
                                                href="#offer" role="tab" aria-controls="offer"
                                                aria-selected="false">Offer Details</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="about-me" role="tabpanel"
                                            aria-labelledby="about-me-tab">
                                            <div id="about-me" class="tab-pane fade active show">

                                                <div class="profile-about-me">
                                                    <div class="pt-4 border-bottom-1 pb-3">
                                                        @if (isset($user) && !empty($user) && isset($vendor) && !empty($vendor))
                                                            <h3 class="text-dark mb-3">Profile Detail</h3>
                                                            <h4 class="text-primary mb-4">Personal Info</h4>
                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16.049" height="17.831"
                                                                                viewBox="0 0 16.049 17.831">
                                                                                <g id="Group_57852"
                                                                                    data-name="Group 57852"
                                                                                    transform="translate(-11.1 -10.1)">
                                                                                    <g id="user"
                                                                                        transform="translate(12 11)">
                                                                                        <path id="Path_2574"
                                                                                            data-name="Path 2574"
                                                                                            d="M18.25,20.344V18.562A3.562,3.562,0,0,0,14.687,15H7.562A3.562,3.562,0,0,0,4,18.562v1.781"
                                                                                            transform="translate(-4 -4.313)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.8" />
                                                                                        <circle id="Ellipse_304"
                                                                                            data-name="Ellipse 304"
                                                                                            cx="3.562" cy="3.562"
                                                                                            r="3.562"
                                                                                            transform="translate(3.562)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.8" />
                                                                                    </g>
                                                                                </g>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>User Name</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['firstname']) ? $user['firstname'] : '' }}
                                                                                    {{ isset($user['lastname']) ? $user['lastname'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="17.58" height="17.61"
                                                                                viewBox="0 0 17.58 17.61">
                                                                                <path id="Icon_feather-phone-call"
                                                                                    data-name="Icon feather-phone-call"
                                                                                    d="M13.078,4.564A3.83,3.83,0,0,1,16.1,7.59M13.078,1.5a6.894,6.894,0,0,1,6.09,6.082M18.4,13.694v2.3a1.532,1.532,0,0,1-1.67,1.532,15.159,15.159,0,0,1-6.61-2.352,14.937,14.937,0,0,1-4.6-4.6A15.159,15.159,0,0,1,3.174,3.936,1.532,1.532,0,0,1,4.7,2.266H7A1.532,1.532,0,0,1,8.528,3.583a9.835,9.835,0,0,0,.536,2.152A1.532,1.532,0,0,1,8.72,7.352l-.973.973a12.256,12.256,0,0,0,4.6,4.6l.973-.973a1.532,1.532,0,0,1,1.616-.345,9.835,9.835,0,0,0,2.152.536A1.532,1.532,0,0,1,18.4,13.694Z"
                                                                                    transform="translate(-2.417 -0.672)"
                                                                                    fill="none" stroke="#fda868"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="1.5" />
                                                                            </svg>

                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Phone Number</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['phone']) ? $user['phone'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="17.795" height="14.3"
                                                                                viewBox="0 0 17.795 14.3">
                                                                                <g id="Icon_feather-mail"
                                                                                    data-name="Icon feather-mail"
                                                                                    transform="translate(-2.455 -5.25)">
                                                                                    <path id="Path_25218"
                                                                                        data-name="Path 25218"
                                                                                        d="M4.6,6H17.4A1.6,1.6,0,0,1,19,7.6v9.6a1.6,1.6,0,0,1-1.6,1.6H4.6A1.6,1.6,0,0,1,3,17.2V7.6A1.6,1.6,0,0,1,4.6,6Z"
                                                                                        transform="translate(0.5)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                    <path id="Path_25219"
                                                                                        data-name="Path 25219"
                                                                                        d="M18.543,9l-7.771,5.44L3,9"
                                                                                        transform="translate(0.5 -1.24)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                </g>
                                                                            </svg>

                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Email</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['email']) ? $user['email'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="15.912" height="19.115"
                                                                                viewBox="0 0 15.912 19.115">
                                                                                <g id="Group_57972"
                                                                                    data-name="Group 57972"
                                                                                    transform="translate(-1219.25 -861.25)">
                                                                                    <g id="Icon_feather-map-pin"
                                                                                        data-name="Icon feather-map-pin"
                                                                                        transform="translate(1220 862)">
                                                                                        <path id="Path_25374"
                                                                                            data-name="Path 25374"
                                                                                            d="M18.912,8.706c0,5.6-7.206,10.409-7.206,10.409S4.5,14.311,4.5,8.706a7.206,7.206,0,1,1,14.412,0Z"
                                                                                            transform="translate(-4.5 -1.5)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.5" />
                                                                                        <path id="Path_25375"
                                                                                            data-name="Path 25375"
                                                                                            d="M18.3,12.9a2.4,2.4,0,1,1-2.4-2.4A2.4,2.4,0,0,1,18.3,12.9Z"
                                                                                            transform="translate(-8.696 -5.696)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.5" />
                                                                                    </g>
                                                                                </g>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Location</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($address['location_address']) ? $address['location_address'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="15.912" height="19.115"
                                                                                viewBox="0 0 15.912 19.115">
                                                                                <g id="Group_57972"
                                                                                    data-name="Group 57972"
                                                                                    transform="translate(-1219.25 -861.25)">
                                                                                    <g id="Icon_feather-map-pin"
                                                                                        data-name="Icon feather-map-pin"
                                                                                        transform="translate(1220 862)">
                                                                                        <path id="Path_25374"
                                                                                            data-name="Path 25374"
                                                                                            d="M18.912,8.706c0,5.6-7.206,10.409-7.206,10.409S4.5,14.311,4.5,8.706a7.206,7.206,0,1,1,14.412,0Z"
                                                                                            transform="translate(-4.5 -1.5)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.5" />
                                                                                        <path id="Path_25375"
                                                                                            data-name="Path 25375"
                                                                                            d="M18.3,12.9a2.4,2.4,0,1,1-2.4-2.4A2.4,2.4,0,0,1,18.3,12.9Z"
                                                                                            transform="translate(-8.696 -5.696)"
                                                                                            fill="none" stroke="#fda868"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.5" />
                                                                                    </g>
                                                                                </g>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Country</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['country']) ? $user['country'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="14.286" height="16.667"
                                                                                viewBox="0 0 14.286 16.667">
                                                                                <path id="Icon_metro-language"
                                                                                    data-name="Icon metro-language"
                                                                                    d="M10.852,12.229q-.009.028-.116,0t-.293-.107l-.186-.084a5.573,5.573,0,0,1-.809-.456q-.065-.047-.381-.293t-.353-.265A15.845,15.845,0,0,1,7.467,12.7a6.914,6.914,0,0,1-.977,1.023.737.737,0,0,1-.181.037.358.358,0,0,1-.172,0q.056-.037.763-.856.2-.223.8-1.07a13,13,0,0,0,.73-1.1q.158-.279.474-.916A7.249,7.249,0,0,0,9.234,9.1a7.643,7.643,0,0,0-1.023.307q-.074.019-.256.07l-.321.088a1.593,1.593,0,0,0-.158.046.158.158,0,0,0-.019.1.206.206,0,0,1-.009.088Q7.4,9.9,7.16,9.942a.75.75,0,0,1-.437,0,.392.392,0,0,1-.26-.2.473.473,0,0,1-.047-.214,1.8,1.8,0,0,1,.228-.046,2.777,2.777,0,0,0,.274-.056q.539-.149.977-.3.93-.326.949-.326a2.064,2.064,0,0,0,.4-.181,4.207,4.207,0,0,1,.409-.2q.084-.028.2-.074T9.988,8.3a.125.125,0,0,1,.056,0,1.058,1.058,0,0,1-.009.307,1.98,1.98,0,0,1-.116.251q-.116.233-.246.5t-.158.312A13.949,13.949,0,0,1,8.8,10.89l.6.26q.112.056.693.3l.628.26q.037.009.1.237a.7.7,0,0,1,.042.284ZM8.946,7.709a.377.377,0,0,1-.037.26.843.843,0,0,1-.465.353,1.493,1.493,0,0,1-.558.112.77.77,0,0,1-.456-.242.7.7,0,0,1-.167-.381l.009-.028a.4.4,0,0,0,.181.047.809.809,0,0,0,.246,0q.093-.019.539-.149a2.655,2.655,0,0,1,.512-.13.184.184,0,0,1,.2.158Zm6.492,1.2.586,2.111-1.293-.391ZM5.133,16.35l6.455-2.158v-9.6L5.133,6.761V16.35ZM16.675,13.4l.949.288L15.94,7.579l-.93-.288L13,12.276l.949.288.419-1.023,1.962.6ZM12,4.454l5.329,1.711V2.631Zm2.892,12.3,1.469.121-.5,1.488-.372-.614a6.9,6.9,0,0,1-2.567,1,4.458,4.458,0,0,1-.846.112H11.29a6.286,6.286,0,0,1-1.855-.363,6.176,6.176,0,0,1-1.707-.791.194.194,0,0,1-.074-.149.18.18,0,0,1,.046-.126.156.156,0,0,1,.121-.051.524.524,0,0,1,.167.07l.284.153.191.1a8.24,8.24,0,0,0,1.483.572,5.419,5.419,0,0,0,1.465.228,7.937,7.937,0,0,0,1.553-.135,7.666,7.666,0,0,0,1.46-.47q.14-.065.284-.144t.316-.177q.172-.1.265-.153ZM19.056,6.724V16.759l-7.2-2.288q-.13.056-3.488,1.186t-3.423,1.13a.168.168,0,0,1-.167-.121.072.072,0,0,0-.009-.028V6.612a.415.415,0,0,1,.037-.093.418.418,0,0,1,.186-.1q.986-.326,1.386-.465V2.38l5.19,1.842q.019,0,1.493-.512T16,2.7q1.465-.5,1.5-.5.186,0,.186.2V6.286Z"
                                                                                    transform="translate(-4.77 -2.203)"
                                                                                    fill="#fda868" />
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Language Preferred</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['language']) ? $user['language'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="17.5" height="19.278"
                                                                                viewBox="0 0 17.5 19.278">
                                                                                <g id="Icon_feather-calendar"
                                                                                    data-name="Icon feather-calendar"
                                                                                    transform="translate(-3.75 -2.25)">
                                                                                    <path id="Path_25225"
                                                                                        data-name="Path 25225"
                                                                                        d="M6.278,6H18.722A1.778,1.778,0,0,1,20.5,7.778V20.222A1.778,1.778,0,0,1,18.722,22H6.278A1.778,1.778,0,0,1,4.5,20.222V7.778A1.778,1.778,0,0,1,6.278,6Z"
                                                                                        transform="translate(0 -1.222)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                    <path id="Path_25226"
                                                                                        data-name="Path 25226"
                                                                                        d="M24,3V6.556"
                                                                                        transform="translate(-7.944)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                    <path id="Path_25227"
                                                                                        data-name="Path 25227"
                                                                                        d="M12,3V6.556"
                                                                                        transform="translate(-3.056)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                    <path id="Path_25228"
                                                                                        data-name="Path 25228"
                                                                                        d="M4.5,15h16"
                                                                                        transform="translate(0 -4.889)"
                                                                                        fill="none" stroke="#fda868"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="1.5" />
                                                                                </g>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Date of Birth</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($user['dob']) ? $user['dob'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row mb-2">
                                                                        <div class="col-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="18" height="18"
                                                                                viewBox="0 0 18 18">
                                                                                <path id="Path_27936"
                                                                                    data-name="Path 27936"
                                                                                    d="M177.812,168.808a9.01,9.01,0,1,0,6.361,2.639,9,9,0,0,0-6.361-2.639Zm3.738,11.223h0a20.745,20.745,0,0,0,0-4.446c2.522.506,3.977,1.468,3.977,2.223s-1.455,1.717-3.977,2.223Zm-3.738,5.491c-.755,0-1.717-1.455-2.223-3.977h0a20.75,20.75,0,0,0,4.446,0c-.506,2.522-1.468,3.977-2.223,3.977Zm0-5.143a20.723,20.723,0,0,1-2.432-.139,21.272,21.272,0,0,1,0-4.864,21.27,21.27,0,0,1,4.864,0,21.271,21.271,0,0,1,0,4.864,20.727,20.727,0,0,1-2.432.139Zm-7.714-2.572c0-.755,1.455-1.717,3.977-2.223h0a20.739,20.739,0,0,0,0,4.446c-2.522-.506-3.977-1.468-3.977-2.223Zm7.714-7.714c.755,0,1.717,1.455,2.223,3.977h0a20.74,20.74,0,0,0-4.446,0c.506-2.522,1.468-3.977,2.223-3.977Zm7.371,5.437h0a11.567,11.567,0,0,0-3.818-1.274,11.568,11.568,0,0,0-1.274-3.818,7.748,7.748,0,0,1,5.093,5.093Zm-9.648-5.093a11.563,11.563,0,0,0-1.274,3.818,11.564,11.564,0,0,0-3.818,1.274,7.747,7.747,0,0,1,5.093-5.093Zm-5.093,9.648a11.567,11.567,0,0,0,3.818,1.274,11.566,11.566,0,0,0,1.274,3.818,7.747,7.747,0,0,1-5.093-5.093Zm9.648,5.093h0a11.57,11.57,0,0,0,1.274-3.818,11.57,11.57,0,0,0,3.818-1.274,7.747,7.747,0,0,1-5.093,5.093Z"
                                                                                    transform="translate(-168.812 -168.808)"
                                                                                    fill="#fda868" />
                                                                            </svg>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <span>Website</span>
                                                                            <h5 class="f-w-500">
                                                                                <span>{{ isset($vendor['website']) ? $vendor['website'] : '' }}</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if (isset($vendor['about_us']) && !empty($vendor['about_us']))
                                                    <div class="profile-about-me">
                                                        <div class="pt-4 border-bottom-1 pb-3">
                                                            <h4 class="text-primary mb-4">About Us</h4>
                                                            <div class="row mb-2">
                                                                <div class="col-9">
                                                                    <span>
                                                                        {{ isset($vendor['about_us']) ? $vendor['about_us'] : '' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (isset($hours) && !empty($hours))
                                                    <div class="profile-about-me">
                                                        <div class="pt-4 border-bottom-1 pb-3">
                                                            <h4 class="text-primary mb-4">Business Hours</h4>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Monday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['dayMondayStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeMonStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeMonEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeMonStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeMonEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Tuesday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @if ($hours['dayTuesdayStatus'] == 1)
                                                                                <span
                                                                                    class="p-2 d-block">{{ $hours['timeTueStart'] }}
                                                                                    -
                                                                                    {{ $hours['timeTueEnd'] }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="disabled p-custom p-2">{{ $hours['timeTueStart'] }}
                                                                                    -
                                                                                    {{ $hours['timeTueEnd'] }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Wednesday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            @if ($hours['dayWednesdayStatus'] == 1)
                                                                                <span
                                                                                    class="p-2 d-block">{{ $hours['timeWedStart'] }}
                                                                                    -
                                                                                    {{ $hours['timeWedEnd'] }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="disabled p-custom p-2">{{ $hours['timeWedStart'] }}
                                                                                    -
                                                                                    {{ $hours['timeWedEnd'] }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Thursday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['dayThursdayStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeThuStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeThuEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeThuStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeThuEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Friday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['dayFridayStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeFriStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeFriEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeFriStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeFriEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Saturday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['daySaturdayStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeSatStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeSatEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeSatStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeSatEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Sunday<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['daySundayStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeSunStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeSunEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeSunStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeSunEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="row mb-2">
                                                                        <div class="col-12">
                                                                            <h5 class="f-w-500">Mon - Fri<span
                                                                                    class="pull-right">:</span>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="border b-radius">
                                                                                @if ($hours['dayMonFriStatus'] == 1)
                                                                                    <span
                                                                                        class="p-2 d-block">{{ $hours['timeMonFriStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeMonFriEnd'] }}</span>
                                                                                @else
                                                                                    <span
                                                                                        class="disabled p-custom p-2">{{ $hours['timeMonFriStart'] }}
                                                                                        -
                                                                                        {{ $hours['timeMonFriEnd'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="profile-about-me">
                                                    <div class="pt-4 border-bottom-1 pb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                @if ($demo->count() > 0)
                                                                    <h4 class="text-primary mb-4">Work Gallary</h4>
                                                                    <div class="profile-interest mb-5">
                                                                        <div class="row mt-4">
                                                                            @foreach ($demo as $row)
                                                                                <div
                                                                                    class="col-lg-2 col-xl-2 col-sm-2 col-2 int-col position-relative">
                                                                                    <img src="{{ url('/') . '/' . asset($row['demo_image']) }}"
                                                                                        alt=""
                                                                                        class="img-fluid rounded w-76">
                                                                                            <button type="button" class="border-0 p-0 bg-transparent set_v trash deletedemoGallery" value="{{encrypt($row->id)}}"> <i data-feather="x-circle"></i></button>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($product->count() > 0)
                                                                    <h4 class="text-primary mb-4">Products Brands</h4>
                                                                    <div class="settings-form">
                                                                        <div class="profile-news">
                                                                            <div class="row mt-4">
                                                                                @foreach ($product as $row)
                                                                                    <div
                                                                                        class="col-lg-2 col-xl-2 col-sm-2 col-2 int-col position-relative">
                                                                                        <img src="{{ url('/') . '/' . asset($row['productbrandinfo']['brand_image']) }}"
                                                                                            alt="image"
                                                                                            class="img-fluid rounded"
                                                                                            width="">
                                            <button type="button" class="border-0 p-0 bg-transparent set_v trash deleteProductBrand" value="{{encrypt($row->id)}}"> <i data-feather="x-circle"></i></button>

                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @if ($team->count() > 0)
                                                                <div class="col-md-6">
                                                                    <h4 class="text-primary mb-4">Team Members</h4>
                                                                    <div
                                                                        class="table-card latest-activity-card b-radius">
                                                                        <div class="card-body1">
                                                                            <div class="table-responsive">
                                                                                <table id="teammember-list-table"
                                                                                    class="table table-hover table-borderless"
                                                                                    width="100%">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="width:50px;">
                                                                                                no
                                                                                            </th>
                                                                                            <th>name</th>
                                                                                            <th>skill</th>
                                                                                            <th>action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade pt-4 border-bottom-1 pb-3" id="treatment"
                                            role="tabpanel" aria-labelledby="treatment-tab">
                                            <h3 class="text-dark  mb-3">Treatment Details</h3>
                                            <div class="accordion" id="accordionExample">
                                                @if (isset($service) && !empty($service))
                                                    @foreach ($service as $data)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#{{ 'a' . $loop->iteration }}"
                                                                    aria-expanded="true" aria-controls="collapseOne">
                                                                    <b>{{ isset($data['serviceinfo']['service_name']) ? $data['serviceinfo']['service_name'] : '' }}
                                                                        ({!! $treatmentcount !!})
                                                                    </b>
                                                                </button>
                                                            </h2>
                                                            <div id="{{ 'a' . $loop->iteration }}"
                                                                class="accordion-collapse collapse "
                                                                aria-labelledby="headingOne"
                                                                data-bs-parent="#accordionExample">
                                                                @if (isset($treatment) && !empty($treatment))
                                                                    @foreach ($treatment as $row)
                                                                        <div class="accordion-body">
                                                                            <div
                                                                                class="row align-items-center border-bottom mb-2">
                                                                                <div class="col-md-2">
                                                                                    <h5 class="mb-0">
                                                                                        {{ isset($row['treatmentinfo']['treatment_name']) ? $row['treatmentinfo']['treatment_name'] : '' }}
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <p class="mb-0">
                                                                                        {{ isset($row['description']) ? $row['description'] : '' }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-md-2 text-end">
                                                                                    <h5>$
                                                                                        {{ isset($row['price']) ? $row['price'] : '' }}
                                                                                    </h5>
                                                                                    <h5 class="text-suceess">save
                                                                                        {{ isset($row['discount']) ? $row['discount'] : '' }}
                                                                                        %</h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="booking" role="tabpanel"
                                            aria-labelledby="booking-tab">
                                            <div class="card">
                                                <div class="card-header border-0 pb-0">
                                                    <h3 class="text-dark"><span class="p-l-5">Booking
                                                            Details</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-card latest-activity-card b-radius">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="booking-list-table"
                                                                    class="table table-hover table-borderless"
                                                                    width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th> No</th>
                                                                            <th>user name</th>
                                                                            <th>saloon name</th>
                                                                            <th>treatment</th>
                                                                            <th>description</th>
                                                                            <th>date</th>
                                                                            <th>time</th>
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
                                        </div>
                                        <div class="tab-pane fade" id="notification" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="card">
                                                <div class="card-header border-0 pb-0">
                                                    <h3><span class="p-l-5">Notification Detail</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-card latest-activity-card b-radius">

                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="notification-list-table"
                                                                    class="table table-hover table-borderless"
                                                                    width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th> No</th>
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
                                        </div>
                                        <div class="tab-pane fade" id="membership" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="card">
                                                <div class="card-header border-0 pb-0">
                                                    <h3><span class="p-l-5">Membership Detail</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-card latest-activity-card b-radius">

                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="membership-list-table"
                                                                    class="table table-hover table-borderless"
                                                                    width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>plan Name</th>
                                                                            <th>Plan price</th>
                                                                            <th>Start Date</th>
                                                                            <th>End Date</th>
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
                                        </div>
                                        <div class="tab-pane fade" id="review" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="card">
                                                <div class="card-header border-0 pb-0">
                                                    <h3><span class="p-l-5">Review Details</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-card latest-activity-card b-radius">

                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="review-list-table"
                                                                    class="table table-hover table-borderless"
                                                                    width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th> No</th>
                                                                            <th>User</th>
                                                                            <th>booking id</th>
                                                                            {{-- <th>Treatment</th> --}}
                                                                            <th>rating</th>
                                                                            <th>review</th>
                                                                            {{-- <th>date</th> --}}
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
                                        </div>
                                        <div class="tab-pane fade" id="offer" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="card">
                                                <div class="card-header border-0 pb-0">
                                                    <h3><span class="p-l-5">Offer Details</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-card latest-activity-card b-radius">

                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="offer-list-table"
                                                                    class="table table-hover table-borderless"
                                                                    width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Vendor name</th>
                                                                            <th>Offer Title</th>
                                                                            <th>Discount</th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            var orderTable = $('#booking-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('vendorBooking') }}",
                    data: function(d) {
                        d.vendor_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                        "defaultContent": ''
                    },
                    {
                        data: 'saloonname',
                        name: 'saloonname',
                        "defaultContent": ''
                    },
                    {
                        data: 'treatmentinfo.treatment_name',
                        name: 'treatmentinfo.treatment_name',
                        "defaultContent": ''
                    },
                    {
                        data: 'statusinfo.status',
                        name: 'statusinfo.status',
                        "defaultContent": ''
                    },
                    {
                        data: 'booking_date',
                        name: 'booking_date',
                        "defaultContent": ''
                    },
                    {
                        data: 'booking_time',
                        name: 'booking_time',
                        "defaultContent": ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "defaultContent": ''
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#notification-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('vendorNotification') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
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
                        "defaultContent": ''
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#membership-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('vendorMembership') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'plan_id',
                        name: 'plan_id',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'subscriptioninfo.amount',
                        name: 'subscriptioninfo.amount',
                        "defaultContent": ''
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        "defaultContent": ''
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        "defaultContent": ''
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#review-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('vendorReview') }}",
                    data: function(d) {
                        d.user_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
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
                        data: 'booking_id',
                        name: 'booking_id',
                        "defaultContent": ''
                    },
                    // {
                    //     data: 'treatment_id',
                    //     name: 'treatment_id',
                    //     "defaultContent": '',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'ratings',
                        name: 'ratings',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'review',
                        name: 'review',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at',
                    //     "defaultContent": ''
                    // },
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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#teammember-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('teamMember') }}",
                    data: function(d) {
                        d.vendor_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        "defaultContent": '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'skills',
                        name: 'skills',
                        "defaultContent": ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "defaultContent": ''
                    },

                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var orderTable = $('#offer-list-table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "searching": false,
                "ordering": false,
                "bLengthChange": false,
                "retrieve": true,
                ajax: {
                    url: "{{ route('vendorOffer') }}",
                    data: function(d) {
                        d.vendor_id = "{{ $user['id'] }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        "defaultContent": '',
                        className: 'td-actions text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'vendor_id',
                        name: 'vendor_id',
                        "defaultContent": ''
                    },
                    {
                        data: 'offer',
                        name: 'offer',
                        "defaultContent": ''
                    },
                    {
                        data: 'discount',
                        name: 'discount',
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


        $('body').on('click', '.deleteBooking', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('booking') }}" + '/' + id,
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

        $('body').on('click', '.deleteNotification', function() {
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

        $('body').on('click', '.deleteTeam', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('deleteTeam') }}" + '/' + id,
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

        $('body').on('click', '.deletedemoGallery', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('deleteGallery') }}" + '/' + id,
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

        $('body').on('click', '.deleteProductBrand', function() {
            var id = $(this).attr("value");
            var token = $("meta[name='csrf-token']").attr("content");
            if (!confirm("Are You sure want to delete ?")) {
                return false;
            }
            $.ajax({
                url: "{{ url('deleteProduct') }}" + '/' + id,
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
    </script>
</x-app-layout>
