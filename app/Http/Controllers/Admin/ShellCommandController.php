<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ShellHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

class ShellCommandController extends Controller
{
    /**
     * @param string|null $command
     * @return string
     */
    public function call(string $command): string
    {
        $thisUrl = url()->current();
        $lastUrl = url()->previous();

        $url = $lastUrl !== $thisUrl
            ? $lastUrl
            : '/';

        $command        = base64_decode($command);
        $commandBuilder = ShellHelper::add($command)->addBackButton($url);
        $res            = $commandBuilder->run();

        Log::info('$command >>> '.$command);
        Log::info('$res >>> '.$res);

        Alert::info('Command executed successfully!')->flash();

        if (!!request()->autoRedirect) {
            Redirect::to($url)->send();
        }

        return $res;
    }

    /**
     * @return string
     */
    public function stash(): string
    {
        $command = base64_encode(' git stash ');
        //$command = null;

        return $this->call($command);
    }

    /**
     * @return string
     */
    public function status(): string
    {
        $command = base64_encode(' git status ');

        return $this->call($command);
    }

    /**
     * @return string
     */
    public function pull(): string
    {
        $command = base64_encode(' git pull ');

        return $this->call($command);
    }

    /**
     * @param bool $call
     * @return string
     */
    public function commit(bool $call = true): string
    {
        $thisUrl       = url()->current();
        $commitMessage = "Auto commit -- at: " . date('Y-m-d H:i:s') . " -- by: "
                         . backpack_auth()->user()->name . " -- IP: " . request()->ip() . " -- from: $thisUrl.";

        $command       = " git add . && git commit -m \"$commitMessage\" ";
        $commandBase64 = base64_encode($command);

        return $call
            ? $this->call($commandBase64)
            : $command;
    }

    /**
     * @param bool $call
     * @return string
     */
    public function push(bool $call = true): string
    {
        $command       = " git push ";
        $commandBase64 = base64_encode($command);

        return $call
            ? $this->call($commandBase64)
            : $command;
    }

    /**
     * @return string
     */
    public function commitPush(): string
    {
        $command       = $this->commit(false) . " && " . $this->push(false);
        $commandBase64 = base64_encode($command);

        return $this->call($commandBase64);
    }

    /**
     * @return string
     */
    public function migrateFreshSeed(): string
    {
        $command       = " php artisan migrate:fresh --seed ";
        $commandBase64 = base64_encode($command);

        return $this->call($commandBase64);
    }

    /**
     * @return string
     */
    public function config(): string
    {
        $command       = " git config user.name '" . backpack_auth()->user()->name . "' && git config user.email '" . "codegarage6@gmail.com" . "' ";
        $commandBase64 = base64_encode($command);

        return $this->call($commandBase64);
    }
}
