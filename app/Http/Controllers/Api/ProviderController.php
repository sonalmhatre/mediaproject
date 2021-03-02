<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ProviderRequest;

use App\Http\Controllers\Controller;
use App\Models\Provider;
class ProviderController extends Controller
{
    public function index(){
    	$viewdata=[];
		$viewdata['providers'] = Provider::paginate(5);
		return  view('provider.index',$viewdata);
    }
    public function create(Request $request){
    	return view('provider.create');
    }
    public function store(ProviderRequest $request){
    	$input = $request->all();

  //   	$request->validate([
		//     'name' => 'required'
		//     // 'author.name' => 'required',
		//     // 'author.description' => 'required',
		// ]);
		Provider::create($input);
        return redirect()->route('providers.index')
            ->with('success', 'Provider created successfully');
    }
     public function edit($id){
    	$provider = Provider::where('id',$id)->first();
    	return view('provider.edit',compact('provider'));
    }
    public function update(Request $request,$id){
    	$input = $request->all();
    	
    	$provider = Provider::where('id',$id)->first();
    	$provider->update($input);
    	return redirect()->route('providers.index')
            ->with('success', 'Provider updated successfully');
    }
}
