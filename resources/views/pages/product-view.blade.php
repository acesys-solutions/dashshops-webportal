@php use Carbon\Carbon; @endphp
@extends('dashboard')


@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</style>

<style>
    .avatar-xxl {
        width: 110px !important;
        height: 110px !important;
    }

    .avatar {
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        border-radius: 0.75rem;
        height: 48px;
        width: 48px;
        transition: all 0.2s ease-in-out;
    }

    .me-2 {
        margin-right: 0.5rem !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .position-relative {
        position: relative !important;
    }

    .avatar img {
        width: 100%;
    }

    .border-radius-md {
        border-radius: 0.5rem;
    }
</style>
@endsection

<?php
$bEdit = false;
?>
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
            <div id="divImages" style="display:none">{{$product->images ?? "[]"}}</div>

            <div class="row mt-4">
                <div class="col-lg-4">
                    <button class="btn btn-success mb-4 mr-4" onclick="approveProduct('{{$product->id}}', 'product_view')"><i class="fas fa-thumbs-up"></i> Approve</button>
                    <button class="btn btn-danger mb-4" onclick="denyProduct('{{$product->id}}', 'product_view')"><i class="fas fa-thumbs-down"></i> Deny</button>
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="font-weight-bolder">Product Image</h5>
                            <div class="row">
                                <div class="col-12">
                                    <img id="productImagePreview2" src="" alt="64x64" style="display:none;">
                                    <input type="hidden" id="base64_product_image" />
                                    <img class="w-100 border-radius-lg shadow-lg mt-3" src="{{\App::make('url')->to('images/'.$product->image)}}" id="productImagePreview" alt="product_image">
                                </div>

                                <div class="col-12 mt-4" id="divProductImages">


                                </div>
                                <div class="col-12 mt-1">
                                    <input type="hidden" id="base64_add_image" />
                                    <input type="file" class="form-control" id="addProductImage" style="visibility: hidden; position: absolute;" />
                                    <div class="d-flex">
                                        <button class="btn bg-gradient-primary btn-sm mb-0 me-2" type="button" name="button" onclick="AddProductImage()">Add Image</button>
                                        <!-- <button class="btn bg-gradient-primary btn-sm mb-0 me-2" type="button" name="button" onclick="ShowToastr()">Show Toastr</button> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mt-lg-0 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="javascript:updateProduct();" id="formProduct" autocomplete="off">
                                <input type="hidden" id="productId" value="{{$product_id ?? ''}}" />
                                {{ csrf_field() }}
                                <input type="file" class="form-control" id="productImage" style="visibility: hidden; position: absolute;" />
                                <h5 class="font-weight-bolder">Product Information @if($product->status==-1)<span class="badge badge-warning">Pending</span>@elseif($product->status==1)<span class="badge badge-success">Approved</span>@else<span class="badge badge-danger">Suspended</span>@endif</h5>
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <label>Product Name</label>
                                        <input class="form-control" type="text" value="{{$product->product_name ?? ''}}" required id="txtProductName" />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <label class="mt-4">Store</label>
                                        <input class="form-control" type="text" value="{{$product->retailer->business_name ?? ''}}" required id="txtProductName" />

                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <label class="mt-4">Category</label>
                                        <input class="form-control" type="text" value="{{$product->category->name ?? ''}}" required id="txtProductName" />

                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="col-6">
                                        <label class="mt-4">Overview</label>
                                        <textarea class="form-control" maxlength="200" required id="txtOverview">{{$product->overview ?? ''}}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-4">Warranty</label>
                                        <?php
                                        $warranty = [];
                                        $warranty[] = '1 Month';
                                        $warranty[] = '2 Months';
                                        $warranty[] = '3 Months';
                                        $warranty[] = '6 Months';
                                        $warranty[] = '1 Year';
                                        $warranty[] = '18 Months';
                                        $warranty[] = '2 Years';
                                        $warranty[] = '3 Years';

                                        ?>
                                        <select class="form-control" name="" id="txtWarranty">
                                            <option value="" @if(!$bEdit) selected="" @endif>Select Warrant Period</option>
                                            @foreach($warranty as $w)
                                            <option value="{{$w}}" @if(($waranty ?? '' )==$w) selected @endif>{{$w}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>-->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mt-4">Description</label>
                                        <p class="form-text text-muted text-xs ms-1 d-inline">
                                            (optional)
                                        </p>
                                        <div id="editor" style="height:300px">
                                            {!!$product->description ?? ''!!}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-4">Tags</label>
                                        <input class="form-control" id="choices-tags" data-color="dark" type="text" value="{{$tags ?? ''}}" placeholder="Add tags to your product" />


                                    </div>
                                    <div class="col-12">
                                        <button type="submit" style="display:none" id="btnProductSubmit">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <br>

                </div>
            </div>

        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-12 mt-lg-0 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-lg-flex">
                            <div>
                                <h5 class="mb-0">Product Variation</h5>

                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="divVariantData" style="display:none">{{json_encode($product->variants)}}</div>
                        <div class="table-responsive">
                            <table class="table table-flush" id="variation-list">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Variants</th>
                                        <th>Values</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>On Sale</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyVariant">
                                    @foreach($product->variants ?? [] as $v)
                                    <tr>
                                        <td class="text-sm">
                                            <?php
                                            $e = explode(';', $v['variant_types']);
                                            for ($i = 0; $i < count($e); $i++) {
                                                if ($i == 0) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-primary badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                } else if ($i == 1) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-info badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                } else if ($i == 2) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-dark badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </td>
                                        <td class="text-sm">
                                            <?php
                                            $e = explode(';', $v['variant_type_values']);
                                            for ($i = 0; $i < count($e); $i++) {
                                                if ($i == 0) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-primary badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                } else if ($i == 1) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-info badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                } else if ($i == 2) {
                                                    if ($e[$i] != "-") {
                                                        echo '<span class="badge bg-gradient-dark badge-sm m-1">' . $e[$i] . '</span>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </td>
                                        <td class="text-sm">{{$v['price']}}</td>
                                        <td class="text-sm">
                                            @if(filter_var($v['on_sale'],FILTER_VALIDATE_BOOLEAN))
                                            {{$v['sale_price']}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(filter_var($v['on_sale'],FILTER_VALIDATE_BOOLEAN))
                                            <span class="badge badge-success badge-sm">On Sale</span>
                                            @else
                                            <span class="badge badge-dark badge-sm">Off Sale</span>
                                            @endif
                                        </td>
                                        <td class="text-sm">{{$v['quantity']}}</td>
                                        <td>
                                            @if(filter_var($v['status'],FILTER_VALIDATE_BOOLEAN))
                                            <span class="badge badge-success badge-sm"> Active </span>
                                            @else
                                            <span class="badge badge-dark badge-sm">Disabled</span>
                                            @endif
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

</main>

@endsection

@section('extra_js')
<script>
    function approveProduct(couponId) {
        var offer = document.getElementById(`select_${couponId}`).value;
        var url = get_base_url(`coupons/${couponId}/${offer}/approve`);
        window.location.replace(url);
    }
</script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<script src="{{asset('js/choices.min.js?'.time())}}"></script>
<script src="{{asset('js/product.js?'.time())}}"></script>
<script src="{{asset('js/product-approval.js?'.time())}}"></script>

@endsection