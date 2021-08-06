<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Entities\LandingpageProduct;

class ProductsController extends Controller
{
    public function getProducts(Request $request)
    {
        $items = LandingpageProduct::select('id as value', 'name')
                ->where('user_id', $request->user()->id)->get();

        return response()->json($items);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index(Request $request)
    {
        $data = LandingpageProduct::where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('updated_at', 'DESC');
        $data = $data->paginate(10);

        return view('ecommerce::products.index', compact(
            'data'
        ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $currencies      = config('productcurrencies');
        return view('ecommerce::products.create',compact(
            'currencies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'    =>  'required',
            'price' => 'required',
            'currency'   => 'required',
            ]
        );
        
        
        $form_data = array(
            'user_id' => $request->user()->id,
            'name'        =>   $request->name,
            'price' => $request->price,
            'currency'        =>   $request->currency,
            'description' => $request->description,
        );


        LandingpageProduct::create($form_data);

        return redirect()->route('products.index')
            ->with('success', __('Created successfully'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = LandingpageProduct::findorFail($id);

        $currencies      = config('productcurrencies');

        return view('ecommerce::products.edit', compact(
            'currencies','item'
        ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = LandingpageProduct::findorFail($id);

        $request->validate([
            'name'    =>  'required',
            'price' => 'required',
            'currency'   => 'required',
            ]
        );
        
        
        $form_data = array(
            'user_id' => $request->user()->id,
            'name'        =>   $request->name,
            'price' => $request->price,
            'currency'        =>   $request->currency,
            'description' => $request->description,
        );


        $item->update($form_data);

        return redirect()->route('products.index')
            ->with('success', __('Updated successfully'));
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = LandingpageProduct::findorFail($id);

        $item->delete();

        return redirect()->route('products.index')->with('success','Deleted successfully');
        

    }
}
