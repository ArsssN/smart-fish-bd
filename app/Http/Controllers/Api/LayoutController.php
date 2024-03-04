<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InvitationResource;
use App\Http\Resources\Api\InvitationUserProfileResource;
use App\Http\Resources\Api\PriceResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Event;
use App\Models\FooterLinkGroup;
use App\Models\Invitation;
use App\Models\Pricing;
use App\Models\Social;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LayoutController extends Controller
{
    /**
     * @var array|null
     */
    private ?array $meta;

    /**
     * @param string $layout
     * @param string|null $page
     * @return JsonResponse
     */
    public function getLayoutMeta(string $layout = 'landing', ?string $page = null)
    {
        $params = compact('page', 'layout');
        $this->footerMeta($params);
        $this->pageData($params);

        return response()->json($this->getMeta());
    }

    /**
     * @param string $layout
     * @param string|null $page
     * @return JsonResponse
     */
    public function getPageData(string $layout = 'landing', ?string $page = null)
    {
        $params = compact('page', 'layout');
        $this->pageData($params);

        return response()->json($this->getMeta());
    }

    /**
     * @param string $key
     * @param string|array|null $value
     * @return void
     */
    private function setMeta(string $key, string|array|null $value)
    {
        $this->meta[$key] = $value;
    }

    /**
     * @return array|null
     */
    private function getMeta(): ?array
    {
        return $this->meta;
    }

    /**
     * @param ...$args
     * @return void
     */
    private function footerMeta(...$args): void
    {
        $year     = now()->format('Y');
        $app_name = config('app.name');
        $response = [];

        $developer_name = config('app.developer_name');
        $developer_url  = config('app.developer_url');

        if (request()->first ?? 1) {
            $response['link_groups'] = FooterLinkGroup::query()->withWhereHas('footerLinks')->get();
            $response['socials']     = Social::query()->get();
            $response['copy_right']  =
                config('app.copy_right') ??
                "&copy; {$year} {$app_name} - All rights reserved.<br/>Developed by <a href='{$developer_url}' target='_blank'>{$developer_name}</a>";
        }

        $this->setMeta('footer', $response);
    }

    /**
     * @param ...$args
     * @return void
     */
    private function pageData(...$args): void
    {
        $response = [];

        if ($user = request()->user()) {
            $response['user'] = UserResource::make($user);
        }

        switch ($args[0]['page']) {
            case 'invitation':
                $invitation               = collect(json_decode(getSettingValue('invitation')));
                $response['what_it_does'] = $invitation[0];
                break;
            case 'contact-us':
                $contact_info             = collect(json_decode(getSettingValue('contact_info')));
                $response['contact_info'] = $contact_info[0];
                break;
            case 'about':
                $about             = json_decode(getSettingValue('about'))[0];
                $response['about'] = $about;
                break;
            case 'index':
            case 'home':
            case 'pricing':
            case 'pricing-purchase-slug':
                $response['pricings'] = PriceResource::collection(Pricing::query()->get());
                break;
            case 'terms-of-condition':
                $termsOfCondition               = json_decode(getSettingValue('terms_of_condition'))[0];
                $response['terms-of-condition'] = $termsOfCondition;
                break;
            case 'privacy-policy':
                $privacyPolicy              = json_decode(getSettingValue('privacy_policy'))[0];
                $response['privacy-policy'] = $privacyPolicy;
                break;
            case 'user-profile':
                $response['user-profile'] = [];
                break;
            case 'user-orders':
                $response['user-orders'] = [];
                break;
            case 'user-invitations':
                if ($user) {
                    $userInvitations = Invitation::query()
                        ->with('invitee')
                        ->orderBy(Event::query()->select('start_date')->whereColumn('id', 'event_id'))
                        ->whereHas('invitee.user', function ($query) use ($user) {
                            $query->where('id', $user->id);
                        });

                    $activeStatusSlug = request()->activeStatusSlug ?? 'active';
                    $userInvitations->whereHas('event', fn($query) => $query->where('status', $activeStatusSlug));

                    $userInvitations = $userInvitations->latest()->get();

                    $response['user-invitations'] = InvitationUserProfileResource::collection($userInvitations)
                        ->groupBy('event.status');
                } else {
                    $response['user-invitations'] = [];
                }
                break;
        }

        $this->setMeta('pageData', $response);
    }
}
