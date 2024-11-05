<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dimension;
use App\Models\Project;
use App\Services\ReplicateService;
use BaconQrCode\Renderer\Color\Cmyk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Colors\Cmyk\Colorspace as CmykColorspace;
use Intervention\Image\Colors\Rgb\Colorspace as RgbColorspace;


class ProjectController extends Controller
{
    public function index($id = null)
    {

        $comboWefts = [
            ['id' => 1, 'name' => '32 / 48', 'disable' => true],
            ['id' => 2, 'name' => '40 / 50 ', 'disable' => false],
            ['id' => 3, 'name' => '42 / 60 ', 'disable' => true],
            ['id' => 4, 'name' => '48 / 65 ', 'disable' => true],
            ['id' => 5, 'name' => '70 / 80 ', 'disable' => true],
            ['id' => 6, 'name' => '100 / 100 ', 'disable' => true],
            ['id' => 7, 'name' => '120 / 120 ', 'disable' => true],
        ];

        if ($id) {
            $project = Project::find($id);
            $dimensions = Dimension::where('is_active',1)->orderBy('pixel_length', 'desc')->get();
            return inertia('Admin/Project/Index', ['project' => $project, 'dimensions' => $dimensions, 'comboWefts' => $comboWefts]);
        }

        $url = base64_decode(request()->query('url'));

        return inertia('Admin/Project/Index', ['comboWefts' => $comboWefts, 'url' => $url]);
    }

    public function create(Request $request)
    {

        $isHuman = $request->is_human;
        $reqUrl = $request->url;

        $request->validate([
            'file' => $reqUrl ? 'nullable' : 'required' . '|image|mimes:jpeg,png,jpg,gif,tiff,bmp',
            'prompt' => $isHuman == false ? 'required|string' : 'nullable|string',
            'a_prompt' => 'nullable|string',
            'n_prompt' => 'nullable|string',
            'url' => 'nullable|url|string'
        ]);

        if (!$reqUrl) {

            $file = $request->file('file');
            $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
        } else {
            $fileName = md5(time()) . '.png';
            $imageData = file_get_contents($reqUrl);
            file_put_contents(public_path('uploads/') . $fileName, $imageData);
        }

        $project = Project::create([
            'user_id' => auth()->id(),
            'image_path' => $fileName,
            'description' => $request->prompt,
            'prompt' => $request->prompt,
            'a_prompt' => $request->a_prompt,
            'n_prompt' => $request->n_prompt,
            'hough_status' => false,
            'canny_status' => false,
            'normal_status' => false,
            'hough_data' => [],
            'canny_data' => [],
            'normal_data' => [],
            'is_human' => $isHuman

        ]);

        $url = url('uploads/' . $project->image_path);

        if ($isHuman != true) {

            $hough = ReplicateService::predict($url, env('REPLICATE_HOUGH'), $request->prompt, $request->a_prompt, $request->n_prompt);
            $canny = ReplicateService::predict($url, env('REPLICATE_CANNY'), $request->prompt, $request->a_prompt, $request->n_prompt);
            $normal = ReplicateService::predict($url, env('REPLICATE_NORMAL'), $request->prompt, $request->a_prompt, $request->n_prompt);


            Log::info('hough', ['result' => $hough]);
            Log::info('canny', ['result' => $canny]);
            Log::info('normal', ['result' => $normal]);

            $project->hough_id = isset($hough['id']) ? $hough['id'] : null;
            $project->canny_id = isset($canny['id']) ? $canny['id'] : null;
            $project->normal_id = isset($normal['id']) ? $normal['id'] : null;
            $project->is_human = false;
            $project->product_count = rand(2000, 3000);
            $project->save();
        } else {


            $cannyArray[] = self::saveImage($url);
            $project->hough_data = $cannyArray;
            $project->is_human = true;
            $project->product_count = 0;

            $project->save();
        }

        return redirect()->route('backend.projects.id', $project->id)->with('success', 'File uploaded successfully');
    }

