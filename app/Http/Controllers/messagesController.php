<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Models\message;
use Auth;
class messagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function getChatOfToPersons(Request $request)
    {
        $messages=message::where( function($query) use($request){
            $query->where('sender_id',($request->another_side))
            ->where('reciver_id',(auth()->id()));
           })
           ->orwhere(function ($query) use($request){
            $query->where('sender_id',(auth()->id()))
           ->where('reciver_id',($request->another_side));
        })->orderBy('created_at', 'asc')->get();

        return Response::json($messages);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $message=new message();
        $message->content=$request->content;
        $message->sender_id=auth()->id();
        $message->reciver_id=$request->reciver_id;
        $message->save();
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
