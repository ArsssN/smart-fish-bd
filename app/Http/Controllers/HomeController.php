<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function __invoke(): Factory|View|Application
    {
        $contact_info = json_decode(Setting::get('contact_info'))[0] ?? new \stdClass();
        $socials = Social::query()->where('status', '=', 'active')->get();

        return view('welcome', compact('socials', 'contact_info'));
    }
}
