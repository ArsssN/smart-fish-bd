<?php

namespace App\Helpers;

use App\Models\Event;
use App\Models\Invitee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvitationCardHelper
{
    private string $theme = 'default';
    private string $themeConfigTarget;
    private int    $width;
    private int    $height;

    private string|InterventionImage|Image $qrCode;

    private string $eventDir;
    private string $tempDir;
    private string $qrCodeDir;
    private string $qrCodePath;

    private Event   $event;
    private Invitee $invitee;
    private string  $invitationCode;

    private InterventionImage|Image $frontImage;

    /**
     * @param string $theme
     */
    public function __construct(string $theme = 'default')
    {
        $this->setTheme($theme);

        $this->width  = config("{$this->getThemeConfigTarget()}.dimension.width", 1062);
        $this->height = config("{$this->getThemeConfigTarget()}.dimension.height", 648);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return (new static)->$name(...$arguments);
    }

    /**
     * @param Event|Model|Builder $event
     * @param Invitee|Model|Builder $invitee
     * @param $invitationCode
     * @return string[]
     */
    public function generate(Event|Model|Builder $event, Invitee|Model|Builder $invitee, $invitationCode = null): array
    {
        $this->event   = $event;
        $this->invitee = $invitee;

        $eventId   = $this->event->getAttribute('id');
        $inviteeId = $this->invitee->getAttribute('id');

        $this->invitationCode = $invitationCode ?? createUniqueInvitationCode(8, $eventId, $inviteeId);

        // make url
        $url = config('app.frontend_base_url') . '/invitation?code=' . $this->invitationCode;

        // make QR code
        $this->qrCode = QrCode::format(config("{$this->getThemeConfigTarget()}.qr_code.format", 'png'))
            ->size(config("{$this->getThemeConfigTarget()}.qr_code.size", 200))
            ->generate($url);

        // save QR code
        $this->eventDir   = public_path('uploads/event/invitation/event-' . $eventId . '/');
        $this->tempDir    = $this->eventDir . 'temp/';
        $this->qrCodeDir  = $this->tempDir . $this->invitationCode . '/';
        $this->qrCodePath = $this->qrCodeDir . 'qr.png';

        $card = [
            'front' => $this->createFront(),
            'back'  => $this->createBack(),
        ];

        // delete temp directory
        if (File::exists($this->tempDir)) {
            File::deleteDirectory($this->tempDir);
        }

        return $card;
    }

    /**
     * @return string
     */
    private function createFront(): string
    {
        $eventId = $this->event->getAttribute('id');
        // $inviteeId = $this->invitee->getAttribute('id');

        if (!File::exists($this->qrCodeDir)) {
            File::makeDirectory($this->qrCodeDir, 0777, true, true);
        }

        File::put($this->qrCodePath, $this->qrCode);

        $this->frontImageProcess();

        // return image url
        return config('app.url') . '/uploads/event/invitation/event-' . $eventId . '/front/' . $this->invitationCode
               . '.png';
    }

    /**
     * @return void
     */
    public function frontImageProcess(): void
    {
        $backgroundPath = Image::make(config(
            "{$this->getThemeConfigTarget()}.front.background.image",
            public_path('uploads/event/tools/bg-default.jpg')
        ))->resize($this->width, $this->height);

        // make a blank image
        $image = Image::canvas($this->width, $this->height);

        // set background color to white
        $image->fill(config("{$this->getThemeConfigTarget()}.front.background.color", '#ffffff'));

        // resize QR code
        $this->qrCode = Image::make($this->qrCodePath)
            ->resize(
                config("{$this->getThemeConfigTarget()}.front.qr_code.width", 150),
                config("{$this->getThemeConfigTarget()}.front.qr_code.height", 150)
            );

        // add background image
        $image->insert(
            $backgroundPath,
            config("{$this->getThemeConfigTarget()}.front.background.position", 'top-left'),
            config("{$this->getThemeConfigTarget()}.front.background.x", 0),
            config("{$this->getThemeConfigTarget()}.front.background.y", 0)
        );

        // add QR code
        $image->insert(
            $this->qrCode,
            config("{$this->getThemeConfigTarget()}.front.qr_code.position", 'bottom-right'),
            config("{$this->getThemeConfigTarget()}.front.qr_code.x", 20),
            config("{$this->getThemeConfigTarget()}.front.qr_code.y", 20)
        );

        // add event title left top
        $lines  = explode("\n", wordwrap(
            $this->event->getAttribute('title'),
            config(
                "{$this->getThemeConfigTarget()}.front.event_title.wrap_after",
                18
            )
        ));
        $size   = config(
            "{$this->getThemeConfigTarget()}.front.event_title.font.size",
            60
        );
        $offset = (count($lines) - 1) * $size;
        foreach ($lines as $key => $line) {
            $image->text(
                trim($line),
                config("{$this->getThemeConfigTarget()}.front.event_title.x", 20),
                config("{$this->getThemeConfigTarget()}.front.event_title.y", 20) + ($size * $key),
                function ($font) use ($size) {
                    $font->file(config(
                        "{$this->getThemeConfigTarget()}.front.event_title.font.file",
                        public_path('fonts/Roboto/Roboto-Regular.ttf')
                    ));
                    $font->size($size);
                    $font->color(config(
                        "{$this->getThemeConfigTarget()}.front.event_title.font.color",
                        '#000'
                    ));
                    $font->align(config(
                        "{$this->getThemeConfigTarget()}.front.event_title.font.align",
                        'left'
                    ));
                    $font->valign(config(
                        "{$this->getThemeConfigTarget()}.front.event_title.font.valign",
                        'top'
                    ));
                }
            );
        }

        // add event start date
        $image->text(
            Carbon::parse($this->event->getAttribute('start_date'))
                ->format(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.format",
                    'M d, Y - h:ma'
                )),
            config("{$this->getThemeConfigTarget()}.front.event_start_date.x", 20),
            config("{$this->getThemeConfigTarget()}.front.event_start_date.y", 90) + $offset,
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.front.event_start_date.font.valign",
                    'top'
                ));
            });

        // add event end date
        $image->text(
            Carbon::parse($this->event->getAttribute('end_date'))
                ->format(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.format",
                    'M d, Y - h:ma'
                )),
            config("{$this->getThemeConfigTarget()}.front.event_end_date.x", 20),
            config("{$this->getThemeConfigTarget()}.front.event_end_date.y", 120) + $offset,
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.front.event_end_date.font.valign",
                    'top'
                ));
            });

        // add event location
        $lines = explode("\n", wordwrap(
            $this->event->getAttribute('location'),
            config(
                "{$this->getThemeConfigTarget()}.front.event_location.wrap_after",
                50
            )
        ));
        $size  = config(
            "{$this->getThemeConfigTarget()}.front.event_location.font.size",
            25
        );
        foreach ($lines as $key => $line) {
            $image->text(
                trim($line),
                config("{$this->getThemeConfigTarget()}.front.event_location.x", 20),
                config("{$this->getThemeConfigTarget()}.front.event_location.y", 150) + ($size * $key) + $offset,
                function ($font) use ($size) {
                    $font->file(config(
                        "{$this->getThemeConfigTarget()}.front.event_location.font.file",
                        public_path('fonts/Roboto/Roboto-Regular.ttf')
                    ));
                    $font->size($size);
                    $font->color(config(
                        "{$this->getThemeConfigTarget()}.front.event_location.font.color",
                        '#000'
                    ));
                    $font->align(config(
                        "{$this->getThemeConfigTarget()}.front.event_location.font.align",
                        'left'
                    ));
                    $font->valign(config(
                        "{$this->getThemeConfigTarget()}.front.event_location.font.valign",
                        'top'
                    ));
                }
            );
        }

        // add invitee name right top
        $lines = explode("\n", wordwrap(
            $this->invitee->getAttribute('name'),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_name.wrap_after",
                15
            )
        ));
        $size  = config(
            "{$this->getThemeConfigTarget()}.front.invitee_name.font.size",
            60
        );
        foreach ($lines as $key => $line) {
            $image->text(
                trim($line),
                config(
                    "{$this->getThemeConfigTarget()}.front.invitee_name.x",
                    config("{$this->getThemeConfigTarget()}.dimension.width") - 20
                ),
                config("{$this->getThemeConfigTarget()}.front.invitee_name.y", 20) + $size * $key,
                function ($font) use ($size) {
                    $font->file(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_name.font.file",
                        public_path('fonts/Roboto/Roboto-Regular.ttf')
                    ));
                    $font->size($size);
                    $font->color(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_name.font.color",
                        '#000'
                    ));
                    $font->align(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_name.font.align",
                        'right'
                    ));
                    $font->valign(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_name.font.valign",
                        'top'
                    ));
                });
        }

        // add invitee address
        $lines     = explode("\n", wordwrap(
            $this->invitee->getAttribute('address'),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_address.wrap_after",
                50
            )
        ));
        $size      = config(
            "{$this->getThemeConfigTarget()}.front.invitee_address.font.size",
            25
        );
        $lastLineY = config(
            "{$this->getThemeConfigTarget()}.front.invitee_address.y",
            config("{$this->getThemeConfigTarget()}.dimension.height") - 30 - 30 - 45
        );
        foreach ($lines as $key => $line) {
            $image->text(
                trim($line),
                config(
                    "{$this->getThemeConfigTarget()}.front.invitee_address.x",
                    20
                ),
                $lastLineY + $size * $key - (count($lines) - 1) * $size,
                function ($font) use ($size) {
                    $font->file(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_address.font.file",
                        public_path('fonts/Roboto/Roboto-Regular.ttf')
                    ));
                    $font->size($size);
                    $font->color(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_address.font.color",
                        '#000'
                    ));
                    $font->align(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_address.font.align",
                        'left'
                    ));
                    $font->valign(config(
                        "{$this->getThemeConfigTarget()}.front.invitee_address.font.valign",
                        'top'
                    ));
                }
            );
        }

        // add invitee phone
        $image->text($this->invitee->getAttribute('phone'),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_phone.x",
                20
            ),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_phone.y",
                config("{$this->getThemeConfigTarget()}.dimension.height") - 30 - 45
            ),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_phone.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_phone.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_phone.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_phone.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_phone.font.valign",
                    'top'
                ));
            });

        // add invitee email
        $image->text($this->invitee->getAttribute('email'),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_email.x",
                20
            ),
            config(
                "{$this->getThemeConfigTarget()}.front.invitee_email.y",
                config("{$this->getThemeConfigTarget()}.dimension.height") - 45
            ),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_email.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_email.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_email.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_email.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.front.invitee_email.font.valign",
                    'top'
                ));
            });

        // image dir
        $cardDir = $this->eventDir . 'front/';
        if (!File::exists($cardDir)) {
            File::makeDirectory($cardDir, 0777, true, true);
        }
        // save image
        $path = $cardDir . $this->invitationCode . '.png';
        $image->save($path);
    }

    /**
     * @return string
     */
    private function createBack(): string
    {
        $eventId = $this->event->getAttribute('id');
        // $inviteeId = $this->invitee->getAttribute('id');

        // if (!File::exists($this->qrCodeDir)) {
        //     File::makeDirectory($this->qrCodeDir, 0777, true, true);
        // }

        //File::put($this->qrCodePath, $this->qrCode);

        $this->backImageProcess();

        // return image url
        return config('app.url') . '/uploads/event/invitation/event-' . $eventId . '/back/' . $this->invitationCode
               . '.png';
    }

    /**
     * @return void
     */
    public function backImageProcess(): void
    {
        $backgroundPath = Image::make(config(
            "{$this->getThemeConfigTarget()}.back.background.image",
            public_path('uploads/event/tools/bg-default.jpg')
        ))->resize($this->width, $this->height);

        // make a blank image
        $image = Image::canvas($this->width, $this->height);

        // set background color to white
        $image->fill(config("{$this->getThemeConfigTarget()}.back.background.color", '#ffffff'));

        // resize QR code
        $this->qrCode = Image::make($this->qrCodePath)
            ->resize(
                config("{$this->getThemeConfigTarget()}.back.qr_code.width", 150),
                config("{$this->getThemeConfigTarget()}.back.qr_code.height", 150)
            );

        // add background image
//        $image->insert(
//            $backgroundPath,
//            config("{$this->getThemeConfigTarget()}.back.background.position", 'top-left'),
//            config("{$this->getThemeConfigTarget()}.back.background.x", 0),
//            config("{$this->getThemeConfigTarget()}.back.background.y", 0)
//        );

        // add QR code
        $image->insert(
            $this->qrCode,
            config("{$this->getThemeConfigTarget()}.back.qr_code.position", 'bottom-right'),
            config("{$this->getThemeConfigTarget()}.back.qr_code.x", 20),
            config("{$this->getThemeConfigTarget()}.back.qr_code.y", 20)
        );

        // add name left top
        $image->text(
            $this->event->getAttribute('title'),
            config("{$this->getThemeConfigTarget()}.back.event_title.x", 20),
            config("{$this->getThemeConfigTarget()}.back.event_title.y", 20),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.event_title.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.event_title.font.size",
                    60
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.event_title.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.event_title.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.event_title.font.valign",
                    'top'
                ));
            }
        );

        // add event start date
        $image->text(
            Carbon::parse($this->event->getAttribute('start_date'))
                ->format(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.format",
                    'M d, Y - h:ma'
                )),
            config("{$this->getThemeConfigTarget()}.back.event_start_date.x", 20),
            config("{$this->getThemeConfigTarget()}.back.event_start_date.y", 90),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.event_start_date.font.valign",
                    'top'
                ));
            });

        // add event end date
        $image->text(
            Carbon::parse($this->event->getAttribute('end_date'))
                ->format(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.format",
                    'M d, Y - h:ma'
                )),
            config("{$this->getThemeConfigTarget()}.back.event_end_date.x", 20),
            config("{$this->getThemeConfigTarget()}.back.event_end_date.y", 120),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.event_end_date.font.valign",
                    'top'
                ));
            });

        // add event location
        $image->text(
            $this->event->getAttribute('location'),
            config("{$this->getThemeConfigTarget()}.back.event_location.x", 20),
            config("{$this->getThemeConfigTarget()}.back.event_location.y", 150),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.event_location.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.event_location.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.event_location.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.event_location.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.event_location.font.valign",
                    'top'
                ));
            });

        // add invitee name right top
        $image->text(
            $this->invitee->getAttribute('name'),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_name.x",
                config("{$this->getThemeConfigTarget()}.dimension.width") - 20
            ),
            config("{$this->getThemeConfigTarget()}.back.invitee_name.y", 20),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_name.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_name.font.size",
                    60
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_name.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_name.font.align",
                    'right'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_name.font.valign",
                    'top'
                ));
            });

        // add invitee address
        $image->text($this->invitee->getAttribute('address'),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_address.x",
                20
            ),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_address.y",
                config("{$this->getThemeConfigTarget()}.dimension.height") - 30 - 30 - 45
            ),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_address.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_address.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_address.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_address.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_address.font.valign",
                    'top'
                ));
            });

        // add invitee phone
        $image->text($this->invitee->getAttribute('phone'),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_phone.x",
                20
            ),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_phone.y",
                config("{$this->getThemeConfigTarget()}.dimension.height") - 30 - 45
            ),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_phone.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_phone.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_phone.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_phone.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_phone.font.valign",
                    'top'
                ));
            });

        // add invitee email
        $image->text($this->invitee->getAttribute('email'),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_email.x",
                20
            ),
            config(
                "{$this->getThemeConfigTarget()}.back.invitee_email.y",
                config("{$this->getThemeConfigTarget()}.dimension.height") - 45
            ),
            function ($font) {
                $font->file(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_email.font.file",
                    public_path('fonts/Roboto/Roboto-Regular.ttf')
                ));
                $font->size(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_email.font.size",
                    25
                ));
                $font->color(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_email.font.color",
                    '#000'
                ));
                $font->align(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_email.font.align",
                    'left'
                ));
                $font->valign(config(
                    "{$this->getThemeConfigTarget()}.back.invitee_email.font.valign",
                    'top'
                ));
            });

        // image dir
        $cardDir = $this->eventDir . 'back/';
        if (!File::exists($cardDir)) {
            File::makeDirectory($cardDir, 0777, true, true);
        }
        // save image
        $path = $cardDir . $this->invitationCode . '.png';
        $image->save($path);
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
        $this->setThemeConfigTarget();
    }

    /**
     * @return string
     */
    public function getThemeConfigTarget(): string
    {
        return $this->themeConfigTarget;
    }

    /**
     * @return void
     */
    public function setThemeConfigTarget(): void
    {
        $this->themeConfigTarget = "event.themes.{$this->getTheme()}";
    }
}
