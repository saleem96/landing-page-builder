<?php

namespace Modules\TemplateLandingPage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\TemplateLandingPage\Entities\Template;
use Modules\TemplateLandingPage\Entities\Category;
use Modules\TemplateLandingPage\Entities\GroupCategory;

use Modules\BlocksLandingPage\Entities\Block;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use URL;

class TemplateLandingPageController extends Controller
{

    public function getAllTemplate($id = "",Request $request) {
      
        $data = "";

        $categories = Category::all();
        $groupCategories = GroupCategory::all();

        if ($id) {
            $data = Template::where('category_id', $id);
            $data->where('active', true);
        }
        else{
           $data = Template::where('active', true);
        }
        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('created_at', 'DESC');
          
        $data = $data->paginate(12);

        return view('templatelandingpage::templates.templates', compact('data','groupCategories','categories'));

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Template::with('category');

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data->orderBy('created_at', 'DESC');

        $data = $data->paginate(10);

        return view('templatelandingpage::templates.index', compact(
            'data'
        ));
    }

    public function clone($id,Request $request)
    {
        $page = Template::findorFail($id);
        $item = $page->replicate();
        $item->name = "Copy ". $page->name;
        $item->active = false;
        $item->thumb = '';
        $item->save();
        
        return redirect()->route('settings.templates.index')
            ->with('success', __('You copy the template :name successfully',['name'=>$page->name]));
    }

    public function updateBuilder($id, $type = 'main-page', Request $request)
    {
        $type_arr = array('main-page','thank-you-page');
        
        if (!in_array($type, $type_arr)) {
            return response()->json(['error'=>__("Not Found Type")]);
        }
        $page = Template::find($id);

        if ($id) {
            
            $item = Template::find($id);
            if ($item) {

                if ($type == 'thank-you-page') {
                    $item->thank_you_page = $request->input('gjs-html');
                    $item->thank_you_style = $request->input('gjs-css');
                }
                else{

                    $item->content = $request->input('gjs-html');
                    $item->style = $request->input('gjs-css');
                }
                
                if($item->save()){
                    return response()->json(['success'=>__("Updated successfully")]);
                }
            }
            
        }
        return response()->json(['error'=>__("Updated failed")]);
    }
   
    public function loadBuilder($id, $type = 'main-page', Request $request){

        $type_arr = array('main-page','thank-you-page');
        
        if (!in_array($type, $type_arr)) {
            return response()->json(['error'=>__("Not Found Type")]);
        }

        if ($id) {
            $page = Template::find($id);

            if($page){
                $page = replaceVarContentStyle($page);
                if ($type == 'thank-you-page') {
                    return response()->json([
                        'gjs-html'=>$page->thank_you_page, 
                        'gjs-css' => $page->thank_you_style
                    ]);
                }
                return response()->json([
                    'gjs-html'=>$page->content, 
                    'gjs-css' => $page->style
                ]);
               
            }
            
        }
        abort(404);
    }
    

    public function builder($id, $type = 'main-page' ,Request $request){
        
        $type_arr = array('main-page','thank-you-page');
        if (!in_array($type, $type_arr)) {
            abort(404);
        }
       
        if ($id || !in_array($type,['main_page','thank-you-page'])) {

            $page = Template::find($id);

            if($page){

                $blocks = Block::with('category')->where('active', true)->orderBy('name')->get();
                $blockscss = replaceVarContentStyle(config('app.blockscss'));
                $images_url = getAllImagesContentMedia();
                $all_icons = config('app.all_icons');

                return view('templatelandingpage::templates.builder_template', compact('page','blocks','blockscss','images_url','all_icons'));
            }
            
        }
        abort(404);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'files' => 'required|mimes:jpg,jpeg,png,svg|max:20000',
        ]);
        if ($validator->fails()) {    
            return response()->json(['error' => __('The file must be an jpg,jpeg,png,svg')]);
        }
        $images=array();
        $imagesURL=array(); 

        if($request->hasfile('files'))
        {
            $file = $request->file('files');

            $name=$file->getClientOriginalName();
            $new_name = $name;
            $file->move(public_path('storage/content_media/'), $new_name);
            $imagesURL[] = URL::to('/storage/content_media/'.$new_name);
            $images[]=$new_name;

        }
        return response()->json($imagesURL);
    }

    public function deleteImage(Request $request)
    {
        $input=$request->all();
        $link_array = explode('/',$input['image_src']);
        $image_name = end($link_array);
        $path = public_path('storage/content_media/'.$image_name);

        if(File::exists($path)) {
            File::delete($path);
        }
        return response()->json($image_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::select("id", "name")->get();


        return view('templatelandingpage::templates.create', compact(
            'categories'
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
                'category_id'            => 'required|integer',
                'name'    =>  'required',
                'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
            ],
            [
                'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
            ]
        );
       
        if (!$request->filled('is_premium')) {
            $request->request->add([
                'is_premium' => false,
            ]);
        } else {
            $request->request->add([
                'is_premium' => true,
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
        $new_name = "";
        $image = $request->file('thumb');
        
        if($image != ''){
            
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('storage/thumb_templates'), $new_name);
        }
        
        
        $form_data = array(
            'category_id'       =>   $request->category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'thank_you_page'       =>   $request->thank_you_page,
            'thank_you_style'       =>   $request->thank_you_style,
            'is_premium'       =>   $request->is_premium,
            'active'        =>   $request->active,
            'thumb'            =>   $new_name
        );


        $user = Template::create($form_data);

        return redirect()->route('settings.templates.index')
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
        $template = Template::findorFail($id);

        $categories = Category::select("id", "name")->get();
        return view('templatelandingpage::templates.edit', compact(
            'template','categories'
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
        $item = Template::findOrFail($id);

        $image_name = $request->hidden_image;
        
        $image = $request->file('thumb');
        
        if($image != '')
        {
            $request->validate([
                'category_id'            => 'required|integer',
                'name'    =>  'required',
                'thumb'   => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                ],
                [
                    'thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg'),
                ]
            );

            $path = public_path('storage/thumb_templates')."/".$item->thumb;
            deleteImageWithPath($path);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/thumb_templates'), $image_name);
        }
        else
        {
            $request->validate([
                'category_id'            => 'required|integer',
                'name'    =>  'required',
            ]);
        }
  
        if (!$request->filled('is_premium')) {
            $request->request->add([
                'is_premium' => false,
            ]);
        } else {
            $request->request->add([
                'is_premium' => true,
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

                
        $form_data = array(
            'category_id'       =>   $request->category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'thank_you_page'       =>   $request->thank_you_page,
            'thank_you_style'       =>   $request->thank_you_style,
            'is_premium'       =>   $request->is_premium,
            'active'        =>   $request->active,
            'thumb'            =>   $image_name
        );
        
        $item->update($form_data);

        return redirect()->back()
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
        $item = Template::find($id);
        try {
            $path = public_path('storage/thumb_templates')."/".$item->thumb;
            deleteImageWithPath($path);
            $item->delete();

        } catch (Exception $e) {
            
            var_dump($e); die;
        }

        return redirect()->route('settings.templates.index')
            ->with('success', __('Deleted successfully'));
    }

    

}

