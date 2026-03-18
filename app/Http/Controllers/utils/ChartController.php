<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{
    public static function saveImage(Request $request)
    {
        dd('asd');
        // throw new Exception("Error Processing Request", 1);

        // Storage::disk('public')->put('jessssir', 'test');

        // Base64-Bilddaten erhalten
        // $imageData = $request->input('image');

        // // Bilddaten vom "data:image/png;base64," Prefix befreien
        // $imageData = str_replace('data:image/png;base64,', '', $imageData);

        // // Decodierte Bilddaten
        // $imageData = base64_decode($imageData);

        // // Einen Namen für das Bild generieren
        // $imageName = 'chart_.png';

        // // Bild in einem öffentlichen Verzeichnis speichern
        // $path = Storage::disk('public')->put($imageName, $imageData);
        // dd("asd");

        // // Überprüfen, ob die Datei erfolgreich gespeichert wurde
        // if ($path) {
        //     return response()->json(['message' => 'Bild erfolgreich gespeichert!', 'image' => $imageName]);
        // } else {
        //     return response()->json(['message' => 'Fehler beim Speichern des Bildes'], 500);
        // }

    }
}
