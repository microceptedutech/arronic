<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use App\Sale;
use Carbon\Carbon;

class BlogController extends Controller
{
    
    public function loadBlogs()
    { 
        $blogs = Blog::orderBy('created_at','desc')->get();
        return response()->json($blogs);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sells()
    {
        return view('sells');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'address'=>'required|max:255',
            'file'=>'required|max:200',
        ]);
        if($request->hasFile('file'))
         {  

            $file=$request->file;
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $name=$file->getClientOriginalName();
            $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];
            $string = str_shuffle($pin);
            $file_new_name=time().$string.$name;
            $move=$file->move('images',$file_new_name);
            $file_url='/images/'.$file_new_name;
        }
        $blog = new Blog;
        $blog->name = $request->name;
        $blog->address = $request->address;
        $blog->file = $file_url;
        $blog->save();
        return redirect()->back();
    }
    public function loadTopFives(){
       $sales = Sale::orderBy('sold','desc')->take(5)->get();
       return response()->json($sales);
    }
    public function loadSales()
    {
        $sales = Sale::orderBy('created_at','desc')->get();
        return response()->json($sales);
    }
    public function insertData(Request $request)
    {
        $request->validate([
            'dob'=>'required',
            'sold'=>'required|max:255'
        ]);
        $sale = new Sale;
        $sale->sold = $request->sold;
        $date = Carbon::parse($request->dob);
        $date = $date->format('yy-m-d');
        $sale->sold = $request->sold;
        $sale->dob = $request->dob;
        $sale->save();
        return response()->json(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function deleteSale(Request $request)
    {
        $sale = Sale::find($request->id)->delete();
        return response()->json(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'address'=>'required|max:255',
        ]);
         if($request->hasFile('file'))
         {  

            $file=$request->file;
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $name=$file->getClientOriginalName();
            $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];
            $string = str_shuffle($pin);
            $file_new_name=time().$string.$name;
            $move=$file->move('images',$file_new_name);
            $file_url='/images/'.$file_new_name;

            $blog = Blog::find($request->id);
            $blog->name = $request->name;
            $blog->address = $request->address;
            $blog->file = $file_url;
        }else{
            $blog = Blog::find($request->id);
            $blog->name = $request->name;
            $blog->address = $request->address;
        }
        $blog->save();
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $blog = Blog::find($request->id)->delete();
      return response()->json(200);
    }
}
