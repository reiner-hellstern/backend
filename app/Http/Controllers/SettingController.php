<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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
    public function store(Request $request)
    {

        $data = $request->all();
        $id = Auth::id();
        $datas = $data['data'];
        array_walk_recursive($datas, function (&$item) {
            $item = ($item === null) ? '' : $item;
        });

        $setting = Setting::updateOrCreate(
            ['user_id' => $id, 'section' => $data['section']],
            ['data' => json_encode($datas)]
        );

        return $setting;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function get($section)
    {
        $id = Auth::id();

        $setting = Setting::where('user_id', $id)->where('section', $section)->first();

        if ($setting) {
            return $setting['data'];
        } else {
            return 'nosetting';
        }

        // dd(json_encode($data));

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting) {}

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