    public function update(Request $request, $id)
    {

        $project = Project::find($id);

        $url = url('uploads/' . $project->image_path);

        $hough = ReplicateService::predict($url, env('REPLICATE_HOUGH'), $request->prompt);
        $canny = ReplicateService::predict($url, env('REPLICATE_CANNY'), $request->prompt);
        $normal = ReplicateService::predict($url, env('REPLICATE_NORMAL'), $request->prompt);

        Log::info('hough', ['result' => $hough]);
        Log::info('canny', ['result' => $canny]);
        Log::info('normal', ['result' => $normal]);

        $project->hough_id = $hough['id'];
        $project->canny_id = $canny['id'];
        $project->normal_id = $normal['id'];
        $project->hough_status = false;
        $project->canny_status = false;
        $project->normal_status = false;
        $project->save();


        return redirect()->route('backend.projects.id', $project->id)->with('success', 'File uploaded successfully');
    }

    public function transactions()
    {
        $projects = Project::whereNotNull('hough_data')->latest()->limit(request()->limit ?? 50)->paginate(request()->page ?? 50);

        return inertia('Admin/Project/Transaction', ['projects' => $projects]);
    }

    public function download(Request $request)
    {
        ini_set('memory_limit', '-1');
        $type = $request->type == 'tiff' ? 'tif' : $request->type;
        $color = $request->color;
        $selectedItem = $request->selectedItem;
        $selectedOutput = $request->selectOutput;
        $pixelWidth = $request->manuel_width ?? $selectedOutput['pixel_width'];
        $pixelLength = $request->manuel_height ?? $selectedOutput['pixel_length'];
        $selectImage = basename($selectedItem);

        $imageName = $pixelWidth . 'x' . $pixelLength . '_' . str_replace('.png', '_output.' . $type, $selectImage);

        if ($type == 'tiff' || $type == 'tif') {
            $image = ImageManager::imagick()->read(public_path('uploads/outputs/' . $selectImage));
        } else {
            $image = ImageManager::gd()->read(public_path('uploads/outputs/' . $selectImage));
        }
        $image->resize($pixelWidth, $pixelLength);


        $image->text('META ID:' . rand(2000, 3000), $selectedOutput['pixel_width'] / 2, $selectedOutput['pixel_length'] / 2, function (FontFactory $font) {
            $font->filename(public_path('fonts/Arimo-Italic.ttf'));
            $font->color('#cbcbcb');
            $font->size(70);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
            $font->angle(25);
            $font->wrap(500);
        });


        if ($type == 'tiff' || $type == 'tif') {

             $image->setColorspace(new CmykColorspace());
            // $image->setColorspace(RgbColorspace::class);

            $image->toTiff();
            $image->setResolution(300, 300)->save(public_path('uploads/outputs/' .  $imageName));
        } else {
            $resolution = $image->resolution();
            $image->setResolution($resolution->x(), $resolution->y());
            $image->pixelate(0);
            $image->reduceColors($color);
            $image->toBitmap();
            $image->setColorspace(RgbColorspace::class);
            // $imageCore = $image->core()->native()->setImageInterpolateMethod(Imagick::INTERPOLATE_BILINEAR);

            $image->save(public_path('uploads/outputs/' .  $imageName));
        }


        session()->flash('image', url('uploads/outputs/' . $imageName));


        // resize to 300 x 200 pixel
        return   redirect()->back();
    }


    private static function saveImage($url)
    {
        // GuzzleHTTP istemcisini oluştur
        // Resmi indir
        $imageData = file_get_contents($url);
        $imageName = md5(microtime() . rand(0, 999999999999));
        // İndirilen resmi belirtilen yola kaydet
        file_put_contents(public_path('uploads/outputs/') . $imageName . '.png', $imageData);

        $dimensions = Dimension::query()->where('is_active',1)->get();
        foreach ($dimensions as $dimension) {
            $pixelWidth = $dimension->pixel_width;
            $pixelLength = $dimension->pixel_length;

            $image = ImageManager::imagick()->read(public_path('uploads/outputs/' . $imageName . '.png'));
            $image->resize($pixelWidth, $pixelLength)->save(public_path('uploads/outputs/' .  $imageName . '.png' . '_' . $pixelWidth . 'x' . $pixelLength . '.png'));
        }
        return $imageName . '.png';
    }
}
