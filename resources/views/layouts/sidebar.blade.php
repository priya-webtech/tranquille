<!-- [ navigation menu ] start -->
    <nav class="pc-sidebar ">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ url('/dashboard')}}" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="{{ url('/').'/'.asset('assets/image/logoFull.svg') }}" alt="" class="logo logo-lg">
                    <img src="{{ url('/').'/'.asset('assets/image/logosmall.svg') }}" alt="" class="logo logo-sm">
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/dashboard') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                          <path id="Icon_material-dashboard" data-name="Icon material-dashboard" d="M4.5,14.5h8V4.5h-8Zm0,8h8v-6h-8Zm10,0h8v-10h-8Zm0-18v6h8v-6Z" transform="translate(-4.5 -4.5)" fill="#fff"/>
                        </svg>
                        </span><span class="pc-mtext">Dashboard</span><!-- <span class="pc-arrow"><i data-feather="chevron-right"></i></span> --></a>
                        <!-- <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ url('/')}}">Sales</a></li>
                            <li class="pc-item"><a class="pc-link" href="dashboard-analytics.html">Analytics</a></li>
                        </ul> -->
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/booking') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="15.75" height="18" viewBox="0 0 15.75 18">
                            <path id="Icon_awesome-calendar-alt" data-name="Icon awesome-calendar-alt" d="M0,16.313A1.688,1.688,0,0,0,1.688,18H14.063a1.688,1.688,0,0,0,1.688-1.687V6.75H0ZM11.25,9.422A.423.423,0,0,1,11.672,9h1.406a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H11.672a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422h1.406a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H11.672a.423.423,0,0,1-.422-.422Zm-4.5-4.5A.423.423,0,0,1,7.172,9H8.578A.423.423,0,0,1,9,9.422v1.406a.423.423,0,0,1-.422.422H7.172a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422H8.578A.423.423,0,0,1,9,13.922v1.406a.423.423,0,0,1-.422.422H7.172a.423.423,0,0,1-.422-.422Zm-4.5-4.5A.423.423,0,0,1,2.672,9H4.078a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H2.672a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422H4.078a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H2.672a.423.423,0,0,1-.422-.422ZM14.063,2.25H12.375V.563A.564.564,0,0,0,11.813,0H10.688a.564.564,0,0,0-.562.563V2.25h-4.5V.563A.564.564,0,0,0,5.063,0H3.938a.564.564,0,0,0-.562.563V2.25H1.688A1.688,1.688,0,0,0,0,3.938V5.625H15.75V3.938A1.688,1.688,0,0,0,14.063,2.25Z" fill="#fff"/>
                          </svg>
                        </span><span class="pc-mtext">Booking</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/users') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt" d="M9,10.125A5.063,5.063,0,1,0,3.938,5.063,5.064,5.064,0,0,0,9,10.125Zm4.5,1.125H11.563a6.12,6.12,0,0,1-5.126,0H4.5A4.5,4.5,0,0,0,0,15.75v.563A1.688,1.688,0,0,0,1.688,18H16.313A1.688,1.688,0,0,0,18,16.313V15.75A4.5,4.5,0,0,0,13.5,11.25Z" fill="#fff"/>
                          </svg>
                    </span><span class="pc-mtext">Users List</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/approval') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18.205" viewBox="0 0 18 18.205">
                      <g id="Group_54592" data-name="Group 54592" transform="translate(-62 -116.795)">
                        <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt" d="M13.5,11.25H11.563a6.12,6.12,0,0,1-5.126,0H4.5A4.5,4.5,0,0,0,0,15.75v.563A1.688,1.688,0,0,0,1.688,18H16.313A1.688,1.688,0,0,0,18,16.313V15.75A4.5,4.5,0,0,0,13.5,11.25Z" transform="translate(62 117)" fill="#fff"/>
                        <path id="Path_25589" data-name="Path 25589" d="M405.441,228.54l-1.884.071v-2.026a.562.562,0,0,0-.746-.533l-1.386.462a.592.592,0,0,0-.284.889l.782,1a4.311,4.311,0,1,0,2.416,3.874,4.236,4.236,0,0,0-.5-1.99l.96.675a.552.552,0,0,0,.853-.32l.391-1.422a.594.594,0,0,0-.6-.675Z" transform="translate(-328.824 -109.233)" fill="#fff"/>
                      </g>
                    </svg>
                    </span><span class="pc-mtext">Approval List</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/vendors') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt" d="M9,10.125A5.063,5.063,0,1,0,3.938,5.063,5.064,5.064,0,0,0,9,10.125Zm4.5,1.125H11.563a6.12,6.12,0,0,1-5.126,0H4.5A4.5,4.5,0,0,0,0,15.75v.563A1.688,1.688,0,0,0,1.688,18H16.313A1.688,1.688,0,0,0,18,16.313V15.75A4.5,4.5,0,0,0,13.5,11.25Z" fill="#fff"/>
                          </svg>
                    </span><span class="pc-mtext">Vendors List</span></a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/service') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="16.798" height="14.573" viewBox="0 0 16.798 14.573">
                            <path id="Path_27938" data-name="Path 27938" d="M159.214,186.388a1.806,1.806,0,1,1-1.806,1.806,1.807,1.807,0,0,1,1.806-1.806Zm13.165,3.634h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm0,5.459h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm-13.165-3.634a1.806,1.806,0,1,1-1.806,1.806A1.807,1.807,0,0,1,159.214,191.846Zm13.165,9.093h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm-13.165-3.634a1.806,1.806,0,1,1-1.806,1.806A1.807,1.807,0,0,1,159.214,197.306Z" transform="translate(-157.408 -186.367)" fill="#fff"/>
                          </svg>
                    </span><span class="pc-mtext">Services</span></a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/treatments') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="16.798" height="14.573" viewBox="0 0 16.798 14.573">
                            <path id="Path_27938" data-name="Path 27938" d="M159.214,186.388a1.806,1.806,0,1,1-1.806,1.806,1.807,1.807,0,0,1,1.806-1.806Zm13.165,3.634h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm0,5.459h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm-13.165-3.634a1.806,1.806,0,1,1-1.806,1.806A1.807,1.807,0,0,1,159.214,191.846Zm13.165,9.093h-9.2a1.827,1.827,0,0,1,0-3.655h9.2a1.827,1.827,0,0,1,0,3.655Zm-13.165-3.634a1.806,1.806,0,1,1-1.806,1.806A1.807,1.807,0,0,1,159.214,197.306Z" transform="translate(-157.408 -186.367)" fill="#fff"/>
                          </svg>
                        </span><span class="pc-mtext">Treatments</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/product') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="15.75" height="18" viewBox="0 0 15.75 18">
                          <path id="Icon_awesome-calendar-alt" data-name="Icon awesome-calendar-alt" d="M0,16.313A1.688,1.688,0,0,0,1.688,18H14.063a1.688,1.688,0,0,0,1.688-1.687V6.75H0ZM11.25,9.422A.423.423,0,0,1,11.672,9h1.406a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H11.672a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422h1.406a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H11.672a.423.423,0,0,1-.422-.422Zm-4.5-4.5A.423.423,0,0,1,7.172,9H8.578A.423.423,0,0,1,9,9.422v1.406a.423.423,0,0,1-.422.422H7.172a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422H8.578A.423.423,0,0,1,9,13.922v1.406a.423.423,0,0,1-.422.422H7.172a.423.423,0,0,1-.422-.422Zm-4.5-4.5A.423.423,0,0,1,2.672,9H4.078a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H2.672a.423.423,0,0,1-.422-.422Zm0,4.5a.423.423,0,0,1,.422-.422H4.078a.423.423,0,0,1,.422.422v1.406a.423.423,0,0,1-.422.422H2.672a.423.423,0,0,1-.422-.422ZM14.063,2.25H12.375V.563A.564.564,0,0,0,11.813,0H10.688a.564.564,0,0,0-.562.563V2.25h-4.5V.563A.564.564,0,0,0,5.063,0H3.938a.564.564,0,0,0-.562.563V2.25H1.688A1.688,1.688,0,0,0,0,3.938V5.625H15.75V3.938A1.688,1.688,0,0,0,14.063,2.25Z" fill="#fff"/>
                        </svg>
                        </span><span class="pc-mtext">Product</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/offer') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18.479" viewBox="0 0 18 18.479">
                          <g id="Group_54509" data-name="Group 54509" transform="translate(-2.012 -1.75)">
                            <g id="Hotel" transform="translate(2.012 1.75)">
                              <path id="Path_25540" data-name="Path 25540" d="M18.723,8.74H3.3l0,10.847a.642.642,0,0,0,.643.643H9.084a.643.643,0,0,0,.643-.643V17.98H12.3v1.607a.643.643,0,0,0,.643.643h5.142a.643.643,0,0,0,.643-.643ZM8.112,15.8a.377.377,0,0,1-.376.377H5.975A.377.377,0,0,1,5.6,15.8V14.222a.377.377,0,0,1,.376-.377H7.736a.377.377,0,0,1,.376.377Zm0-3.572a.377.377,0,0,1-.376.377H5.975a.377.377,0,0,1-.376-.377V10.649a.377.377,0,0,1,.376-.377H7.736a.377.377,0,0,1,.376.377ZM12.269,15.8a.377.377,0,0,1-.377.377H10.131a.378.378,0,0,1-.377-.377V14.222a.378.378,0,0,1,.377-.377h1.761a.377.377,0,0,1,.377.377Zm0-3.572a.377.377,0,0,1-.377.377H10.131a.378.378,0,0,1-.377-.377V10.649a.378.378,0,0,1,.377-.377h1.761a.377.377,0,0,1,.377.377ZM16.423,15.8a.377.377,0,0,1-.377.377H14.285a.377.377,0,0,1-.376-.377V14.222a.377.377,0,0,1,.376-.377h1.762a.377.377,0,0,1,.377.377Zm0-3.572a.377.377,0,0,1-.377.377H14.285a.377.377,0,0,1-.376-.377V10.649a.377.377,0,0,1,.376-.377h1.762a.377.377,0,0,1,.377.377ZM20.012,4.87l0,1.942a.643.643,0,0,1-.643.642H2.655a.643.643,0,0,1-.643-.643l0-1.942s-.026-.535.643-.642H6.688a5.008,5.008,0,0,1,8.642,0h4.04a.647.647,0,0,1,.642.643Z" transform="translate(-2.012 -1.75)" fill="#fff"/>
                            </g>
                          </g>
                        </svg>
                    </span><span class="pc-mtext">Offer</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/membership') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                            <path id="Icon_awesome-crown" data-name="Icon awesome-crown" d="M16.5,14H3.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h13a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,16.5,14Zm2-10A1.5,1.5,0,0,0,17,5.5a1.47,1.47,0,0,0,.138.619L14.875,7.475a1,1,0,0,1-1.381-.363L10.947,2.656a1.5,1.5,0,1,0-1.894,0L6.506,7.112a1,1,0,0,1-1.381.363L2.866,6.119A1.5,1.5,0,1,0,1.5,7a1.532,1.532,0,0,0,.241-.025L4,13H16l2.259-6.025A1.532,1.532,0,0,0,18.5,7a1.5,1.5,0,1,0,0-3Z" fill="#fff"/>
                          </svg>
                        </span><span class="pc-mtext">Membership </span></a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/notification') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="15.535" height="17.754" viewBox="0 0 15.535 17.754">
                            <path id="Icon_awesome-bell" data-name="Icon awesome-bell" d="M7.768,17.754a2.219,2.219,0,0,0,2.218-2.219H5.549A2.219,2.219,0,0,0,7.768,17.754Zm7.469-5.191c-.67-.72-1.924-1.8-1.924-5.35a5.476,5.476,0,0,0-4.437-5.38V1.11a1.109,1.109,0,1,0-2.218,0v.723a5.476,5.476,0,0,0-4.437,5.38c0,3.547-1.254,4.63-1.924,5.35a1.083,1.083,0,0,0-.3.753,1.111,1.111,0,0,0,1.113,1.11H14.422a1.11,1.11,0,0,0,1.113-1.11A1.083,1.083,0,0,0,15.237,12.563Z" transform="translate(0)" fill="#fff"/>
                          </svg>
                        </span><span class="pc-mtext">Notifications</span></a>
                        <!-- <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="form_elements.html">Form Basic</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_basic.html">Form Options</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_input_group.html">Input Groups</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_checkbox.html">Checkbox</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_radio.html">Radio</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_switch.html">Switch</a></li>
                            <li class="pc-item"><a class="pc-link" href="form2_megaoption.html">Mega option</a></li>
                        </ul> -->
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/contactus') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="17.072" height="17.072" viewBox="0 0 17.072 17.072">
                            <g id="Icon_feather-help-circle" data-name="Icon feather-help-circle" transform="translate(-2.25 -2.25)">
                              <path id="Path_27945" data-name="Path 27945" d="M18.572,10.786A7.786,7.786,0,1,1,10.786,3,7.786,7.786,0,0,1,18.572,10.786Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                              <path id="Path_27946" data-name="Path 27946" d="M13.635,12.054a2.336,2.336,0,0,1,4.539.779c0,1.557-2.336,2.336-2.336,2.336" transform="translate(-5.115 -3.604)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                              <path id="Path_27947" data-name="Path 27947" d="M18,25.5h0" transform="translate(-7.214 -10.821)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            </g>
                          </svg>
                        </span><span class="pc-mtext">Support</span></a>

                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/country') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="17.999" height="16.645" viewBox="0 0 17.999 16.645">
                      <path id="Path_25538" data-name="Path 25538" d="M180.609,179.667a1.662,1.662,0,0,0-.2-.242,1.537,1.537,0,0,0-.242-.2,1.582,1.582,0,0,0-.91-.28H164.522a1.59,1.59,0,0,0-.91.28,1.535,1.535,0,0,0-.242.2,1.631,1.631,0,0,0-.48,1.15v9.2h0a1.636,1.636,0,0,0,1.632,1.632h3.63v3.43a.746.746,0,0,0,.738.754.729.729,0,0,0,.42-.124l2.216-1.566h0a.728.728,0,0,1,.85,0l2.086,1.524a.713.713,0,0,0,.426.142.746.746,0,0,0,.74-.754v-3.4h3.63a1.636,1.636,0,0,0,1.632-1.642v-9.2a1.633,1.633,0,0,0-.28-.9Zm-.92,10.1a.438.438,0,0,1-.432.432H164.522a.438.438,0,0,1-.432-.432v-2.154h15.6Zm-6.492-6.154h-7.589a.6.6,0,0,1,0-1.2h7.6a.6.6,0,0,1,0,1.2Zm-7.589.8h3.8a.6.6,0,1,1,0,1.2h-3.8a.6.6,0,1,1,0-1.2Z" transform="translate(-162.89 -178.945)" fill="#fff"/>
                    </svg>
                    </span><span class="pc-mtext">Country</span></a>

                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/status') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="16.498" height="16.499" viewBox="0 0 16.498 16.499">
                          <path id="Exclusion_5" data-name="Exclusion 5" d="M18102,6542.249a8.249,8.249,0,1,1,8.25-8.249A8.188,8.188,0,0,1,18102,6542.249Zm.064-5.067a1.088,1.088,0,0,0-.9.381,1.3,1.3,0,0,0-.4.991,1.254,1.254,0,0,0,.4.977,1.105,1.105,0,0,0,.9.368,1.175,1.175,0,0,0,.914-.368,1.233,1.233,0,0,0,.412-.977,1.293,1.293,0,0,0-.4-.991A1.146,1.146,0,0,0,18102.064,6537.181Zm0-9.181a1.318,1.318,0,0,0-.863.282,1.046,1.046,0,0,0-.346.85v5.623a1.069,1.069,0,0,0,.346.859,1.245,1.245,0,0,0,.863.3,1.21,1.21,0,0,0,.85-.3,1.094,1.094,0,0,0,.328-.859v-5.623a1.069,1.069,0,0,0-.328-.85A1.28,1.28,0,0,0,18102.064,6528Z" transform="translate(-18093.752 -6525.75)" fill="#fff"/>
                        </svg></span><span class="pc-mtext">Status</span></a>

                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/subscription') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                            <path id="Icon_awesome-crown" data-name="Icon awesome-crown" d="M16.5,14H3.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h13a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,16.5,14Zm2-10A1.5,1.5,0,0,0,17,5.5a1.47,1.47,0,0,0,.138.619L14.875,7.475a1,1,0,0,1-1.381-.363L10.947,2.656a1.5,1.5,0,1,0-1.894,0L6.506,7.112a1,1,0,0,1-1.381.363L2.866,6.119A1.5,1.5,0,1,0,1.5,7a1.532,1.532,0,0,0,.241-.025L4,13H16l2.259-6.025A1.532,1.532,0,0,0,18.5,7a1.5,1.5,0,1,0,0-3Z" fill="#fff"/>
                          </svg>
                          </span><span class="pc-mtext">Subscription Plan</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/feedback') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="17.496" height="16.68" viewBox="0 0 17.496 16.68">
                            <g id="Path_27932" data-name="Path 27932" transform="translate(-9.998 -20.997)" fill="#fff">
                              <path d="M 14.59584331512451 37.17726516723633 C 14.26580715179443 37.17726516723633 13.95153427124023 37.07347869873047 13.68660926818848 36.87705993652344 C 13.21760368347168 36.54127883911133 12.9818811416626 35.95876693725586 13.08585357666016 35.39102554321289 L 13.70642375946045 31.81125450134277 C 13.72780323028564 31.68733406066895 13.68630313873291 31.56091499328613 13.59533309936523 31.4735050201416 L 10.96600818634033 28.93628311157227 C 10.54514598846436 28.53950309753418 10.39106941223145 27.92989540100098 10.57285213470459 27.38080787658691 C 10.7500524520874 26.82310104370117 11.23819160461426 26.41502380371094 11.81850242614746 26.33955574035645 L 15.45056343078613 25.81696510314941 C 15.57701301574707 25.79895401000977 15.68586349487305 25.72039413452148 15.74245357513428 25.60670471191406 L 17.36864280700684 22.34452438354492 C 17.6346435546875 21.82065582275391 18.16153335571289 21.49727439880371 18.74536323547363 21.49727439880371 C 19.32918357849121 21.49727439880371 19.85606384277344 21.82064437866211 20.12041282653809 22.34120559692383 L 21.74814414978027 25.60643577575684 C 21.80497360229492 25.72045516967773 21.91413307189941 25.79926490783691 22.04018402099609 25.81730461120605 L 25.67181968688965 26.33949661254883 C 26.25261116027832 26.41457557678223 26.74124336242676 26.82257270812988 26.91865158081055 27.38067245483398 C 27.10048866271973 27.92979431152344 26.94640731811523 28.53949737548828 26.52549934387207 28.93631172180176 L 23.89736366271973 31.47238540649414 C 23.80532264709473 31.5607852935791 23.76370239257812 31.68747520446777 23.78520393371582 31.81210517883301 L 24.40651321411133 35.39568328857422 C 24.50969314575195 35.95891571044922 24.27383804321289 36.54155349731445 23.8045825958252 36.87730407714844 C 23.53967094421387 37.07346343994141 23.22550010681152 37.17711639404297 22.89567756652832 37.17711639404297 C 22.89563751220703 37.17711639404297 22.8956241607666 37.17711639404297 22.89558410644531 37.17711639404297 C 22.64551544189453 37.17709350585938 22.39689064025879 37.11484909057617 22.17626762390137 36.9970588684082 L 18.92716407775879 35.30608367919922 C 18.87166404724121 35.27725601196289 18.80889320373535 35.26192474365234 18.74597358703613 35.26192474365234 C 18.68305397033691 35.26192474365234 18.62028312683105 35.27725601196289 18.564453125 35.30625534057617 L 15.31535339355469 36.99700164794922 C 15.09468078613281 37.11494827270508 14.84599018096924 37.17726516723633 14.59584331512451 37.17726516723633 Z" stroke="none"/>
                              <path d="M 18.74536323547363 21.99727249145508 C 18.35294342041016 21.99727249145508 17.99379348754883 22.21770477294922 17.81612396240234 22.56759262084961 L 16.1900634765625 25.82950210571289 C 16.06019401550293 26.09041213989258 15.8103141784668 26.27077484130859 15.52177238464355 26.31186294555664 L 11.88596343994141 26.83499336242676 C 11.49404335021973 26.88479232788086 11.16697311401367 27.15819358825684 11.0484733581543 27.53507232666016 C 10.92538261413574 27.90307235717773 11.0279541015625 28.30904388427734 11.31105422973633 28.57440376281738 L 13.9417839050293 31.11299324035645 C 14.15232276916504 31.3153133392334 14.24871253967285 31.60892295837402 14.19907379150391 31.89666366577148 L 13.57767295837402 35.48109436035156 C 13.50789260864258 35.86213302612305 13.66533279418945 36.24907302856445 13.98133277893066 36.47312164306641 C 14.30121994018555 36.71205902099609 14.73063278198242 36.74387359619141 15.08223342895508 36.55467224121094 L 18.33395385742188 34.86255264282227 C 18.59224319458008 34.72837448120117 18.89970397949219 34.72837448120117 19.15799331665039 34.86255264282227 L 22.40930366516113 36.55467224121094 C 22.76095390319824 36.7436637878418 23.19023323059082 36.71186065673828 23.51020431518555 36.47312164306641 C 23.82620239257812 36.24907302856445 23.9836540222168 35.86213302612305 23.91386413574219 35.48109436035156 L 23.29247283935547 31.89707374572754 C 23.24279403686523 31.6090030670166 23.3393440246582 31.31507301330566 23.55016326904297 31.11258316040039 L 26.18048286437988 28.57440376281738 C 26.46359252929688 28.30904388427734 26.566162109375 27.90306282043457 26.44307327270508 27.53507232666016 C 26.32444381713867 27.1579532623291 25.99699401855469 26.88449287414551 25.60476303100586 26.83499336242676 L 25.6047534942627 26.83499336242676 L 21.96935272216797 26.31227493286133 C 21.68069458007812 26.27095413208008 21.43073272705078 26.09049224853516 21.30066299438477 25.82950210571289 L 19.67460250854492 22.56759262084961 C 19.49692344665527 22.21770477294922 19.13777351379395 21.99727249145508 18.74536323547363 21.99727249145508 M 18.74536323547363 20.99727249145508 C 19.51846313476562 20.99727249145508 20.21617317199707 21.42549133300781 20.56622314453125 22.11481475830078 L 20.5695629119873 22.12145233154297 L 22.16939544677734 25.33075332641602 L 25.73998641967773 25.84415435791016 C 26.51033401489258 25.94529724121094 27.15811157226562 26.48664855957031 27.39442253112793 27.22689247131348 C 27.63510704040527 27.95808792114258 27.43011856079102 28.76899909973145 26.87078857421875 29.29794311523438 L 24.28874588012695 31.7895393371582 L 24.89842414855957 35.30599975585938 C 25.03465843200684 36.06079864501953 24.72125816345215 36.83435821533203 24.09869384765625 37.28167343139648 C 23.75251388549805 37.53675079345703 23.32574844360352 37.6771125793457 22.89561462402344 37.6771125793457 C 22.56464385986328 37.6771125793457 22.23555374145508 37.594970703125 21.94330978393555 37.43947601318359 L 18.74596214294434 35.77544403076172 L 15.54878807067871 37.43918609619141 C 15.25641822814941 37.59496307373047 14.92709159851074 37.67726135253906 14.59585380554199 37.67726135253906 C 14.1657772064209 37.67726135253906 13.73918151855469 37.53693771362305 13.3930835723877 37.28184509277344 C 12.77046203613281 36.83461761474609 12.45695114135742 36.06109237670898 12.59306335449219 35.30629730224609 L 13.20273971557617 31.78949546813965 L 10.62117576599121 29.2983570098877 C 10.06146049499512 28.76932144165039 9.856302261352539 27.9580020904541 10.09723663330078 27.22653007507324 C 10.33337211608887 26.48722839355469 10.98030662536621 25.94609069824219 11.74964714050293 25.84430313110352 L 15.32151222229004 25.33037567138672 L 16.92449378967285 22.11483383178711 C 17.27452278137207 21.42549133300781 17.97224426269531 20.99727249145508 18.74536323547363 20.99727249145508 Z" stroke="none" fill="#fda868"/>
                            </g>
                          </svg>
                          </span><span class="pc-mtext">Review </span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/payment') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                            <path id="Icon_awesome-crown" data-name="Icon awesome-crown" d="M16.5,14H3.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h13a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,16.5,14Zm2-10A1.5,1.5,0,0,0,17,5.5a1.47,1.47,0,0,0,.138.619L14.875,7.475a1,1,0,0,1-1.381-.363L10.947,2.656a1.5,1.5,0,1,0-1.894,0L6.506,7.112a1,1,0,0,1-1.381.363L2.866,6.119A1.5,1.5,0,1,0,1.5,7a1.532,1.532,0,0,0,.241-.025L4,13H16l2.259-6.025A1.532,1.532,0,0,0,18.5,7a1.5,1.5,0,1,0,0-3Z" fill="#fff"/>
                          </svg>
                          </span><span class="pc-mtext">Payment</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/language') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                            <path id="Icon_awesome-crown" data-name="Icon awesome-crown" d="M16.5,14H3.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h13a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,16.5,14Zm2-10A1.5,1.5,0,0,0,17,5.5a1.47,1.47,0,0,0,.138.619L14.875,7.475a1,1,0,0,1-1.381-.363L10.947,2.656a1.5,1.5,0,1,0-1.894,0L6.506,7.112a1,1,0,0,1-1.381.363L2.866,6.119A1.5,1.5,0,1,0,1.5,7a1.532,1.532,0,0,0,.241-.025L4,13H16l2.259-6.025A1.532,1.532,0,0,0,18.5,7a1.5,1.5,0,1,0,0-3Z" fill="#fff"/>
                          </svg>
                          </span><span class="pc-mtext">Language</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="{!! url('/reffer') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                            <path id="Icon_awesome-crown" data-name="Icon awesome-crown" d="M16.5,14H3.5a.5.5,0,0,0-.5.5v1a.5.5,0,0,0,.5.5h13a.5.5,0,0,0,.5-.5v-1A.5.5,0,0,0,16.5,14Zm2-10A1.5,1.5,0,0,0,17,5.5a1.47,1.47,0,0,0,.138.619L14.875,7.475a1,1,0,0,1-1.381-.363L10.947,2.656a1.5,1.5,0,1,0-1.894,0L6.506,7.112a1,1,0,0,1-1.381.363L2.866,6.119A1.5,1.5,0,1,0,1.5,7a1.532,1.532,0,0,0,.241-.025L4,13H16l2.259-6.025A1.532,1.532,0,0,0,18.5,7a1.5,1.5,0,1,0,0-3Z" fill="#fff"/>
                          </svg>
                          </span><span class="pc-mtext">Reffer & Earn</span></a>
                    </li>
                    {{-- <li class="pc-item">
                        <a href="{!! url('/blocked') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                      <path id="Icon_metro-blocked" data-name="Icon metro-blocked" d="M17.935,4.564A9,9,0,0,0,5.207,17.292,9,9,0,0,0,17.935,4.564Zm.386,6.364a6.713,6.713,0,0,1-1.25,3.909L7.662,5.428a6.747,6.747,0,0,1,10.659,5.5Zm-13.5,0a6.713,6.713,0,0,1,1.25-3.909l9.409,9.409a6.747,6.747,0,0,1-10.659-5.5Z" transform="translate(-2.571 -1.928)" fill="#fff"/>
                    </svg></span>
                    <span class="pc-mtext">Blocked User</span></a>
                    </li>
                    <li class="pc-item"><a href="{!! url('/companionblocked') !!}" class="pc-link n_bold"><span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                      <path id="Icon_metro-blocked" data-name="Icon metro-blocked" d="M17.935,4.564A9,9,0,0,0,5.207,17.292,9,9,0,0,0,17.935,4.564Zm.386,6.364a6.713,6.713,0,0,1-1.25,3.909L7.662,5.428a6.747,6.747,0,0,1,10.659,5.5Zm-13.5,0a6.713,6.713,0,0,1,1.25-3.909l9.409,9.409a6.747,6.747,0,0,1-10.659-5.5Z" transform="translate(-2.571 -1.928)" fill="#fff"/>
                    </svg></span><span class="pc-mtext">Blocked Companion</span></a></li> --}}
                </ul>
            </div>
        </div>
    </nav>
