<?php

namespace App\Http\Controllers;

use App\Models\Tag; // Add the missing 'use' statement for the Tag model
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Zeigt eine Liste der Ressourcen an.
     */
    public function index()
    {
        $tags = Tag::all();

        // Gibt die Baumstruktur zurück
        return $tags;
    }

    /**
     * Erzeugt die Baumstruktur aus dem flachen Array der Tags.
     */
    public function tree()
    {

        $tags = Tag::all()->toArray();

        $tree = $this->buildTree($tags, 0);

        // Gibt die Baumstruktur zurück
        return $tree;
    }

    /**
     * Baut die Baumstruktur aus dem flachen Array der Tags.
     */
    private function buildTree($tags, $ebene, $parentId = null)
    {
        $tree = [];

        foreach ($tags as $tag) {
            $tag['ebene'] = $ebene;
            if ($tag['parent_id'] == $parentId) {
                $children = $this->buildTree($tags, $ebene + 1, $tag['id']);
                if ($children) {
                    $tag['children'] = $children;
                }
                $tree[] = $tag;

                $modeltag = Tag::find($tag['id']);
                $modeltag->ebene = $ebene;
                $modeltag->save();  // Hier wird die Ebene um 1 erhöht und gespeichert
            }
        }

        return $tree;
    }

    /**
     * Speichert eine neu erstellte Ressource.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Zeigt die angegebene Ressource an.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Aktualisiert die angegebene Ressource.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Entfernt die angegebene Ressource.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
