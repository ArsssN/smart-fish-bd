<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageMutator
{
    protected $destination_path = '';

    /**
     * @param $value
     * @param string $attribute_name
     */
    public function saveImage($value, $attribute_name = "image")
    {
        $model                   = $this;
        $model->destination_path = config('backpack.base.root_disk_base')
                                   . 'images/'
                                   . strtolower(class_basename(get_class($model)));

        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name', 'public_uploads');
        // destination path relative to the disk above
        $destination_path = $model->destination_path ?? config('backpack.base.root_disk_base');


        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            Storage::disk($disk)->delete('public' . $model->{$attribute_name});

            // set null in the database column
            $model->attributes[$attribute_name] = null;
        }

        if (Str::startsWith($value, 'data:image') || true) {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value . time()) . '.jpg';

            // 2. Store the image on disk.
            Storage::disk('public_uploads')->put($destination_path . '/' . $filename, $image->stream());

            //if not static image
            $oldImage = $model->{"old_" . $attribute_name} ?? $model->{$attribute_name};
            if ($model->{"old_" . $attribute_name} !== 'backend/image/no-preview.png' && $oldImage) {
                // 3. Delete the previous image, if there was one.
                // Storage::disk($disk)->delete('public' . $model->{"old_" . $attribute_name});
                Storage::disk($disk)->delete('public' . $oldImage);
            }
            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path            = Str::replaceFirst('public/', '', $destination_path);
            $model->attributes[$attribute_name] = '/uploads/' . $public_destination_path . '/' . $filename;
        }
    }
}
