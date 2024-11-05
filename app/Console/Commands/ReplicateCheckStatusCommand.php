<?php

namespace App\Console\Commands;

use App\Models\Dimension;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class ReplicateCheckStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicate:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of the replicate models for the projects in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Log::info('ReplicateCheckStatusCommand', ['message' => 'ReplicateCheckStatusCommand started']);

        $projects = \App\Models\Project::query()
            ->whereNotNull('hough_id')
            ->where('is_human', false)
            ->where(function ($query) {
                $query->orWhere('hough_status', false)
                    ->orWhere('canny_status', false)
                    ->orWhere('normal_status', false);
            })
            ->get();


        foreach ($projects as $project) {
            if ($project->hough_id && $project->hough_status == false) {
                $hough = \App\Services\ReplicateService::checkStatus($project->hough_id, env('REPLICATE_HOUGH'));

                if ($hough['status'] == 'succeeded' || $hough['status'] == 'failed') {

                    $houghArray = $project->hough_data;

                    if (isset($hough['output'])) {
                        foreach ($hough['output'] as $key => $value) {
                            if ($key > 0) {
                                $houghArray[] = self::saveImage($value);
                            }
                        }
                    }


                    $project->hough_status = true;
                    $project->hough_data = $houghArray;
                    $project->save();
                    event(new \App\Events\ReplicateEvent());
                }
            }

            if ($project->canny_id && $project->canny_status == false) {
                $canny = \App\Services\ReplicateService::checkStatus($project->canny_id, env('REPLICATE_CANNY'));

                if ($canny['status'] == 'succeeded' || $canny['status'] == 'failed') {
                    $cannyArray = $project->canny_data;

                    if (isset($canny['output'])) {
                        foreach ($canny['output'] as $key => $value) {
                            if ($key > 0) {
                                $cannyArray[] = self::saveImage($value);
                            }
                        }
                    }

                    $project->canny_status = true;
                    $project->canny_data = $cannyArray;
                    $project->save();
                    event(new \App\Events\ReplicateEvent());
                }
            }

            if ($project->normal_id && $project->normal_status == false) {
                $normal = \App\Services\ReplicateService::checkStatus($project->normal_id, env('REPLICATE_NORMAL'));

                if ($normal['status'] == 'succeeded' || $normal['status'] == 'failed') {
                    $normalArray = $project->normal_data;

                    if (isset($normal['output'])) {
                        foreach ($normal['output'] as $key => $value) {
                            if ($key > 0) {
                                $normalArray[] = self::saveImage($value);
                            }
                        }
                    }

                    $project->normal_status = true;
                    $project->normal_data = $normalArray;
                    $project->save();
                    event(new \App\Events\ReplicateEvent());
                }
            }
        }


        Command::SUCCESS;
    }

    private static function saveImage($url)
    {
        // GuzzleHTTP istemcisini oluştur
        // Resmi indir
        $imageData = file_get_contents($url);
        $imageName = md5(microtime() . rand(0, 999999999999));
        // İndirilen resmi belirtilen yola kaydet
        file_put_contents(public_path('uploads/outputs/') . $imageName . '.png', $imageData);

        $dimensions = Dimension::query()->get();
        foreach ($dimensions as $dimension) {
            $pixelWidth = $dimension->pixel_width;
            $pixelLength = $dimension->pixel_length;

            $image = ImageManager::imagick()->read(public_path('uploads/outputs/' . $imageName . '.png'));
            $image->resize($pixelWidth, $pixelLength)->save(public_path('uploads/outputs/' .  $imageName . '.png' . '_' . $pixelWidth . 'x' . $pixelLength . '.png'));
        }
        return $imageName . '.png';
    }
}
