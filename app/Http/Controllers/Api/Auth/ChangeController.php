<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChangeController extends Controller
{
    public function changeProfilePicture()
    {
        $user = request()->user();

        try {
            $photo = request()->file('photo');
            $disk = 'uploads';
            $path = 'user/profile';
            $name = md5($user->id) . '_' . $photo->hashName();

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
                'photo' => $user->userDetails->photo,
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function changeUserDetails(UserDetailsAPIRequest $request): JsonResponse
    {
        // validate request
        try {
            $request->validated();

            $user = request()->user();
            $userDetails = $user->userDetails()->first();

            $update = [];

            if (request()->has('first_name')) {
                $update['first_name'] = request()->input('first_name');
            }

            if (request()->has('last_name')) {
                $update['last_name'] = request()->input('last_name');
            }

            if (request()->has('farm_name')) {
                $update['farm_name'] = request()->input('farm_name');
            }

            if (request()->has('phone')) {
                $update['phone'] = request()->input('phone');
            }

            if (request()->has('address')) {
                $update['address'] = request()->input('address');
            }

            if (request()->has('n_id_photos')) {
                $update['n_id_photos'] = request()->input('n_id_photos');
            }

            if (request()->has('account_holder_id')) {
                $update['account_holder_id'] = request()->input('account_holder_id');
            }

            $userDetails->update($update);

            if ($userDetails->wasChanged()) {
                $userDetails = $user->userDetails()->first();
            }

            if (request()->has('password')) {
                $user->update([
                    'password' => bcrypt(request()->input('password')),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'User details updated successfully',
                'user' => [$request, $user, $userDetails],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
