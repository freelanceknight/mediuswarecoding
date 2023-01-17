<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('variants','variantPrices')->paginate(10);

        //dd($products);

        return view('products.index',compact('products',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //return $request->all();

        DB::beginTransaction();
        $product = Product::create([
            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description
        ]);
        //dd($request->product_variant);
        $product_variants = $request->product_variant;
        $product_variant_pricess = $request->product_variant_prices;
        //dd($product_variant_pricess);
        foreach($product_variants as $product_variant) {
//            dd($product_variant);
//            echo "<pre>";
//            print_r($product_variant);
//            echo "</pre>";
            $product_variant_data = array();
            $product_variant_data['variant_id'] = $product_variant['option'];
            //$product_variant_data['product_id'] = $product->id;

            //dd($product_variant);
            foreach ($product_variant['tags'] as $single) {
                //dd($single);
                $product_var = ProductVariant::create([
                    'variant' => $single,
                    'variant_id' => $product_variant_data['variant_id'],
                    'product_id' => $product->id
                ]);
                //dd($product_var);


            }

        }
        foreach($product_variant_pricess as $single2){
            //dd($single2);
            $product_variant_one = null;
            $product_variant_two = null;
            $product_variant_three = null;
            $exploded = explode('/',$single2['title'],-1);
            //dd(count($exploded));
            //dd($exploded);
            if(!empty($exploded[0])){
                $product_variant_one = ProductVariant::where('product_id',$product->id)->where('variant',$exploded[0])->latest()->first();
                $product_variant_one = $product_variant_one->id;
            }
            if(!empty($exploded[1])){
                $product_variant_two = ProductVariant::where('product_id',$product->id)->where('variant',$exploded[1])->latest()->first();
                $product_variant_two = $product_variant_two->id;
            }
            if(!empty($exploded[2])){
                $product_variant_three = ProductVariant::where('product_id',$product->id)->where('variant',$exploded[2])->latest()->first();
                $product_variant_three = $product_variant_three->id ;
            }
            //dd($product_variant_one);
            $price = $single2['price'];
            $product_id = $product->id;
            ProductVariantPrice::create([
                'product_variant_one' => $product_variant_one,
                'product_variant_two' => $product_variant_two,
                'product_variant_three' => $product_variant_three,
                'price' => $price,
                'product_id' => $product_id,
                'stock' => $single2['stock']
            ]);
        }
        //dd($product_variant_pricess);

        DB::commit();


    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //dd($product);

        $variants = Variant::all();
        $product_variants = $product->variants()->get();
        $product_variant_prices = $product->variantPrices()->get();
        //dd($product_variant_prices);
        //dd($variants);
        //dd($product_variants);
        //dd($variants);
        return view('products.edit', compact('variants','product','product_variants','product_variant_prices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
//        dd($request->all());
        $product = Product::find($request->id);
        $product->title = $request->title;
        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->save();
        $product_variant_prices = $request->product_variant_prices;
        foreach ($product_variant_prices as $single){
            //dd($single['id']);
            $data = ProductVariantPrice::find($single['id']);
            $data->price = $single['price'];
            $data->stock = $single['stock'];
            $data->save();
        }
        //dd($product_variant_prices);
        return $product;



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
