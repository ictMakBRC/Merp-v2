<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\HumanResource\Settings\CompanyProfile;

class ReportLayout extends Component
{
    public $organizationInfo;

    public function __construct()
    {
        $this->organizationInfo = CompanyProfile::first();
    }
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.report');
    }
}
