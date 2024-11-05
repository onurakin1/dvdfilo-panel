<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait SettingTrait
{
    /**
     * Update the user's profile photo.
     *
     * @param \Illuminate\Http\UploadedFile $photo
     * @return void
     */
    public function updateLogo(UploadedFile $photo)
    {
        tap(null, function ($previous) use ($photo) {
            $this->forceFill([
                'value' => '/uploads/' . $photo->storePublicly(
                        'logos', ['disk' => $this->logoDisk()]
                    ),
            ])->save();

//            if ($previous) {
//                Storage::disk($this->logoDisk())->delete($previous);
//            }
        });
    }


    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function logoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }

}
