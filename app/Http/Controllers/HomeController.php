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
        $banner_images = json_decode(Setting::get('banner_images')) ?? [];
        $welcome_message = Setting::get('welcome_message') ?? '';
        $about = json_decode(Setting::get('about'))[0] ?? new \stdClass();
        $services = json_decode(Setting::get('services')) ?? [];
        $products = json_decode(Setting::get('products')) ?? [];
        $teams = json_decode(Setting::get('teams')) ?? [];

        $teamsGroup = (collect($teams))->reduce(function ($carry, $item) {
            switch ($item->designation) {
                case 'Consultant':
                    $carry->consultants[] = $item;
                    break;
                default:
                    $carry->technicals[] = $item;
            }
            return $carry;
        }, new \stdClass());
        //dd($contact_info, $banner_images, $welcome_message, $about, $services, $teams);

        $socials = Social::query()->where('status', '=', 'active')->get();

        return view(
            'welcome',
            compact(
                'socials',
                'contact_info',
                'banner_images',
                'welcome_message',
                'about',
                'services',
                'teams',
                'teamsGroup',
                'products'
            )
        );
    }
}
