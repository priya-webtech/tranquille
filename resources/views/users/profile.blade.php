<x-app-layout>
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ url('/').'/'.asset(isset($user->avatar) ? $user->avatar : 'images/profile/profile.png') }}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">

                            </div>
                        </div>
                    </div>
                    <div class="profile-blog mb-5">
                        <div class="profile-personal-info">
                            <h4 class="text-primary mb-4">Personal Information</h4>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->firstname) ? $user->firstname : ''!!} {!! isset($user->lastname) ? $user->lastname : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->email) ? $user->email : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Phone Number<span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->mobile_code) ? $user->mobile_code : ''!!} {!! isset($user->phone_number) ? $user->phone_number : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Address <span class="pull-right">:</span>
                                    </h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->address) ? $user->address : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">Website <span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->website) ? $user->website : ''!!}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <h5 class="f-w-500">QRCode<span class="pull-right">:</span></h5>
                                </div>
                                <div class="col-8"><span>{!! isset($user->qrcode_image) ? $user->qrcode_image : '' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link show active">Friends</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link">Followings</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link ">Challange</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <div class="table-responsive">
                                            <table id="example" class="table display table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th>Amount</th>
                                                        <th>Transaction ID</th>
                                                        <th>Transaction Type</th>
                                                        <th>Transaction Date</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($user['transactions'])
                                                     @foreach($user['transactions'] as $row)
                                                    <tr>
                                                        <td>{!! $row->amount !!}</td>
                                                        <td>{!! $row->transaction_id !!}</td>
                                                        <td>{!! $row->transaction_type !!}</td>
                                                        <td>{!! $row->transaction_at !!}</td>
                                                        <td>{!! $row->description !!}</td>
                                                        <td><span class="badge light @if($row->status == 'succeeded') badge-success @else badge-danger @endif">{!! $row->status !!}</span></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="table-responsive">
                                        <table id="example1" class="table display table-responsive-md">
                                            <thead>
                                                <tr>
                                                    <th>Amount</th>
                                                    <th>Transaction ID</th>
                                                    <th>Transaction Type</th>
                                                    <th>Transaction Date</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($user['payments'])
                                                     @foreach($user['payments'] as $value)
                                                    <tr>
                                                        <td>{!! $value->amount !!}</td>
                                                        <td>{!! $value->transaction_id !!}</td>
                                                        <td>{!! $value->transaction_type !!}</td>
                                                        <td>{!! $value->transaction_at !!}</td>
                                                        <td>{!! $value->description !!}</td>
                                                        <td><span class="badge light @if($value->status == 'succeeded') badge-success @else badge-danger @endif">{!! $value->status !!}</span></td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="profile-settings" class="tab-pane fade ">
                                    <div class="pt-3">
                                        <div class="table-responsive">
                                            <table id="example2" class="table display table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th>Card Name</th>
                                                        <th>Card Number</th>
                                                        <th>Month</th>
                                                        <th>Year</th>
                                                        <th>Bank Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($user['cards'])
                                                         @foreach($user['cards'] as $card)
                                                        <tr>
                                                            <td>{!! $card->card_name !!}</td>
                                                            <td>{!! $card->card_number !!}</td>
                                                            <td>{!! $card->month !!}</td>
                                                            <td>{!! $card->year !!}</td>
                                                            <td>{!! $card->bank_name !!}</td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
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

</x-app-layout>

