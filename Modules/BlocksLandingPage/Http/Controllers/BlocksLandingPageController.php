<?php

namespace Modules\BlocksLandingPage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\BlocksLandingPage\Entities\Block;
use Modules\BlocksLandingPage\Entities\BlockCategory;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Entities\User;
use File;

class BlocksLandingPageController extends Controller
{
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = Block::with('category');
        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data->orderBy('created_at', 'DESC');

        $data = $data->paginate(10);

        return view('blockslandingpage::blocks.index', compact(
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
        $categories = BlockCategory::select("id", "name")->get();


        return view('blockslandingpage::blocks.create', compact(
            'categories'
        ));
    }

    public function blockscss(Request $request)
    {
        $blockscss = config('app.blockscss');
        return view('blockslandingpage::blocks.blockscss', compact(
            'blockscss'
        ));
    }
    public function updateblockscss(Request $request)
    {
        $request->validate([
            'blockscss'            => 'required',
        ]);

        update_option('blockscss', $request['blockscss']);

        Artisan::call('config:clear');

        return back()->with('success', __('Updated successfully'));
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
            'block_category_id'            => 'required|integer',
            'name'    =>  'required',
            'content'    =>  'required',
            'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                ],
                [
                    'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
                ]
        );

        if (!$request->filled('active')) {
            $request->request->add([
                'active' => false,
            ]);
        } else {
            $request->request->add([
                'active' => true,
            ]);
        }

        $new_name = "";
        $image = $request->file('thumb');
        
        if($image != ''){
            
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('storage/thumb_blocks'), $new_name);
        }
        
        $form_data = array(
            'block_category_id'       =>   $request->block_category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'active'        =>   $request->active,
            'thumb'            =>   $new_name
        );


        $user = Block::create($form_data);

        return redirect()->route('settings.blocks.index')
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
        $block = Block::findorFail($id);

        $categories = BlockCategory::select("id", "name")->get();
        return view('blockslandingpage::blocks.edit', compact(
            'block','categories'
        ));
    }

    public function copyedit($id,Request $request)
    {
        $block = Block::findorFail($id);
        $item = $block->replicate();
        $item->name = "Copy ". $block->name;
        $item->active = 0;
        $item->thumb = '';
        $item->save();
        
        return redirect()->route('settings.blocks.index')
            ->with('success', __('You copy the block :name successfully',['name'=>$block->name]));
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
        $item = Block::findOrFail($id);
        
        $image_name = $request->hidden_image;
        
        $image = $request->file('thumb');
        
        if($image != '')
        {
            $request->validate([
                'block_category_id'            => 'required|integer',
                'name'    =>  'required',
                'content'    =>  'required',
                'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                ],
                [
                    'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
                ]
            );
            
            $path = public_path('storage/thumb_blocks')."/".$item->thumb;
            deleteImageWithPath($path);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/thumb_blocks'), $image_name);
        }
        else
        {
            $request->validate([
                'block_category_id'            => 'required|integer',
                'name'    =>  'required',
                'content'    =>  'required',
            ]);
        }
  
        
        if (!$request->filled('active')) {
            $request->request->add([
                'active' => false,
            ]);
        } else {
            $request->request->add([
                'active' => true,
            ]);
        }

        if (!$image_name) {
           $image_name = '';
        }
        
        $form_data = array(
            'block_category_id'       =>   $request->block_category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'active'        =>   $request->active,
            'thumb'            =>   $image_name
        );

        $item->update($form_data);

        

        return redirect()->route('settings.blocks.index')
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
        $item = Block::find($id);

        try {
            $path = public_path('storage/thumb_blocks')."/".$item->thumb;
            deleteImageWithPath($path);
            $item->delete();


        } catch (Exception $e) {
            
            var_dump($e); die;
        }

        return redirect()->route('settings.blocks.index')
            ->with('success', __('Deleted successfully'));
    }

}
