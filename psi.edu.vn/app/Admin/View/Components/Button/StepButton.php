<?php

namespace App\Admin\View\Components\Button;

use Illuminate\View\Component;

class StepButton extends Component
{
    public string $from;
    public string $to;
    public string $variant;
    public ?string $label;

    public function __construct(string $from, string $to, ?string $label = null, string $variant = 'primary')
    {
        $this->from = $from;
        $this->to = $to;
        $this->label = $label;
        $this->variant = $variant;
    }

    public function render()
    {
        return view('components.button.step-button');
    }
}
