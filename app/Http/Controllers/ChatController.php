<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $get = User::whereNotIn('id', [$id])->get();
        return response()->json($get);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    //Chat Aplication
    public function getMessage($sender_id, $receiver_id) {
        
        $chat = Chat::where(function($q) use ($sender_id,$receiver_id) {
            $q->where('sender_id', $sender_id);
            $q->where('receiver_id', $receiver_id);
        })->orWhere(function($q) use ($sender_id,$receiver_id) {
            $q->where('sender_id', $receiver_id);
            $q->where('receiver_id', $sender_id);
        })->get();
        return response()->json([
            'message' => $chat
        ]);
    }

    public function sendMessage(Request $request) {
        $chat = new Chat;
        $chat->text = $request->input('text');
        $chat->files = $request->input('files');
        $chat->sender_id = $request->input('sender_id');
        $chat->receiver_id = $request->input('receiver_id');
        if (!$chat->save()) {
            return response()->json(['message'=> 'Pesan tidak terkirim']);
        }
        return response()->json($chat);
    }
}
