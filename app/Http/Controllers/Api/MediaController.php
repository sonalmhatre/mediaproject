<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Provider;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Input;
class MediaController extends Controller
{
    public function index(Request $request){
    	$viewdata = [];
    	$viewdata['medias'] = Media::orderBy('id', 'DESC')->paginate(2);
    	return  view('media.index',$viewdata);
    }
    public function create(Request $request){
    	$viewdata =[];
    	$viewdata['provider'] = Provider::pluck('name','id');

    	return view('media.create',$viewdata);
    }
    public function store(Request $request){
    	$input = $request->all();

    		//ini_set('upload_max_filesize', '200M');
    	//dd($input);
    	$request->validate([
		    'name' => 'required',
		    'provider_id' => 'required',
		    //'video_file' => 'video_length:25'
		    // 'author.description' => 'required',
		]);
		if($request->file('video_file')) {
            $upload         = $request->file('video_file');
            $folder_path = 'images/'.date("Y") . '/' . date("M");

            $path =  'images/'.date("Y") . '/' . date("M").'/';

            if (!is_dir($folder_path)) {
              mkdir(public_path().'/'.$folder_path,0777,true);
            }
            $obj_path = public_path($folder_path);
            $obj_extension = $upload->getClientOriginalExtension();

            $imageName = time() . '_' . str_slug($upload->getRealPath()) . '.' . $obj_extension;
            $upload->move($folder_path, $imageName);
           
            array_set($input, 'video_file', $path.$imageName);
           // array_set($input, 'upload_path', $path);
            $getID3 = new \getID3;

		    $file = $getID3->analyze($path.$imageName);
		    
		    // $playtime_seconds = $file['playtime_seconds'];
		    // $duration = date('H:i:s.v', $playtime_seconds);
		     $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		    $bytes = filesize($path.$imageName);
		    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		    $image_size_array = getimagesize($path.$imageName);
		    $image_width = $image_size_array[0];
			$image_height = $image_size_array[1];
			$image_aspect_ratio = ($image_size_array[0] / $image_size_array[1]);
			// dd($bytes);
			//dd(Helper::ratio($image_width,$image_height) == '17:9');
			if($input['provider_id'] == 1){
				// dd(Helper::ratio($image_width,$image_height) != '4:3');
				if(Helper::ratio($image_width,$image_height) != '4:3'){
					
				return back()->withInput(Input::all())
                ->withErrors('error', 'Image aspect ration must be 4:3 ration!');
				}
			}
		    //return( round( $bytes, 2 ) . " " . $label[$i] );

		    //dd($size);
		    
		    
		    //return $duration;

        }
		Media::create($input);
        return redirect()->route('medias.index')
            ->with('success', 'Video created successfully');
    }
    public function edit(Request $request,$id){
    	$viewdata =[];
    	$viewdata['media'] = Media::where('id',$id)->first();

    	$viewdata['provider'] = Provider::pluck('name','id');
    	return view('media.edit',$viewdata);
    }
    public function update(Request $request){
    	$input = $request->all();
    	
    	$provider = Media::where('id',$id)->first();
    	$provider->update($input);
    	return redirect()->route('media.index')
            ->with('success', 'Provider updated successfully');
    }
}
