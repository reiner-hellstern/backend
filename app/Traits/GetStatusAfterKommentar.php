<?php

namespace App\Traits;

use App\Models\OptionAntragStatus;

trait GetStatusAfterKommentar
{
    public function getStatusAfterKommentar($model, $antragsteller)
    {

        $status_id = 0;
        $status_name = '';

        switch ($model) {
            case 'Uebernahmeantrag':
                $status_id = $antragsteller ? 31 : 30;
                $status_name = OptionAntragStatus::where('id', $status_id)->first()->name;
                break;
            case 'Zuchtzulassungsantrag':
                $status_id = $antragsteller ? 31 : 30;
                $status_name = OptionAntragStatus::where('id', $status_id)->first()->name;
                break;
            case 'Hundanlageantrag':
                $status_id = $antragsteller ? 31 : 30;
                $status_name = OptionAntragStatus::where('id', $status_id)->first()->name;
                break;
        }

        return [
            'id' => $status_id,
            'name' => $status_name,
        ];
    }
}
