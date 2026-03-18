<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\File;
use App\Models\Hund;
use App\Models\Image;
use App\Models\Person;
use App\Models\User;
use App\Models\Wurf;
use App\Models\Zwinger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image as Imagelib;

class FileController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function single_upload(Request $request)
    {

        //    Validator::make($request->all(), [
        //       'file' => 'required|mimes:jpg,jpeg,png,gif,csv,txt,doc,xls,pdf,xlsx,docx|max:2048'
        //   ])->validate();

        //    $request->validate([
        //       'file' => 'required|mimes:jpg,jpeg,png,gif,csv,txt,doc,xls,pdf,xlsx,docx|max:2048'
        //    ]);

        $fileUpload = new Dokument();

        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

            $fileUpload->name = time() . '_' . $request->file->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->save();

            return response()->json(['success' => 'File uploaded successfully.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {

        $url = Config::get('app.url');
        // $type = $request->get('type');
        // $id = $request->get('id');

        $user_id = Auth::id();

        if ($user_id) {

            $user = User::find($user_id);

            $data = $request->get('image');

            $subfolder = substr($user_id, 0, 2);

            if (! is_dir(public_path() . '/storage/users/' . $subfolder . '/' . $user_id)) {
                mkdir(public_path() . '/storage/users/' . $subfolder . '/' . $user_id, 0777, true);
            }

            if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
                $imageType = $matches[1];
                $imageData = base64_decode($matches[2]);
                $image = imagecreatefromstring($imageData);
                $filename = 'profile' . $user_id . time() . '.jpg';

                if (imagejpeg($image, public_path() . '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename, 90)) {
                    // echo json_encode(array('filename' => '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename));
                    $user->profile_photo_path = '/users/' . $subfolder . '/' . $user_id . '/' . $filename;
                    $user->save();

                    return response()->json(['filename' => $url . '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename]);
                } else {
                    throw new Exception('Could not save the file.');
                }
            } else {
                throw new Exception('Invalid data URL.');
            }
        }
    }

    //   $fileName = time().'.'.$request->file->extension();
    //   $request->file->move(public_path('uploads'), $fileName);

    //   File::create([
    //       'title' => $request->title,
    //       'name' => $fileName
    //   ]);

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_image_profile(Request $request)
    {

        $url = Config::get('app.url');
        // $type = $request->get('type');
        // $id = $request->get('id');

        $user_id = Auth::id();

        if ($user_id) {

            $user = User::find($user_id);

            $data = $request->get('image');

            $subfolder = substr($user_id, 0, 2);

            if (! is_dir(public_path() . '/storage/users/' . $subfolder . '/' . $user_id)) {
                mkdir(public_path() . '/storage/users/' . $subfolder . '/' . $user_id, 0777, true);
            }

            if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
                $imageType = $matches[1];
                $imageData = base64_decode($matches[2]);
                $image = imagecreatefromstring($imageData);
                $filename = 'profile' . $user_id . time() . '.jpg';

                if (imagejpeg($image, public_path() . '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename, 90)) {
                    // echo json_encode(array('filename' => '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename));
                    $user->profile_photo_path = '/users/' . $subfolder . '/' . $user_id . '/' . $filename;
                    $user->save();

                    return response()->json(['filename' => $url . '/storage/users/' . $subfolder . '/' . $user_id . '/' . $filename]);
                } else {
                    throw new Exception('Could not save the file.');
                }
            } else {
                throw new Exception('Invalid data URL.');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_image_hund(Request $request)
    {

        $hund_id = $request->get('id');
        $index = $request->get('index');
        $bu = $request->get('bu');

        $hund = Hund::find($hund_id);
        // return response()->json(['success' => $hund, 'IMAGES' => $hund->images]);

        if (count($hund->images) >= 10) {
            return response()->json(['error' => 'Es wurden bereits zehn Bilder gespeichert. Bitte löschen Sie zuerst ein Bild, um ein neues Bild speichern zu können.']);
        }

        $user_id = Auth::id();

        if ($user_id) {

            $permitted = User::find($user_id)->person->hunde->where('id', $hund_id);

            //  $permitted = Person::with(['hunde' => function($query) use ($hund_id) {
            //    $query->where('id', $hund_id);
            //  }])->get();

            if ($permitted) {
                $data = $request->get('image');

                $subfolder = substr($hund_id, 0, 2);

                if (! is_dir(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id)) {
                    mkdir(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id, 0777, true);
                }

                if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
                    $imageType = $matches[1];
                    $imageData = base64_decode($matches[2]);
                    $image = imagecreatefromstring($imageData);
                    $filename = 'hund' . $hund_id . '_' . time() . '.jpg';

                    if (imagejpeg($image, public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id . '/' . $filename, 90)) {
                        // echo json_encode(array('filename' => '/storage/hunde/' . $subfolder . '/' . $hund_id . '/' . $filename));

                        $newImage = new Image([
                            'bu' => $bu,
                            'path' => 'hunde/' . $subfolder . '/' . $hund_id . '/' . $filename,
                            'thumb' => 'hunde/' . $subfolder . '/' . $hund_id . '/thumb_' . $filename,
                            'order' => count($hund->images),
                        ]);
                        $hund->images()->save($newImage);

                        $thumb = Imagelib::read($data);
                        $thumb->resize(400, 400, function ($const) {
                            $const->aspectRatio();
                        })->save(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id . '/thumb_' . $filename);

                        $hund->load('images');

                        return response()->json(['images' => $hund->images, 'index' => $index]);
                        // $user->profile_photo_path = '/users/' . $subfolder . '/' . $user_id . '/' . $filename;
                        // $user->save();
                    } else {
                        throw new Exception('Could not save the file.');
                    }
                } else {
                    throw new Exception('Invalid data URL.');
                }
            } else {
                return response()->json(['error' => 'Keine Berechtigung!']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_image_hund(Request $request)
    {

        $hund_id = $request->get('object_id');
        $hund = Hund::find($hund_id);

        $img_id = $request->get('img_id');
        $image = $hund->images->where('id', $img_id)->first();

        $user_id = Auth::id();

        $authorized = User::find($user_id)->person->hunde->where('id', $hund_id);
        $images = $hund->images;

        if ($user_id && $image && $authorized) {

            Image::destroy($img_id);
            Storage::disk('public')->delete($image->path);
            Storage::disk('public')->delete($image->thumb);
            $hund->load('images');
            $images = $hund->images;

            $i = 0;
            foreach ($images as $img) {

                $img->order = $i++;
                $img->save();
            }

        }
        $images = $hund->images;

        return response()->json(['images' => $images, 'index' => 0]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_image_zwinger(Request $request)
    {

        $zwinger_id = $request->get('id');
        $bu = $request->get('bu');

        $zwinger = Zwinger::find($zwinger_id);

        if (count($zwinger->images) >= 10) {
            return response()->json(['error' => 'Es wurden bereits zehn Bilder gespeichert. Bitte löschen Sie zuerst ein Bild, um ein neues Bild speichern zu können.']);
        }

        $user_id = Auth::id();

        if ($user_id) {

            $permitted = User::find($user_id)->person->zwinger->where('id', $zwinger_id);

            if ($permitted) {
                $data = $request->get('image');

                $subfolder = substr($zwinger_id, 0, 2);

                if (! is_dir(public_path() . '/storage/zwinger/' . $subfolder . '/' . $zwinger_id)) {
                    mkdir(public_path() . '/storage/zwinger/' . $subfolder . '/' . $zwinger_id, 0777, true);
                }

                if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
                    $imageType = $matches[1];
                    $imageData = base64_decode($matches[2]);
                    $image = imagecreatefromstring($imageData);
                    $filename = 'zwinger' . $zwinger_id . '_' . time() . '.jpg';

                    if (imagejpeg($image, public_path() . '/storage/zwinger/' . $subfolder . '/' . $zwinger_id . '/' . $filename, 90)) {

                        $newImage = new Image([
                            'bu' => $bu,
                            'path' => 'zwinger/' . $subfolder . '/' . $zwinger_id . '/' . $filename,
                            'thumb' => 'zwinger/' . $subfolder . '/' . $zwinger_id . '/thumb_' . $filename,
                            'order' => count($zwinger->images),
                        ]);
                        $zwinger->images()->save($newImage);
                        // $image = Storage::disk('public')->get($orig_file);

                        $thumb = Imagelib::read($data);
                        $thumb->resize(400, 400, function ($const) {
                            $const->aspectRatio();
                        })->save(public_path() . '/storage/zwinger/' . $subfolder . '/' . $zwinger_id . '/thumb_' . $filename);

                        $zwinger->load('images');

                        return response()->json(['images' => $zwinger->images, 'index' => 0]);

                    } else {
                        throw new Exception('Could not save the file.');
                    }
                } else {
                    throw new Exception('Invalid data URL.');
                }
            } else {
                return response()->json(['error' => 'Keine Berechtigung!']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_image_zwinger(Request $request)
    {

        $zwinger_id = $request->get('object_id');
        $zwinger = Zwinger::find($zwinger_id);

        $img_id = $request->get('img_id');
        $image = $zwinger->images->where('id', $img_id)->first();

        $user_id = Auth::id();

        $authorized = User::find($user_id)->person->zwinger->where('id', $zwinger_id);
        $images = $zwinger->images;

        if ($user_id && $image && $authorized) {

            Image::destroy($img_id);
            Storage::disk('public')->delete($image->path);
            Storage::disk('public')->delete($image->thumb);
            $zwinger->load('images');
            $images = $zwinger->images;

            $i = 0;
            foreach ($images as $img) {
                $img->order = $i++;
                $img->save();
            }

        }
        $images = $zwinger->images;

        return response()->json(['images' => $images]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_image_wurf(Request $request)
    {

        $wurf_id = $request->get('id');
        $bu = $request->get('bu');

        $wurf = Wurf::find($wurf_id);

        if (count($wurf->images) >= 10) {
            return response()->json(['error' => 'Es wurden bereits zehn Bilder gespeichert. Bitte löschen Sie zuerst ein Bild, um ein neues Bild speichern zu können.']);
        }

        $user_id = Auth::id();

        if ($user_id) {

            $permitted = User::find($user_id)->person->wuerfe->where('id', $wurf_id);

            if ($permitted) {
                $data = $request->get('image');

                $subfolder = substr($wurf_id, 0, 2);

                if (! is_dir(public_path() . '/storage/wurf/' . $subfolder . '/' . $wurf_id)) {
                    mkdir(public_path() . '/storage/wurf/' . $subfolder . '/' . $wurf_id, 0777, true);
                }

                if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
                    $imageType = $matches[1];
                    $imageData = base64_decode($matches[2]);
                    $image = imagecreatefromstring($imageData);
                    $filename = 'wurf' . $wurf_id . '_' . time() . '.jpg';

                    if (imagejpeg($image, public_path() . '/storage/wurf/' . $subfolder . '/' . $wurf_id . '/' . $filename, 90)) {

                        $newImage = new Image([
                            'bu' => $bu,
                            'path' => 'wurf/' . $subfolder . '/' . $wurf_id . '/' . $filename,
                            'thumb' => 'wurf/' . $subfolder . '/' . $wurf_id . '/thumb_' . $filename,
                            'order' => count($wurf->images),
                        ]);
                        $wurf->images()->save($newImage);
                        // $image = Storage::disk('public')->get($orig_file);

                        $thumb = Imagelib::read($data);
                        $thumb->resize(400, 400, function ($const) {
                            $const->aspectRatio();
                        })->save(public_path() . '/storage/wurf/' . $subfolder . '/' . $wurf_id . '/thumb_' . $filename);

                        $wurf->load('images');

                        return response()->json(['images' => $wurf->images, 'index' => 0]);

                    } else {
                        throw new Exception('Could not save the file.');
                    }
                } else {
                    throw new Exception('Invalid data URL.');
                }
            } else {
                return response()->json(['error' => 'Keine Berechtigung!']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_image_wurf(Request $request)
    {

        $wurf_id = $request->get('object_id');
        $wurf = Wurf::find($wurf_id);

        $img_id = $request->get('img_id');
        $image = $wurf->images->where('id', $img_id)->first();

        $user_id = Auth::id();

        $authorized = User::find($user_id)->person->wuerfe->where('id', $wurf_id);
        $images = $wurf->images;

        if ($user_id && $image && $authorized) {

            Image::destroy($img_id);
            Storage::disk('public')->delete($image->path);
            Storage::disk('public')->delete($image->thumb);
            $wurf->load('images');
            $images = $wurf->images;

            $i = 0;
            foreach ($images as $img) {
                $img->order = $i++;
                $img->save();
            }

        }
        $images = $wurf->images;

        return response()->json(['images' => $images]);
    }

    public function generate_images_hunde(Request $request)
    {
        //   $hunde = Hund::all();

        $files = Storage::disk('public')->files('hunde/fotos');

        foreach ($files as $file) {

            $orig_file = $file;

            $file = str_replace('hunde/fotos/', '', $file);
            $rasse_id = 0;
            $bildnr = 0;
            if (str_contains($file, 'CBR__')) {
                $rasse_id = 1;
                $file = str_replace('CBR__', '', $file);
            }
            if (str_contains($file, 'CCR__')) {
                $rasse_id = 2;
                $file = str_replace('CCR__', '', $file);
            }
            if (str_contains($file, 'FCR__')) {
                $rasse_id = 3;
                $file = str_replace('FCR__', '', $file);
            }
            if (str_contains($file, 'GR__')) {
                $rasse_id = 4;
                $file = str_replace('GR__', '', $file);
            }
            if (str_contains($file, 'LR__')) {
                $rasse_id = 5;
                $file = str_replace('LR__', '', $file);
            }
            if (str_contains($file, 'NSDTR__')) {
                $rasse_id = 6;
                $file = str_replace('NSDTR__', '', $file);
            }

            if (str_contains($file, '_1.jpg')) {
                $bildnr = 0;
                $file = str_replace('_1.jpg', '', $file);
            } elseif (str_contains($file, '_2.jpg')) {
                $bildnr = 1;
                $file = str_replace('_2.jpg', '', $file);
            }
            $zuchtbuchnummer = str_replace(' ', '_', $file);

            $hund = Hund::where('zuchtbuchnummer', '=', $zuchtbuchnummer)->where('rasse_id', '=', $rasse_id)->first();

            if ($hund) {

                echo $hund->id . ' / ' . $hund->id . ' / ' . $zuchtbuchnummer . '<br/>';

                $hund_id = $hund->id;

                $subfolder = substr($hund_id, 0, 2);

                if (! is_dir(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id)) {
                    mkdir(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id, 0777, true);
                }

                $filename = 'hund' . $hund_id . '_' . $bildnr . time() . '.jpg';

                Storage::disk('public')->copy($orig_file, 'hunde/' . $subfolder . '/' . $hund_id . '/' . $filename);
                $newImage = new Image([
                    'bu' => '',
                    'path' => 'hunde/' . $subfolder . '/' . $hund_id . '/' . $filename,
                    'thumb' => 'hunde/' . $subfolder . '/' . $hund_id . '/thumb_' . $filename,
                    'order' => $bildnr,
                ]);
                $hund->images()->save($newImage);

                $image = Storage::disk('public')->get($orig_file);
                $thumb = Imagelib::read($image);
                $thumb->resize(400, 400, function ($const) {
                    $const->aspectRatio();
                })->save(public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id . '/thumb_' . $filename);

            }

        }

        return $files;

        //             if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
        //                $imageType = $matches[1];
        //                $imageData = base64_decode($matches[2]);
        //                $image = imagecreatefromstring($imageData);
        //                $filename = 'hund' . $hund_id .'_'.time().'.jpg';

        //                if (imagejpeg($image, public_path() . '/storage/hunde/' . $subfolder . '/' . $hund_id . '/' . $filename, 90)) {
        //                  // echo json_encode(array('filename' => '/storage/hunde/' . $subfolder . '/' . $hund_id . '/' . $filename));

        //                   $newImage = new Image([
        //                      'bu' => $bu,
        //                      'path' => 'hunde/' . $subfolder . '/' . $hund_id . '/' . $filename,
        //                      'order' => count($hund->images)
        //                   ]);
        //                   $hund->images()->save($newImage);

        //                   $hund->load('images');

        //                   return response()->json( [ 'images' => $hund->images, 'index' => $index ]);
        //                   // $user->profile_photo_path = '/users/' . $subfolder . '/' . $user_id . '/' . $filename;
        //                   // $user->save();
        //                } else {
        //                   throw new Exception('Could not save the file.');
        //                }
        //             } else {
        //                throw new Exception('Invalid data URL.');
        //             }
        //          } else {
        //             return response()->json(['error' => 'Keine Berechtigung!']);
        //          }
        //    }
        //  }

    }
}
