<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Provider;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Input;
use FFMpeg;
class VideoController extends Controller
{
    public function index(Request $request){
    	$viewdata = [];

    	$viewdata['videos'] = Video::with('provider')->orderBy('id', 'DESC')->paginate(2);
    	return  view('video.index',$viewdata);
    }
    public function create(Request $request){
    	$viewdata =[];
    	$viewdata['provider'] = Provider::pluck('name','id');

    	return view('video.create',$viewdata);
    }
    public function store(Request $request){
    	$input = $request->all();

    		//ini_set('upload_max_filesize', '200M');
    	//dd($input);
    	$request->validate([
		    'name' => 'required',
		    'provider_id' => 'required',
		    'video_file' => 'required|mimes:mp3,mp4,mov'
		   
		]);
		if($request->file('video_file')) {
            $upload         = $request->file('video_file');
            $folder_path = 'videos/'.date("Y") . '/' . date("M");

            $path =  'videos/'.date("Y") . '/' . date("M").'/';

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
		    
		    $playtime_seconds = $file['playtime_seconds'];
		    $duration = date('s', $playtime_seconds);
		   
		    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		    $bytes = filesize($path.$imageName);
		    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		    

		    
		    if($upload->getClientOriginalExtension() == 'mp4'){
		    	if($input['provider_id'] == 1){
		    		
					if($duration > 60){
						
						return redirect()->route('videodata.create')
	                                    ->with('error', 'Video file Must be Less than 1 Minute long')->withInput();
					}
					if($bytes > 1024){
						return back()->withInput(Input::all())
	                ->withErrors('error', 'Video file Must be Less than 1 Mb size!');
					}
					

				}else if($input['provider_id'] == 2){
					if($duration > 300){
						
	                return redirect()->route('videodata.create')
	                                    ->with('error', 'Video file Must be Less than 5 Minutes long!')->withInput();
					}
					if($bytes > 50*1024){
						
	                return redirect()->route('videodata.create')
	                                    ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					

				}
		    }
		    if($upload->getClientOriginalExtension() == 'mp3'){
		    	if($input['provider_id'] == 1){
					if($duration > 30){
						
	                return redirect()->route('videodata.create')
	                	        ->with('error', 'Video file Must be Less than 30 seconds long!')->withInput();
					}
					if($bytes > 50*1024){
						
	                return redirect()->route('videodata.create')
	                	        ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					
				}
		    }
		    if($upload->getClientOriginalExtension() == 'mov'){
		    	if($input['provider_id'] == 2){
					if($duration > 300){
						
	                return redirect()->route('videodata.create')
	                                    ->with('error', 'Video file Must be Less than 5 Minutes long')->withInput();
					}
					if($bytes > 50*1024){
						
	                return redirect()->route('videodata.create')
	                                    ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					
					
				}
		    }
			$ffmpeg = FFMpeg\FFMpeg::create();
			$video = $ffmpeg->open($path.$imageName);
			$video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
					->save($path.$imageName.'jpg');
			array_set($input, 'thumbnail', $path.$imageName.'jpg');
		    

        }
		Video::create($input);
        return redirect()->route('videodata.index')
            ->with('success', 'Video created successfully');
    }
    public function edit(Request $request,$id){
    	$viewdata =[];
    	$viewdata['video'] = Video::where('id',$id)->first();

    	$viewdata['provider'] = Provider::pluck('name','id');
    	return view('video.edit',$viewdata);
    }
    public function update(Request $request,$id){
    	$input = $request->all();
    	if($request->file('video_file')) {
            $upload         = $request->file('video_file');
            $folder_path = 'videos/'.date("Y") . '/' . date("M");

            $path =  'videos/'.date("Y") . '/' . date("M").'/';

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
		    
		    $playtime_seconds = $file['playtime_seconds'];
		    $duration = date('s', $playtime_seconds);
		   
		    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		    $bytes = filesize($path.$imageName);
		    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		    

		    //dd($video);
		    if($upload->getClientOriginalExtension() == 'mp4'){
		    	if($input['provider_id'] == 1){
					if($duration > 60){
					
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 1 Minute long!')->withInput();


					}
					if($bytes > 1024){
						
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 1 Mb size!')->withInput();
					}
					
					
				}else if($input['provider_id'] == 2){
					if($duration > 300){
						
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 5 Minutes long!')->withInput();

					}
					if($bytes > 50*1024){
						
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					

				}
		    }
		    if($upload->getClientOriginalExtension() == 'mp3'){
		    	if($input['provider_id'] == 1){
					if($duration > 30){
						
	                 return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 30 seconds long!')->withInput();
					}
					if($bytes > 5*1024){
						
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					
				}
		    }
		    if($upload->getClientOriginalExtension() == 'mov'){
		    	if($input['provider_id'] == 2){
					if($duration > 300){
						
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 5 Minutes long!')->withInput();
					}
					if($bytes > 50*1024){
					
	                return redirect()->route('videodata.edit')
	                                    ->with('error', 'Video file Must be Less than 5 Mb size!')->withInput();
					}
					
					
				}
		    }
		    $ffmpeg = FFMpeg\FFMpeg::create();
			$video = $ffmpeg->open($path.$imageName);
			$video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
					->save($path.$imageName.'jpg');
			array_set($input, 'thumbnail', $path.$imageName.'jpg');
			    
		    

        }
    	$provider = Video::where('id',$id)->first();
    	
    	$provider->update($input);
    	return redirect()->route('videodata.index')
            ->with('success', 'Video updated successfully');
    }
}
