<?php

namespace App\Helpers;

class ShellHelper
{
    protected static string $command         = '';
    protected static string $commandResponse = '';
    protected static string $backButtonUrl   = '';
    protected static bool   $isBackButton    = false;
    protected static bool   $isStyled        = true;
    protected static string $styles          = '';

    /**
     * @param string|null $command
     * @return bool|string|null
     */
    public static function run(string $command = null): bool|string|null
    {
        self::$styles = self::getStyles();
        $command      = $command ?? self::$command;

        self::$commandResponse = shell_exec("$command 2>&1") ?? '';

        if (self::$isStyled) {
            self::$commandResponse = self::styled();
        }

        return self::$commandResponse;
    }

    /**
     * @param bool $styled
     * @return static
     */
    public static function style(bool $styled = true): static
    {
        self::$isStyled = $styled;
        return new static;
    }

    /**
     * @return string
     */
    private static function styled(): string
    {
        $backButton = '';
        if (self::$isBackButton) {
            $backButton = self::backButton();
        }
        return "<pre class='code-root'>"
               . "<div class='code-container'>"
               . self::$commandResponse
               . "</div>"
               . $backButton
               . "</pre>"
               . self::$styles;
    }

    /**
     * @param string|null $url
     * @return static
     */
    public static function addBackButton(string $url = null): static
    {
        self::$backButtonUrl = $url ?? '/';
        self::$isBackButton  = true;

        return new static;
    }

    /**
     * @return string
     */
    private static function backButton(): string
    {
        return "<div class='action-button-container'><a class='back' href='"
               . self::$backButtonUrl
               . "'>&lt; Back</a><a class='home' href='/'>^ Home</a></div>";
    }

    /**
     * @param $cmd
     * @return static
     */
    public static function add($cmd): static
    {
        if (!$cmd) {
            return new static;
        }

        if (self::$command) {
            self::$command .= ' && ';
        } else {
            self::$command .= 'cd ../ && ';
        }

        self::$command .= $cmd;

        return new static;
    }

    /**
     * @return string
     */
    public static function get(): string
    {
        return self::$command;
    }

    /**
     * @return string
     */
    public static function getStyles(): string
    {
        $styles = '';
        if (self::$isStyled) {
            $styles = '<style>' . file_get_contents(public_path('assets/css/shell.css')) . '</style>';
        }

        return $styles;
    }
}
