<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionController extends Controller
{
    public function index()
    {
        return JsonResource::collection(Section::orderBy('name')->get());
    }
}
