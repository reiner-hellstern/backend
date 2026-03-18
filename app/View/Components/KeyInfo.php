<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KeyInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $jsonString = '') {}

    private function prepareData(): array
    {
        return json_decode($this->jsonString, true);
        // return [
        //     [// Block 1
        //         [// Line 1
        //             [// Sides
        //                 // Side 1
        //                 ["Label A" => "Text A"],
        //                 // Side 2
        //                 ["Label B1" => "Text B1"],
        //             ],
        //         ],
        //         [// Line 2
        //             [// Sides
        //                 // Side 1
        //                 ["Label C" => "Text C"],
        //                 // Side 2
        //                 ["Label D" => "Text D"]
        //             ],
        //         ],
        //     ],
        //     [// Block 2
        //         [// Line 1
        //             [// Sides
        //                 // Side 1
        //                 ["Label E" => "Text E"],
        //                 // Side 2
        //                 ["Label F" => "Text F"]
        //             ],
        //         ],
        //         [// Line 2
        //             [// Sides
        //                 // Side 1
        //                 ["Label G" => "Text G"],
        //                 // Side 2
        //                 ["Label H" => "Text H"]
        //             ],
        //         ],
        //     ],
        // ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('pdf.components.key-info', [
            'blocks' => $this->prepareData(),
        ]);
    }
}
