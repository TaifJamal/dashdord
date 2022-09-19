<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ClinetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=Client::paginate(10);
        return view('admin.client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.client.create');

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
            'name_ar'=>'required',
            'name_en'=>'required',
            'image'=>'required'
        ]);
        $img_name=rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('image/clients'),$img_name);

        Client::create([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'image'=>$img_name

        ]);
        return redirect()->route('admin.clients.index')->
        with('msg', 'Client added successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client=Client::find($id);

        return view('admin.client.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client=Client::find($id);
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',
        ]);
        $img_name=$client->image;
        if($request->image){
        $img_name=rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('image/clients'),$img_name);
        File::delete(public_path('image/clients/'.$client->image));

        }

        $client->update([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'image'=>$img_name

        ]);

        return redirect()->route('admin.clients.index')->
        with('msg', 'Client update successfully')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client=Client::find($id);
        File::delete(public_path('image/clients/'.$client->image));
        $client->delete();
        return redirect()->route('admin.clients.index')->
        with('msg', 'Client delete successfully')->with('type', 'success');
    }

    public function trash()
    {
        $clients = Client::onlyTrashed()->paginate(10);

        return view('admin.client.trash', compact('clients'));
    }

    public function restore($id)
    {
        // Client::onlyTrashed()->find($id)->update(['deleted_at' => null]);
        Client::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.clients.index')->with('msg', 'Client restored successfully')->with('type', 'warning');
    }

    public function forcedelete($id)
    {
        Client::onlyTrashed()->find($id)->forcedelete();

        return redirect()->route('admin.clients.index')->with('msg', 'Client deleted permanintly successfully')->with('type', 'danger');
    }
}

