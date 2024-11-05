<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DigitalSignaItem;
use App\Models\File;
use App\Models\Group;
use App\Repositories\Eloquent\Interfaces\FileRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Throwable;

class FileController extends Controller
{
    protected FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $files = $this->fileRepository->paginate($request);
        return Inertia::render('Admin/File/Index', ['files' => $files]);
    }

    public function get_modal_files(Request $request)
    {
        $files = $this->fileRepository->paginate($request, null, true, 40);
        return $files;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $requestKeys = collect($request->all())->keys();

        try {
            $now = Carbon::now();
            $path = "/{$now->year}/{$now->month}";

            if (gettype($request['image']) == 'array') {
                $file = self::check_array($request[$requestKeys[0]]);
            } else {
                $file = $request['image'];
            }

            $image_resolution = getimagesize($file);

            $size = round($file->getSize() / 1024, 4);
            $mime_type = $file->getMimeType();

            $getExtension = $file->getClientOriginalExtension();
            $file_ext = Str::lower($getExtension);

            if (!$getExtension) {
                $file_ext = explode('/', $mime_type)[1];
            }

            if (General::check_mime($file_ext)) {
                $file_name = self::file_direct_upload($file, $path, md5($request->name . time()));
                $attributes = [
                    'author_id' => Auth::id(),
                    'path' => $file_name,
                    'full_name' => Str::afterLast($file_name, '/'),
                    'slug' => Str::before(Str::afterLast($file_name, '/'), '.'),
                    'type' => $requestKeys[0] == "image" ? "default" : $requestKeys[0],
                    'size' => $size,
                    'resolution' => $image_resolution ? $image_resolution[0] . 'x' . $image_resolution[1] : 'video',
                    'mime_type' => $mime_type
                ];


                if ($request->type == 'branch') {
                    $group = Branch::find(request()->group_id);

                    $sliderData = ['order' => 1, 'image_url' => url($file_name)]; // Eklemek istediğiniz slider verisi
                    $item_id = $request->item_id;
                    $group->addSliderToScreen($item_id, $sliderData);
                } else {
                    $group = Group::find(request()->group_id);

                    $sliderData = ['order' => 1, 'image_url' => url($file_name)]; // Eklemek istediğiniz slider verisi
                    $item_id = $request->item_id;
                    $group->addSliderToScreen($item_id, $sliderData);
                }



                return $group->id;
            } else {
                throw new Exception($file_ext . ' Dosya türü desteklenmiyor.', 1);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function file_direct_upload(UploadedFile $file, $folder, $file_name = null)
    {
        try {
            $file_name_ext = str_replace('blob', $file_name . '-', $file->getClientOriginalName());
            $file_name = Str::slug(pathinfo($file_name_ext, PATHINFO_FILENAME) . '_' . now());
            $file_ext = $file->getClientOriginalExtension();
            $file_ext = Str::lower($file_ext);
            $mime_type = $file->getMimeType();

            if (!$file_ext) {
                $file_ext = explode('/', $mime_type)[1];
            }


            $file_name = "{$file_name}.{$file_ext}";


            $upload_success = $file->storePubliclyAs($folder, $file_name, 'public');
            if ($upload_success) {
                return "/uploads{$folder}/{$file_name}";
            } else {
                throw new Exception("İstek başarısız oldu.", 1);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function check_array($file)
    {
        $key =  array_key_first($file);
        $file = $file[$key];
        if (gettype($file) == 'array') {
            return self::check_array($file);
        } else {
            return $file;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);

        return $file;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, $id)
    {
        try {
            $this->fileRepository->update($id, $request->all());

            session()->flash('success', 'Güncelleme işlemi başarıyla tamamlandı.');
            return redirect()->route('backend.files.index');
        } catch (Throwable $th) {
            session()->flash('error', $th);
            return redirect()->route('backend.files.index');
        }
    }

    public function update_modal(FileUpdateRequest $request, $id)
    {
        $this->fileRepository->update($id, $request->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $tv_id = $request->tv_id;


        if ($request->type == 'group') {
            $group = Group::find($request->group_id);
            $group->removeSliderFromScreen($tv_id, $id);
        } else {
            $group = Branch::find($request->group_id);
            $group->removeSliderFromScreen($tv_id, $id);
        }


        return redirect()->back();
    }
}
