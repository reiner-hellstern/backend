<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDokumentRequest;
use App\Models\Dokument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class DokumentController extends Controller
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
     * Uploads multiple files and saves them to the database.
     *
     * @param  Request  $request  The HTTP request object containing the files to be uploaded.
     * @return JsonResponse A JSON response indicating the success of the upload operation and the uploaded document.
     *
     * @throws Some_Exception_Class If the request does not contain a valid file.
     */
    public function uploadMulti(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif,csv,txt,doc,xls,pdf,xlsx,docx|max:16300',
        ]);

        $url = Config::get('app.url');
        $store = $request->get('store');

        $user_id = Auth::id();

        $freigabe = $request->get('freigabe') ? 1 : 0;
        $models = json_decode($request->get('models'));

        $request_tags = json_decode($request->get('tags'));

        $tags = [];
        foreach ($request_tags as $tag) {
            if (is_numeric($tag)) {
                $tags[$tag] = ['fixed' => true];
            } else {
                $fixed = property_exists($tag, 'fixed') ? $tag->fixed : false;
                $tags[$tag->id] = ['fixed' => $fixed];
            }
        }

        //   return response()->json(['success' => $tags[0], 'tags' => $tags]);

        $maintype = '';
        $mainid = 0;

        // Suche nach einem Hauptmodel, um den Speicherpfad des Dokumentes auf dem Server festzulegen.
        foreach ($models as $key => $value) {

            switch ($key) {
                case 'Hund':
                case 'Wurf':
                case 'Person':
                case 'Zwinger':
                case 'Veranstaltung':
                case 'Dokumentenkategorie':
                    $maintype = strtolower($key);
                    $mainid = $value;
                    break;
            }
        }

        $file = $request->file('file');

        if ($file) {

            $dokument = new Dokument();

            $subfolder = substr($mainid, 0, 2);
            $path = '/storage/' . $maintype . '/' . $subfolder . '/' . $mainid;

            if (! is_dir(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $extension = $file->extension();
            $onlyfilename = explode('.' . $extension, $filename)[0];

            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                case 'gif':
                case 'png':
                    $resolution = getimagesize($request->file('file'));
                    $dokument->width = $resolution[0];
                    $dokument->height = $resolution[1];

                    $thumb = Image::read($file->path());
                    $thumb->resize(150, 150, function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($path) . '/thumb_' . $filename);
                    $dokument->thumb = '/' . $maintype . '/' . $subfolder . '/' . $mainid . '/thumb_' . $filename;
                    $filesize = $file->getSize();
                    $file->move(public_path($path), $filename);

                    break;

                case 'xls':
                case 'xlsx':
                    $dokument->thumb = '/icons/file_excel.png';
                    $filesize = $file->getSize();
                    $file->move(public_path($path), $filename);

                    break;
                case 'docx':
                case 'doc':
                    $dokument->thumb = '/icons/file_word.png';
                    $filesize = $file->getSize();
                    $file->move(public_path($path), $filename);

                    break;
                case 'pdf':
                    $dokument->thumb = '/icons/file_pdf.png';
                    $filesize = $file->getSize();
                    $file->move(public_path($path), $filename);
                    $pdf = new \Spatie\PdfToImage\Pdf(public_path($path) . '/' . $filename);
                    $pdf->save(public_path($path) . '/thumb_' . $onlyfilename . '.jpg');
                    $dokument->thumb = '/' . $maintype . '/' . $subfolder . '/' . $mainid . '/thumb_' . $onlyfilename . '.jpg';
                    break;
                case 'csv':
                case 'txt':
                    $dokument->thumb = '/icons/file_pdf.png';
                    $filesize = $file->getSize();
                    $file->move(public_path($path), $filename);

                    break;
            }

            // $resolution = getimagesize($request->file('file'));
            // $width = $resolution[0];
            // $height = $resolution[1];
            // $dokument->width =  $width;
            // $dokument->height = $height;

            $dokument->size = $filesize;
            $dokument->name = $file->getClientOriginalName();
            $dokument->beschreibung = $request->beschreibung != 'undefined' ? $request->beschreibung : '';
            $dokument->path = '/' . $maintype . '/' . $subfolder . '/' . $mainid . '/' . $filename;

            $dokument->ext = $extension;
            $dokument->upload_element_id = $request->get('el_id');
            $dokument->datum = $request->get('datum');
            $dokument->freigabe = $freigabe;

            $dokument->save();

            foreach ($models as $key => $value) {

                $klasse = 'App\Models\\' . $key;
                $dbmodel = $klasse::find($value);
                // $dbmodel->dokumente()->save($dokument, ['ref' => $request->get('ref')]);
                $dbmodel->dokumente()->save($dokument);
            }

            $dokument->tags()->sync($tags);

            $dokument['tags'] = $dokument->tags;

            return response()->json(['success' => 'File uploaded successfully.', 'dokument' => $dokument]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDokumentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Dokument $dokument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDokumentRequest  $request
     * @param  \App\Models\Dokument  $dokument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $dokument = Dokument::find($request->id);
        // $tags = $request->tag_ids;

        $request_tags = json_decode($request->get('tag_objs'));

        $tags = [];
        foreach ($request_tags as $tag) {
            if (is_numeric($tag)) {
                $tags[$tag] = ['fixed' => true];
            } else {
                $fixed = property_exists($tag, 'fixed') ? $tag->fixed : false;
                $tags[$tag->id] = ['fixed' => $fixed];
            }
        }

        $dokument->tags()->sync($tags);

        $dokument->datum = $request->datum;
        $dokument->beschreibung = $request->beschreibung;
        $dokument->freigabe = $request->freigabe;
        $dokument->save();

        $dok = Dokument::find($dokument->id);

        // $tags = explode(',', $request->tags);

        return response()->json(['success' => 'File uploaded successfully.', 'dokument' => $dokument, 'tags' => $dok->tags]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dokument  $dokument
     * @return \Illuminate\Http\Response
     */
    public function removeModel(Request $request)
    {

        $dokument = Dokument::find($request->dokument);
        $models = json_decode($request->models);
        foreach ($models as $key => $value) {
            $klasse = 'App\Models\\' . $key;
            $dbmodel = $klasse::find($value);
            $dbmodel->dokumente()->detach($dokument);
        }

        return response()->json(['success' => 'File removed from model.']);
    }

    public function storeModel(Request $request)
    {

        $dokument = Dokument::find($request->dokument);
        $request_tags = json_decode($request->get('tags'));

        $tags = [];
        foreach ($request_tags as $tag) {
            if (is_numeric($tag)) {
                $tags[$tag] = ['fixed' => true];
            } else {
                $fixed = property_exists($tag, 'fixed') ? $tag->fixed : false;
                $tags[$tag->id] = ['fixed' => $fixed];
            }
        }

        $dokument->tags()->sync($tags);
        $dokument->freigabe = $request->freigabe;

        $models = json_decode($request->models);
        foreach ($models as $key => $value) {
            $klasse = 'App\Models\\' . $key;
            $dbmodel = $klasse::find($value);
            $dbmodel->dokumente()->save($dokument);
        }

        // $dokument = Dokument::find($request->dokument);

        return response()->json(['success' => 'File stored from model.']);
    }

    public function move(Request $request)
    {

        $dokument = Dokument::find($request->dokument);

        $removeModels = json_decode($request->get('removedModels'));
        foreach ($removeModels as $key => $value) {
            $klasse = 'App\Models\\' . $key;
            $dbmodel = $klasse::find($value);
            $dbmodel->dokumente()->detach($dokument);
        }

        $addedTags = json_decode($request->get('addedTags'));

        $tags = [];
        foreach ($addedTags as $tag) {
            if (is_numeric($tag)) {
                $tags[$tag] = ['fixed' => true];
            } else {
                $fixed = property_exists($tag, 'fixed') ? $tag->fixed : false;
                $tags[$tag->id] = ['fixed' => $fixed];
            }
        }

        $dokument->tags()->sync($tags);

        $dokument->freigabe = $request->freigabe;

        $addedModels = json_decode($request->get('addedModels'));
        foreach ($addedModels as $key => $value) {
            $klasse = 'App\Models\\' . $key;
            $dbmodel = $klasse::find($value);
            $dbmodel->dokumente()->save($dokument);
        }

        $dok = Dokument::find($dokument->id);

        return response()->json(['success' => 'File uploaded successfully.', 'dokument' => $dok]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dokument $dokument)
    {

        $user_id = Auth::id();
        $authorized = true;

        if ($user_id && $dokument && $authorized) {

            Storage::disk('public')->delete($dokument->path);
            Storage::disk('public')->delete($dokument->thumb);
            $dokument->tags()->detach();
            $dokument->delete();

            return response()->json([
                'success' => 'Dokument gelöscht.',
                'id' => $dokument->id,
            ]);
        }
    }
}
