<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserMenuItemResource;
use App\Models\UserMenuItem;
use Illuminate\Http\Request;

class UserMenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $id = Auth::id();
        // $gruppen = User::find($id)->person->gruppen;

        // $main_menu_items = MainMenuItem::orderBy('order')->where('parent_id', 0)->whereHas('gruppen', function ($query) use ($gruppen)  {
        //    $first = true;
        //    foreach( $gruppen as $gruppe) {
        //       if ($first == true) {
        //          $query->where('gruppe_id', $gruppe->id); $first = false;
        //        } else
        //       $query->orWhere( 'gruppe_id', $gruppe->id );
        // }})->get();

        return UserMenuItemResource::collection(UserMenuItem::aktiv()->orderBy('order')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(UserMenuItem $userMenuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMenuItem $userMenuItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMenuItem $userMenuItem)
    {
        //
    }
}
