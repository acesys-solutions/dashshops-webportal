@php use Carbon\Carbon; @endphp
@extends('dashboard')


@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</style>
@endsection

@section('content')
<main>

    <div class="container-fluid" style="background-color: #efefef">
        <div class="row ml-5">
            <div class="col-md-2 col-sm-2 mt-3" style="margin-left: 4%; margin-right: 12%;">
                <div class="card justify-content-center" style="min-width: 150px; width: 250px">
                    <div class="card-body">
                        @include('partials.menu',['active'=>'products'])
                        <script type="text/javascript">
                            $(document).on('click', '.nav-pills li', function() {
                                $(".nav-pills li").removeClass("active");
                                $(this).addClass("active");
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 m-1">
                <div class="card justify-content-center mt-2 mb-2">

                    <div class="card-header text-center text-white font-weight-bold" style="background-color: #7AB91D">
                        <p style="font-size: 12px">Coupon Clicks</p>
                    </div>

                    <div class="card-body">
                        <img src="{{asset('images/clicks.png')}}" alt="downloads" width="90%" />
                    </div>
                    <div class="card-footer">
                        <h4 class="text-center" style="color: #7AB91D">{{ $total_clicks }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 m-1">
                <div class="card justify-content-center mt-2 mb-2">

                    <div class="card-header text-center text-white font-weight-bold" style="background-color: #00B7F9">
                        <p style="font-size: 11px">Coupon Downloads</p>
                    </div>

                    <div class="card-body">
                        <img src="{{asset('images/downloads.png')}}" alt="downloads" width="90%" />
                    </div>
                    <div class="card-footer">
                        <h4 class="text-center" style="color: #00B7F9">{{ $total_downloads }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 m-1">
                <div class="card justify-content-center mt-2 mb-2">

                    <div class="card-header text-center text-white font-weight-bold" style="background-color: #E58821">
                        <p style="font-size: 11px">Coupon Redeemed</p>
                    </div>

                    <div class="card-body">
                        <img src="{{asset('images/redeemed.png')}}" alt="downloads" width="90%" />
                    </div>
                    <div class="card-footer">
                        <h4 class="text-center" style="color: #E58821">{{ $total_redemptions }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 5%">

        <div class="row justify-content-center">

            <div class="col-md-12 col-sm-12">
                <div class="card mb-5">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">States</label>
                                    <select class="form-control" id="selectState" name="state">
                                        <option value="0">All</option>
                                        @foreach($states as $state)
                                        <option value="{{$state->name}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <?php

                            $approvalStatus =  [
                                ['name' => "Pending", 'value' => "Pending"],
                                [
                                    'name' => "Approved", 'value' => "Approved"
                                ],
                                [
                                    'name' => "Denied", 'value' => "Denied"
                                ],
                            ];
                            ?>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="cmbStatus">Status</label>
                                    <select class="form-control" id="cmbStatus" name="type">
                                        <option value="all">All</option>
                                        @foreach($approvalStatus as $offer)
                                        <option value="{{$offer['value']}}">{{$offer['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">States</label>
                                    <input class="form-control" id="txtSearch" placeholder="Search..." name="search" />
                                </div>
                            </div>

                            <div class="col-2">
                                {{ csrf_field() }}
                                <button type="button" onclick="hSearch()" class=" btn btn-primary mt-4">Search</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card" style="width:100%">

                <div class="card-body">
                    <div class="col-md-12 mb-5">
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                        @endif

                        <div id="divTableDrivers">

                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modelDriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="h5DriverName">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <img src="" id="imgDriver" style="width: 97%;height:200px;object-fit: cover;" />
                    </div>
                    <div class="col-8">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item mr-1" role="presentation">
                                <button class="nav-link active btn" id="btn-pills-home" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="showActive('pills-home')">Driver Info</button>
                            </li>
                            <li class="nav-item  mr-1" role="presentation">
                                <button class="nav-link btn" id="btn-pills-profile" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" onclick="showActive('pills-profile')">License</button>
                            </li>
                            <li class="nav-item mr-1" role="presentation">
                                <button class="nav-link btn" id="btn-pills-contact" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" onclick="showActive('pills-contact')">Car Registration</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn" id="btn-pills-bank" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-bank" aria-selected="false" onclick="showActive('pills-bank')">Bank Details</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Firstname</label>
                                            <input class="form-control" type="text" readonly id="txtFirstname" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Lastname</label>
                                            <input class="form-control" type="text" readonly id="txtLastname" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Email</label>
                                            <input class="form-control" type="text" readonly id="txtEmail" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Phone Number</label>
                                            <input class="form-control" type="text" readonly id="txtPhoneNumber" />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">City</label>
                                            <input class="form-control" type="text" readonly id="txtCity" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">State</label>
                                            <input class="form-control" type="text" readonly id="txtState" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cmbStatus">Address</label>
                                            <textarea class="form-control" type="text" readonly id="txtAddress"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">License Number</label>
                                            <input class="form-control" type="text" readonly id="txtLicenseNumber" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Expiry Date</label>
                                            <input class="form-control" type="text" readonly id="txtLicenseExpiry" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <a id="carLicenseFront"><img id="frontLicense" style="width: 97%;height:200px;object-fit: contain;" /></a>
                                    </div>
                                    <div class="col-6">
                                        <a id="carLicenseBack"><img id="backLicense" style="width: 97%;height:200px;object-fit: contain;" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Model</label>
                                            <input class="form-control" type="text" readonly id="txtCarModel" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Model Type</label>
                                            <input class="form-control" type="text" readonly id="txtCarModelType" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="cmbStatus">Color</label>
                                            <input class="form-control" type="text" readonly id="txtCarColor" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cmbStatus">Year</label>
                                            <input class="form-control" type="text" readonly id="txtCarYear" />
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="cmbStatus">Registration</label>
                                            <input class="form-control" type="text" readonly id="txtCarRegNumber" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <a id="carImgImage"><img id="carImage" style="width: 97%;height:100px;object-fit: contain;" /></a>
                                    </div>
                                    <div class="col-4">
                                        <a id="carImgFront"><img id="carFrontReg" style="width: 97%;height:100px;object-fit: contain;" /></a>
                                    </div>
                                    <div class="col-4">
                                        <a id="carImgBack"><img id="carBackReg" style="width: 97%;height:100px;object-fit: contain;" /></a>
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Beneficiary Name</label>
                                            <input class="form-control" type="text" readonly id="txtBankBeneficiary" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Bank Name</label>
                                            <input class="form-control" type="text" readonly id="txtBankName" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Account Number</label>
                                            <input class="form-control" type="text" readonly id="txtBankAccountNumber" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cmbStatus">Routing Number</label>
                                            <input class="form-control" type="text" readonly id="txtBankSwiftCode" />
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnDenyDriver" class="btn btn-danger"><i class="fas fa-thumbs-down"></i> Reject</button>
                <button type="button" id="btnApproveDriver"  class="btn btn-success"><i class="fas fa-thumbs-up"></i> Approve</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_js')

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('js/choices.min.js?'.time())}}"></script>
<script src="{{asset('js/driver-view.js?'.time())}}"></script>
<script src="{{asset('js/driver-approval.js?'.time())}}"></script>

@endsection