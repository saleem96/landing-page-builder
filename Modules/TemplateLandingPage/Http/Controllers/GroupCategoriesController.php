<?php

namespace Modules\TemplateLandingPage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\TemplateLandingPage\Entities\GroupCategory;

class GroupCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = GroupCategory::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data = $data->paginate(10);

        return view('templatelandingpage::groupcategories.index', compact(
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

        return view('templatelandingpage::groupcategories.create');
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
            'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
            ],
            [
                'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
            ]
        );
       

        $image = $request->file('thumb');
        $new_name = "";
        if ($image) {
            # code...
            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('storage/categories'), $new_name);
        }
        
        
        $form_data = array(
            'name'        =>   $request->name,
            'thumb'            =>   $new_name
        );


        $user = GroupCategory::create($form_data);

        return redirect()->route('settings.groupcategories.index')
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
        $category = GroupCategory::findorFail($id);

        return view('templatelandingpage::groupcategories.edit', compact(
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
        
        $image = $request->file('thumb');
        
        if($image != '')
        {
            $request->validate([
                'name'    =>  'required',
                'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                ],
                [
                    'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
                ]
            );

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/categories'), $image_name);
        }
        else
        {
            $request->validate([
                'name'    =>  'required',
            ]);
        }
  


                
        $form_data = array(
            'name'        =>   $request->name,
            'thumb'            =>   $image_name
        );
        
        GroupCategory::whereId($id)->update($form_data);

        return redirect()->route('settings.groupcategories.index')
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
        $item = GroupCategory::find($id);
        
        $delete_status = $item->delete();

        if($delete_status == 1) {
              return redirect()->route('settings.groupcategories.index')->with('success','Deleted successfully');
        } else {
            return redirect()->route('settings.groupcategories.index')->with('error',"Can't delete because it has Group in it");
        }

    }

}
