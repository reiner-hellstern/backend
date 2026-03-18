<?php

namespace App\Traits;

use App\Models\Dokument;

trait SaveDokumente
{
    public function saveDokumente($model, $dokumente)
    {
        $db_dokuments = [];
        $dok_ids = [];

        foreach ($dokumente as $dokument) {
            $db_dokument = Dokument::find($dokument['id']);
            $db_dokuments[] = $db_dokument;
            $dok_ids[] = $db_dokument->id;
            $db_dokument->update($dokument);

            $tags = $dokument['tags'];
            $tag_ids = array_map(function ($tag) {
                return $tag['id'];
            }, $tags);
            $db_dokument->tags()->sync($tag_ids);
        }

        $model->dokumente()->sync($dok_ids);

    }
}
