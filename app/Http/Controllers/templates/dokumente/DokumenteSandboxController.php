<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\Controller;

class DokumenteSandboxController extends Controller
{
    public function show()
    {
        return view(
            'templates.dokumente.dokumente-sandbox',
            [],
        );
    }
}
