<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Breadcrumb extends Component
{
	public $title;
	public $breadcrumburl;
	public $breadcrumbtitle;

	public function render()
    {
        return view('livewire.breadcrumb');
    }
}
