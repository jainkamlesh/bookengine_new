<?php
   
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
   
class PostControllerr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $posts   = Post::orderBy('id', 'DESC')->whereRaw("FIND_IN_SET(".current_site_ID().",website_id)")->paginate(10);
        $data   = compact('posts');

        return view('admin.pages.blog.index', compact('posts'));
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.pages.blog.add_blog');
    }

    public function edit($id)
    {   

        $blog = Post::where('id',$id)->whereRaw("FIND_IN_SET(".current_site_ID().",website_id)")->first();
        $data     = compact('blog');
        return view('admin.pages.blog.edit_blog', $data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if($request->isMethod('post'))
        {
            $rules = array(
                'Title'        => 'required',
                'Details'     => 'required',
                );

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $blog = Post::where('id', $request->id)->whereRaw("FIND_IN_SET(".current_site_ID().",website_id)")->first();
        if(empty($blog))
        {
            $blog = new Post;
        }

        $blog->title         = $request->Title;
        $blog->body          = $request->Details; 
        $blog->user_id       = Auth::guard('admin')->user()->id;
        $blog->website_id    = current_site_ID();
        $blog->status        = $request->Status;

        if($request->file('Image')!='')
        {
            $image_path = url('public/images/blog/'.$request->Image);

            if (file_exists($image_path)) 
            {
               File::delete($image_path);
            }
            
            $imageName    = time().'_blog'.'.'.request()->Image->guessClientExtension();
            $upload_path  = 'public/images/blog/';
            
            request()->Image->move($upload_path, $imageName);
            $blog->image  = $imageName;
        }
        $blog->save();
        return redirect()->route('admin.blog')->with('success', 'Blog successfully uploaded');
    }
    
    public function delete($id)
    {

        $blog = Post::where('id',$id)->whereRaw("FIND_IN_SET(".current_site_ID().",website_id)")->first();

        $image_path = url('public/images/blog/'.$blog->image);

        if (file_exists($image_path)) 
        {
           File::delete($image_path);
        }
        $blog->delete();
        return redirect()->route('admin.blog')->with('success', 'Blog successfully deleted');
    }

}