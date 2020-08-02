<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Wishlist::updateOrCreate($request->all());
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        $item = Wishlist::where('shop_id', $request['shop_id'])
            ->where('customer_id', $request['customer_id'])
            ->where('product_id', $request['product_id'])->first();

        return Wishlist::destroy($item->id);
    }

    /**
     *
     */
    public function check(Request $request)
    {
        $item = Wishlist::where('shop_id', $request['shop_id'])
            ->where('customer_id', $request['customer_id'])
            ->where('product_id', $request['product_id'])->first();

        return $item ? 1 : 0;
    }

    public function test()
    {
        $shop = Auth::user();
        $shopWishlists = Wishlist::where('shop_id', $shop->name)->orderBy('updated_at', 'desc')->get();
        $lists = [];
        foreach ($shopWishlists as $item) {
            array_push($lists, "gid://shopify/Product/{$item->product_id}");
        }

        $mylists = json_encode($lists);

        $query = "
            {
                nodes(ids:  $mylists ) {
                ... on Product {
                    id
                    title
                    handle
                    featuredImage {
                      originalSrc
                    }
                    totalInventory
                    vendor
                    onlineStorePreviewUrl
                    priceRange{
                    maxVariantPrice{
                        currencyCode
                        amount
                        }
                    }
                    }
                }
            }
        ";

        $products = $shop->api()->graph($query);
        return view('partials.wishlist-table', compact('products'));
    }
}
