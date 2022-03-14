<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $text;
    public $color;
    public $icon;
    public $type;

    public function __construct($text = "add", $color = "", $icon = "", $type = "")
    {
        $this->text = $text;
        $this->color = $color;
        $this->icon = $icon;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->updateButton();

        return view('components.button');
    }

    private function updateButton()
    {
        $this->type = $this->type ? $this->type : "submit";

        switch ($this->text) {
            case 'add':
                $this->text = "Ekle";
                $this->color = $this->color ? $this->color : "primary";
                $this->icon = $this->icon ? $this->icon : "plus";
                break;
            case 'edit':
                $this->text = "Güncelle";
                $this->color = $this->color ? $this->color : "success";
                $this->icon = $this->icon ? $this->icon : "edit";
                break;
            case 'show':
                $this->text = "Görüntüle";
                $this->color = $this->color ? $this->color : "warning";
                $this->icon = $this->icon ? $this->icon : "show";
                break;
            default:
                $this->color = "info";
                break;
        }
    }
}
