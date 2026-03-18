<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuccessInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $didSucceed,
        public int $sumOfCredits = 0,
        public string $overallGrade = '',
        public string $rating = '',
        public string $reasoning = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('pdf.components.success-info');
    }
}
