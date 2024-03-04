<?php

namespace App\Traits;

use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\RedirectResponse;

trait AboutSubmitTrait
{
    /**
     * @param ContactUsRequest $contactUs
     * @return RedirectResponse
     */
    public function contactUs(ContactUsRequest $contactUs): RedirectResponse
    {
        try {
            ContactUs::query()->create(
                $contactUs->except(['_token', 'captcha'])
            );
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }

}
