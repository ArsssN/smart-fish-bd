<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Imports\InviteeImport;
use App\Jobs\InviteeImportJob;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InviteeImportJobHelper extends Controller
{
    protected $inviteeData;
    protected $filePath;

    /**
     * @return $this
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function readExcel(): InviteeImportJobHelper
    {
        $this->filePath    = public_path(request()->get('file'));
        $this->inviteeData = \Excel::toCollection(new InviteeImport, $this->filePath);

        return $this;
    }

    /**
     * @return JsonResponse|void
     */
    public function job()
    {
        try {
            $event = Event::query()->findOrFail(request()->get('event_id'));

            dispatch(new InviteeImportJob($this->inviteeData[0]->toArray(), $event));
        }
        catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
