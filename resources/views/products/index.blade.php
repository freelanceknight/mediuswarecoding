@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>


                    @foreach($products as $product)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$product->title}} <br> Created at : {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->created_at)->format('Y-m-d')}} </td>
                            <td>{{$product->description}}</td>
                            <td>

                                @foreach($product->variantPrices as $variantPrices)
{{--                                    {{$product->variants}}--}}
{{--                                {{$variantPrices->product_variant_one}}--}}
                                    @php
                                    $variant1 = \App\Models\ProductVariant::where('id',$variantPrices->product_variant_one)->first();
                                    $variant2 = \App\Models\ProductVariant::where('id',$variantPrices->product_variant_two)->first();
                                    $variant3 = \App\Models\ProductVariant::where('id',$variantPrices->product_variant_three)->first();
                                    //$variant = $variant->variant;
                                    @endphp

                                    <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                        <dt class="col-sm-3 pb-0">

                                            {{$variant1->variant??''}}/{{$variant2->variant??''}}/{{$variant3->variant??''}}



                                        </dt>
                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">

                                                <dt class="col-sm-4 pb-0">Price : {{$variantPrices->price}} </dt>

                                                    <dd class="col-sm-8 pb-0">InStock : {{$variantPrices->stock}}</dd>
                                            </dl>
                                        </dd>

                                    </dl>
{{--                                    @endif--}}
                                @endforeach
                                <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach



                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing 1 to 10 out of 100</p>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
