<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoktreeItemResource;
use App\Models\DoktreeItem;
use App\Models\Gruppe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoktreeController extends Controller
{
    public function index()
    {
        //   $id = Auth::id();
        //   $gruppen = User::find($id)->person->gruppen;

        //   $profile_dokumente_items = ProfileDokumenteItem::orderBy('order')->where('parent_id', 0)->whereHas('gruppen', function ($query) use ($gruppen)  {
        //      $first = true;
        //      foreach( $gruppen as $gruppe) {
        //         if ($first == true) {
        //            $query->where('gruppe_id', $gruppe->id); $first = false;
        //          } else
        //         $query->orWhere( 'gruppe_id', $gruppe->id );
        //   }})->get();

        //   return ProfileDokumenteItemResource::collection( $profile_dokumente_items );

        return DoktreeItemResource::collection(DoktreeItem::orderBy('order')->where('parent_id', 0)->get());
    }
}
