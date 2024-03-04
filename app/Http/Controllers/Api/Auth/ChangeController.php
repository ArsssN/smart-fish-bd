<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChangeController extends Controller
{
    /**
     * @param Request $request
     * @param string $type
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $type): JsonResponse
    {
        $type = Str::of($type)->camel()->ucfirst();
        return $this->{"change" . ucfirst($type)}($request);
    }

    public function changeProfilePicture()
    {
        $user = request()->user();

        try {
            $photo = request()->file('photo');
            $disk  = 'uploads';
            $path  = 'user/profile';
            $name  = md5($user->id) . '_' . $photo->hashName();

            // upload photo
            $photo->storeAs($path, $name, ['disk' => $disk]);

            // delete old photo
            if ($user->userDetails->photo) {
                Storage::disk('uploads')->delete("{$user->userDetails->photo}");
            }

            // update user photo
            $user->userDetails()->update([
                'photo' => url($disk, [...explode('/', $path), ...explode('/', $name)])
            ]);
            $user = $user->first();

            return response()->json([
                'photo'   => $user->userDetails->photo,
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'user'    => $user,
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
