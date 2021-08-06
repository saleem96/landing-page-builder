<?php

namespace Modules\BlocksLandingPage\Http\Controllers;

use Modules\BlocksLandingPage\Entities\BlockCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BlocksCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = BlockCategory::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data->orderBy('created_at', 'DESC');
        $data = $data->paginate(10);

        return view('blockslandingpage::blockscategories.index', compact(
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

        return view('blockslandingpage::blockscategories.create');
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
        ]);

        $form_data = array(
            'name'        =>   $request->name,
        );


        $user = BlockCategory::create($form_data);

        return redirect()->route('settings.blockscategories.index')
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
        $category = BlockCategory::findorFail($id);

        return view('blockslandingpage::blockscategories.edit', compact(
            'category'
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
        $image_name = $request->hidden_image;
        
        $request->validate([
                'name'    =>  'required',
        ]);
  


                
        $form_data = array(
            'name'        =>   $request->name,
        );
        
        BlockCategory::whereId($id)->update($form_data);

        return redirect()->route('settings.blockscategories.index')
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
        $item = BlockCategory::find($id);
        
        $delete_status = $item->delete();

        if($delete_status == 1) {
              return redirect()->route('settings.blockscategories.index')->with('success','Deleted Sucesfully');
        } else {
            return redirect()->route('settings.blockscategories.index')->with('error',"Can't delete bacause it has template in it");
        }

    }

}