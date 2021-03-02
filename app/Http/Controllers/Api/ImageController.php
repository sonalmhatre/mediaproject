<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Provider;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Input;
class ImageController extends Controller
{
    public function index(Request $request){
    	$viewdata = [];
    	
    	$viewdata['images'] = Image::with('provider')->orderBy('id', 'DESC')->paginate(2);
    	return  view('image.index',$viewdata);
    }
    public function create(Request $request){
    	$viewdata =[];
    	$viewdata['provider'] = Provider::pluck('name','id');

    	return view('image.create',$viewdata);
    }
    public function store(Request $request){
    	$input = $request->all();
		$request->validate([
		    'name' => 'required',
		    'provider_id' => 'required',
		    'image_file' => 'required|mimes:jpg,gif'
		    
		]);
		if($request->file('image_file')) {
            $upload         = $request->file('image_file');
            $folder_path = 'images/'.date("Y") . '/' . date("M");

            $path =  'images/'.date("Y") . '/' . date("M").'/';

            if (!is_dir($folder_path)) {
              mkdir(public_path().'/'.$folder_path,0777,true);
            }
            $obj_path = public_path($folder_path);
            $obj_extension = $upload->getClientOriginalExtension();

            $imageName = time() . '_' . str_slug($upload->getRealPath()) . '.' . $obj_extension;
            $upload->move($folder_path, $imageName);
           
            array_set($input, 'image_file', $path.$imageName);
           // array_set($input, 'upload_path', $path);
            
		    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		    $bytes = filesize($path.$imageName);
		    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		    	
		    $image_size_array = getimagesize($path.$imageName);
		    $image_width = $image_size_array[0];
			$image_height = $image_size_array[1];
			$image_aspect_ratio = ($image_size_array[0] / $image_size_array[1]);
			
				if($input['provider_id'] == 1){
					if($upload->getClientOriginalExtension() == 'jpg'){
						if(Helper::ratio($image_width,$image_height) != '4:3'){
							
						
								return redirect()->route('photos.create')
	                                    ->with('error', 'Image aspect ratio must be 4:3 ratio')->withInput();
						}
						if($bytes > 1024*2){
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image size should not be freater than 2 MB')->withInput();
						}
					}
				}
				if($input['provider_id'] == 2){

					if($upload->getClientOriginalExtension() == 'jpg' || $upload->getClientOriginalExtension() == 'gif'){

						if(Helper::ratio($image_width,$image_height) != '16:9'){
							
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image aspect ration must be 16:9 ratio')->withInput();
						}
						if($bytes > 1024*5){
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image size should not be greater than 5 MB')->withInput();
						}
					}
				}

		    

        }
		Image::create($input);
        return redirect()->route('photos.index')
            ->with('success', 'Image created successfully');
    }
    public function edit(Request $request,$id){
    	$viewdata =[];
    	$viewdata['image'] = Image::where('id',$id)->first();

    	$viewdata['provider'] = Provider::pluck('name','id');
    	return view('image.edit',$viewdata);
    }
    public function update(Request $request,$id){
    	$input = $request->all();

    	$request->validate([
		    'name' => 'required',
		    'provider_id' => 'required',
		    'image_file' => 'required|mimes:jpg,gif'
		    
		]);
    	if($request->file('image_file')) {
            $upload         = $request->file('image_file');
            $folder_path = 'images/'.date("Y") . '/' . date("M");

            $path =  'images/'.date("Y") . '/' . date("M").'/';

            if (!is_dir($folder_path)) {
              mkdir(public_path().'/'.$folder_path,0777,true);
            }
            $obj_path = public_path($folder_path);
            $obj_extension = $upload->getClientOriginalExtension();

            $imageName = time() . '_' . str_slug($upload->getRealPath()) . '.' . $obj_extension;
            $upload->move($folder_path, $imageName);
           
            array_set($input, 'image_file', $path.$imageName);
           // array_set($input, 'upload_path', $path);
            
		    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		    $bytes = filesize($path.$imageName);
		    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		    	
		    $image_size_array = getimagesize($path.$imageName);
		    $image_width = $image_size_array[0];
			$image_height = $image_size_array[1];
			$image_aspect_ratio = ($image_size_array[0] / $image_size_array[1]);
			
				if($input['provider_id'] == 1){
					if($upload->getClientOriginalExtension() == 'jpg'){
						if(Helper::ratio($image_width,$image_height) != '4:3'){
							
						
								return redirect()->route('photos.create')
	                                    ->with('error', 'Image aspect ratio must be 4:3 ratio')->withInput();
						}
						if($bytes > 1024*2){
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image size should not be freater than 2 MB')->withInput();
						}
					}
				}
				if($input['provider_id'] == 2){

					if($upload->getClientOriginalExtension() == 'jpg' || $upload->getClientOriginalExtension() == 'gif'){

						if(Helper::ratio($image_width,$image_height) != '16:9'){
							
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image aspect ration must be 16:9 ratio')->withInput();
						}
						if($bytes > 1024*5){
							return redirect()->route('photos.create')
	                                    ->with('error', 'Image size should not be greater than 5 MB')->withInput();
						}
					}
				}

		   

        }
    	$provider = Image::where('id',$id)->first();
    	$provider->update($input);
    	return redirect()->route('photos.index')
            ->with('success', 'Image updated successfully');
    }
}
