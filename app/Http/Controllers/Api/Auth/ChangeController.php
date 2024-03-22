<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsAPIRequest;
use App\Http\Requests\UserPictureAPIRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChangeController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/v1/user/change/photo",
     *     operationId="changeProfilePicture",
     *     tags={"User"},
     *     summary="Change profile picture",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"photo"},
     *                 @OA\Property(property="photo", type="file", format="file"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile picture updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="photo", type="string", example="http://localhost:8000/uploads/user/profile/photo.jpg"),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Profile picture updated successfully"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     * @return JsonResponse
     */
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

    /**
     * @OA\Put(
     *     path="/api/v1/user/change/user-details",
     *     operationId="changeUserDetails",
     *     tags={"User"},
     *     summary="Change user details",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"first_name", "last_name", "farm_name", "phone", "address", "n_id_photos", "account_holder_id"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="farm_name", type="string", example="Doe Farm"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="address", type="string", example="Dhaka, Bangladesh"),
     *              @OA\Property(property="n_id_photos", type="string", example="n_id_photos.jpg"),
     *              @OA\Property(property="account_holder_id", type="string", example="John Doe"),
     *              @OA\Property(property="password", type="string", example="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User details updated successfully"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/v1/user/change/password",
     *     operationId="changePassword",
     *     tags={"User"},
     *     summary="Change password",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"password", "password_confirmation"},
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="password_confirmation", type="string", example="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Password updated successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     * @param UserPictureAPIRequest $request
     *
     * @return JsonResponse
     */
    public function changePassword(UserPictureAPIRequest $request)
    {
        $user = request()->user();

        try {
            $user->update([
                'password' => bcrypt(request()->input('password')),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
