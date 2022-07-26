<x-app-layout>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                font-family: Arial;
            }

            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }

            /* Style the buttons inside the tab */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #ddd;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #ccc;
            }

            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }

        </style>
    </head>

    <body>

        <h2>Vendor Details</h2>

        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'Address')">Address</button>
            <button class="tablinks" onclick="openCity(event, 'Service')">Service</button>
            <button class="tablinks" onclick="openCity(event, 'Treatment')">Treatment</button>
            <button class="tablinks" onclick="openCity(event, 'Product')">Product</button>
            <button class="tablinks" onclick="openCity(event, 'Team')">Team</button>
            <button class="tablinks" onclick="openCity(event, 'Demo')">Work Demo</button>
            <button class="tablinks" onclick="openCity(event, 'Booking')">Booking</button>
        </div>

        <div id="Address" class="tabcontent">
            <h3>Address</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>Address</th>
                                            <th>Location</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Postcode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $address->address_line1 }}</td>
                                            <td>{{ $address->location_address }}</td>
                                            <td>{{ $address->state }}</td>
                                            <td>{{ $address->city }}</td>
                                            <td>{{ $address->postcode }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Service" class="tabcontent">
            <h3>Service</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Discount</th>
                                            <th>Name</th>
                                            <th>Main Image</th>
                                            <th>Small Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['discount'] }}</td>
                                                <td>{{ $row['serviceinfo']['service_name'] }}</td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['serviceinfo']['service_image']) }}">
                                                </td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['serviceinfo']['small_image']) }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Treatment" class="tabcontent">
            <h3>Treatment</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Discount</th>
                                            <th>Main Image</th>
                                            <th>Small Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($treatment as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['treatmentinfo']['treatment_name'] }}</td>
                                                <td>{{ $row['description'] }}</td>
                                                <td>{{ $row['discount'] }}</td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['treatmentinfo']['treatment_image']) }}">
                                                </td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['treatmentinfo']['small_image']) }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Product" class="tabcontent">
            <h3>Product</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Brand Image</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['productbrandinfo']['brand_name'] }}</td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['productbrandinfo']['brand_image']) }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Team" class="tabcontent">
            <h3>Team</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Skills</th>
                                            <th>Image</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($team as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['employee_name'] }}</td>
                                                <td>{{ $row['designation'] }}</td>
                                                <td>{{ $row['skills'] }}</td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['profile_pic']) }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Demo" class="tabcontent">
            <h3>Demo</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Image</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($demo as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img width="10%" class="img-circle"
                                                        src="{{ url('/') . '/' . asset($row['demo_image']) }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Booking" class="tabcontent">
            <h3>Booking</h3>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ajax-category-datatable" class="display dataTable no-footer">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Skills</th>
                                            <th>Image</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($booking as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $row['employee_name'] }}</td>
                                            <td>{{ $row['designation'] }}</td>
                                            <td>{{ $row['skills'] }}</td>
                                            <td><img width="10%" class="img-circle" src="{{ url('/').'/'.asset($row['profile_pic']) }}"></td>
                                        </tr>
                                            @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }
        </script>

    </body>

    </html>

</x-app-layout>
