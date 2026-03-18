<?php

namespace App\Http\Controllers;

use App\Models\Hund;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_images_order(Request $request)
    {

        $order = json_decode($request->order);

        $i = 0;
        foreach ($order as $id) {
            $image = Image::find($id);
            $image->order = $i++;
            $image->save();
        }

        // $index = $request->get('index');
        // $hund_id = $request->get('object_id');
        // $hund = Hund::find($hund_id);
        // return response()->json( [ 'images' => $hund->images, 'index' => $index ]);
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_images_bu(Request $request)
    {

        $image_id = $request->image_id;
        $image = Image::find($image_id);

        $bu = $request->bu;
        $user_id = Auth::id();

        $type = $request->type;

        switch ($type) {
            case 'hund':
                $hund_id = $request->object_id;
                $authorized = User::find($user_id)->person->hunde->where('id', $hund_id);
                break;
            case 'zwinger':
                $hund_id = $request->object_id;
                $authorized = User::find($user_id)->person->zwinger->where('id', $hund_id);
                break;
            default:
                $authorized = '';
        }

        if ($authorized) {
            $image = Image::find($image_id);
            $image->bu = $bu;
            $image->save();

            return $image->bu;
        } else {
            return response()->json(['error' => 'Nicht authoriziert.']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
