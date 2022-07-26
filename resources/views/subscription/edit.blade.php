<x-app-layout>

    <div class="row">
        <div class="col-lg-12 createUserSection">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Add New Subscription</h3>
                    <div class="text-end"><button class="btn btn-outline-primary f16 createcategoryData"
                            onclick="hidecreateform();">
                            Subscription List</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('subscription.store') }}" enctype="multipart/form-data"
                        id="signup-user-form">
                        @csrf
                        <input type="hidden" name="id" id="subscription_id" />
                        <div class="row align-items-center">
                            <div class="col-md-4 card m-auto">
                                <div class="row card-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Plan Name * </label>
                                            <input type="text" class="form-control" name="plan_name" id="plan_name"
                                                placeholder="VVIP" value="{{ $subscription['plan_name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Features</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input input-warning" type="checkbox"
                                                name="portfolio" id="portfolio" value="1">
                                            <label class="form-check-label" for="portfolio">6 Image Portfolio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input input-warning" type="checkbox"
                                                name="calendar" id="calendar" value="1">
                                            <label class="form-check-label" for="calendar">Calendar Sync</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="available" id="available" value="1">
                                            <label class="form-check-label" for="available"> Available Now </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="long_bio" id="long_bio" value="1">
                                            <label class="form-check-label" for="long_bio"> Long Bio </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="profile_bg" id="profile_bg" value="1">
                                            <label class="form-check-label" for="profile_bg"> Profile Background Image
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="performance" id="performance" value="1">
                                            <label class="form-check-label" for="performance"> Performance Stats
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="account_data" id="account_data" value="1">
                                            <label class="form-check-label" for="account_data"> End of Year Account Data
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="liability" id="liability" value="1">
                                            <label class="form-check-label" for="liability"> Public Liability Insurance
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input input-warning"
                                                name="dbs_option" id="dbs_option" value="1">
                                            <label class="form-check-label" for="dbs_option"> Public Liability Insurance
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Monthly Price </label>
                                            <input type="text" class="form-control" name="monthly_price"
                                                id="monthly_price" placeholder="5.25">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"> Yearly Price </label>
                                            <input type="text" class="form-control" name="yearly_price"
                                                id="yearly_price" placeholder="50.50">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-block bg_button">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
