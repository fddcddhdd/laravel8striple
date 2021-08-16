<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use model 最初のAppをappにするとNot Foundになる
use App\Models\User; // userモデル
use App\Models\Upload; // モデル

class AdminController extends Controller
{
    public function index()
    {
        // アップロードファイル一覧を取得
        $uploads = Upload::orderby('created_at', 'desc')->get();
        // 管理者以外のユーザ一覧を取得
        $users = User::WHERE('admin', false)->orderby('created_at', 'desc')->get();
        return view('admin', compact('users', 'uploads'));
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
}
