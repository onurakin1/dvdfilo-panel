<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ContentModels;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentsController extends Controller
{


    public function create(Request $request)
    {
        $request->validate([
            'about_us_tr' => 'nullable|string',
            'about_us_en' => 'nullable|string',
            'our_services_tr' => 'nullable|string',
            'our_services_en' => 'nullable|string',
            'slider_tr.*' => 'nullable',

            'slider_en.*' => 'nullable',
            'ref.*' => 'nullable',
            'tr_campaign' => 'nullable|string',
            'en_campaign' => 'nullable|string',
            'carouselItems.*.badgeTitleTR' => 'nullable|string',
            'carouselItems.*.badgeTitleEN' => 'nullable|string',
            'carouselItems.*.badgeDescTR' => 'nullable|string',
            'carouselItems.*.badgeDescEN' => 'nullable|string',
            'carouselItems.*.badgePriceTR' => 'nullable|string',
            'carouselItems.*.badgePriceEN' => 'nullable|string',
            'carouselItems.*.slide' => 'nullable', // Remove image validation

        ]);

        // JSON formatında dizi oluşturma
        $aboutUsData = json_encode([
            'tr' => $request->about_us_tr,
            'en' => $request->about_us_en,
        ]);

        $ourServicesData = json_encode([
            'tr' => $request->our_services_tr,
            'en' => $request->our_services_en,
        ]);

        // Handle Turkish slider images
        $sliderTrImages = [];
        if ($request->hasFile('slider_tr')) {
            foreach ($request->file('slider_tr') as $file) {
                // Generate a unique filename for each file
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

                // Move the file to the uploads directory and store the relative path
                $path = $file->move(public_path('uploads'), $fileName);
                $sliderTrImages[] =  $fileName;
            }
        }

        // Handle English slider images
        $sliderEnImages = [];
        if ($request->hasFile('slider_en')) {
            foreach ($request->file('slider_en') as $file) {
                // Generate a unique filename for each file
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

                // Move the file to the uploads directory and store the relative path
                $path = $file->move(public_path('uploads'), $fileName);
                $sliderEnImages[] =  $fileName;
            }
        }

        $refImages = [];
        if ($request->hasFile('ref')) {
            foreach ($request->file('ref') as $file) {
                // Generate a unique filename for each file
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();

                // Move the file to the uploads directory and store the relative path
                $path = $file->move(public_path('uploads'), $fileName);
                $refImages[] =  $fileName;
            }
        }
        $carouselItems = [];

        if (isset($request->carouselItems) && is_array($request->carouselItems)) {
            foreach ($request->carouselItems as $item) {
                $carouselImage = null;

                if (isset($item['slide'])) {
                    if (is_string($item['slide']) && !empty($item['slide'])) {
                        // Keep the existing image path if it's a valid string
                        $carouselImage = $item['slide'];
                    } elseif (is_file($item['slide']) && $item['slide']->isValid()) {
                        // If it's a valid file, upload it
                        $carouselImage = uniqid() . '_' . Str::random(5) . '.' . $item['slide']->getClientOriginalExtension();
                        $item['slide']->move(public_path('uploads'), $carouselImage);
                    }
                }

                $carouselItems[] = [
                    'slide' => $carouselImage, // This will be null if no valid image is provided
                    'tr' => [
                        'title' => $item['badgeTitleTR'] ?? null,
                        'desc' => $item['badgeDescTR'] ?? null,
                        'price' => $item['badgePriceTR'] ?? null,
                    ],
                    'en' => [
                        'title' => $item['badgeTitleEN'] ?? null,
                        'desc' => $item['badgeDescEN'] ?? null,
                        'price' => $item['badgePriceEN'] ?? null,
                    ],
                ];
            }
        }


        $project = ContentModels::create([
            'name' => $request->name,
            'about_us' => $aboutUsData,  // JSON olarak saklama
            'our_services' => $ourServicesData,
            'main_slider' => json_encode([
                'tr' => $sliderTrImages,
                'en' => $sliderEnImages
            ]),
            'reference' => $refImages,
            'slider' => [
                'campaign' => [
                    'en' => $request->en_campaign,
                    'tr' => $request->tr_campaign,
                ],

                'data' => $carouselItems
            ]
        ]);

        return redirect()->route('backend.contents')->with('success', 'Models created successfully');
    }
    public function deleteMainImage(Request $request, $id)
    {
        $language = $request->input('language');
        $imageUrl = $request->input('imageUrl');

        // Find the record by ID
        $record = ContentModels::findOrFail($id);
        $images = json_decode($record->main_slider, true);

        // Check if the language array exists and remove the specified image
        if (isset($images[$language]) && ($key = array_search($imageUrl, $images[$language])) !== false) {
            unset($images[$language][$key]);

            // Re-index the array to remove any gaps from unsetting an element
            $images[$language] = array_values($images[$language]);
        }

        // Update the images in the database
        $record->main_slider = json_encode($images);
        $record->save();

               return redirect()->back()->with('message', 'Image deleted successfully.');
    }

    public function deleteRefImage(Request $request, $id)
    {
        $imageUrl = $request->input('imageUrl');
    
        // Find the record by ID
        $record = ContentModels::findOrFail($id);
    
        // Decode the reference JSON field
        $referenceImages = json_decode($record->reference, true);
    
        // Check if the reference array exists and if the image URL is in the array
        if (is_array($referenceImages) && ($key = array_search($imageUrl, $referenceImages)) !== false) {
            unset($referenceImages[$key]);
    
            // Re-index the array to remove any gaps
            $referenceImages = array_values($referenceImages);
    
            // Update the reference field in the database
            $record->reference = json_encode($referenceImages);
            $record->save();
    
                    return redirect()->back()->with('message', 'Image deleted successfully.');
        }
    
        return response()->json(['message' => 'Image not found in reference array'], 404);
    }
    
    
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'about_us_tr' => 'nullable|string',
            'about_us_en' => 'nullable|string',
            'our_services_en' => 'nullable|string',
            'our_services_tr' => 'nullable|string',
            'slider_tr.*' => 'nullable',
            'slider_en.*' => 'nullable',
            'ref.*' => 'nullable',
            'tr_campaign' => 'nullable|string',
            'en_campaign' => 'nullable|string',
            'carouselItems.*.badgeTitleTR' => 'nullable|string',
            'carouselItems.*.badgeTitleEN' => 'nullable|string',
            'carouselItems.*.badgeDescTR' => 'nullable|string',
            'carouselItems.*.badgeDescEN' => 'nullable|string',
            'carouselItems.*.badgePriceTR' => 'nullable|string',
            'carouselItems.*.badgePriceEN' => 'nullable|string',
            'carouselItems.*.slide' => 'nullable', // Remove image validation

        ]);

        // Fetch the existing content
        $contentModel = ContentModels::findOrFail($id);

        // Get existing images from the database
        $existingSliderTrImages = json_decode($contentModel->main_slider, true)['tr'] ?? [];
        $existingSliderEnImages = json_decode($contentModel->main_slider, true)['en'] ?? [];
        $existingRefImages = json_decode($contentModel->reference, true) ?? [];

        // Handle Turkish slider images
        $sliderTrImages = $existingSliderTrImages;
        if ($request->hasFile('slider_tr')) {
            foreach ($request->file('slider_tr') as $file) {
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                $sliderTrImages[] = $fileName; // Add new images to existing ones
            }
        }

        // Handle English slider images
        $sliderEnImages = $existingSliderEnImages;
        if ($request->hasFile('slider_en')) {
            foreach ($request->file('slider_en') as $file) {
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                $sliderEnImages[] = $fileName; // Add new images to existing ones
            }
        }

        // Encode the about_us and our_services fields as JSON
        $aboutUsData = json_encode([
            'tr' => $request->about_us_tr,
            'en' => $request->about_us_en,
        ]);
        $ourServicesData = json_encode([
            'tr' => $request->our_services_tr,
            'en' => $request->our_services_en,
        ]);


        $refImages = $existingRefImages;
        if ($request->hasFile('ref')) {
            foreach ($request->file('ref') as $file) {
                $fileName = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                $refImages[] = $fileName; // Yeni resimleri mevcut olanlara ekle
            }
        }
        // Prepare carousel items
        $carouselItems = [];
        if (isset($request->carouselItems) && is_array($request->carouselItems)) {
            foreach ($request->carouselItems as $item) {
                $carouselImage = null;
                if (isset($item['slide'])) {
                    if (is_string($item['slide']) && !empty($item['slide'])) {
                        $carouselImage = $item['slide'];
                    } elseif (is_file($item['slide']) && $item['slide']->isValid()) {
                        $carouselImage = uniqid() . '_' . Str::random(5) . '.' . $item['slide']->getClientOriginalExtension();
                        $item['slide']->move(public_path('uploads'), $carouselImage);
                    }
                }
                $carouselItems[] = [
                    'slide' => $carouselImage,
                    'tr' => [
                        'title' => $item['badgeTitleTR'] ?? null,
                        'desc' => $item['badgeDescTR'] ?? null,
                        'price' => $item['badgePriceTR'] ?? null,
                    ],
                    'en' => [
                        'title' => $item['badgeTitleEN'] ?? null,
                        'desc' => $item['badgeDescEN'] ?? null,
                        'price' => $item['badgePriceEN'] ?? null,
                    ],
                ];
            }
        }


        // Update the content model
        $contentModel->update([
            'name' => $request->name,
            'about_us' => $aboutUsData,
            'our_services' => $ourServicesData,
            'main_slider' => json_encode([
                'tr' => $sliderTrImages,
                'en' => $sliderEnImages
            ]),
           'reference' => json_encode($refImages),
            'slider' => [
                'campaign' => [
                    'en' => $request->en_campaign,
                    'tr' => $request->tr_campaign,
                ],
                'data' => $carouselItems
            ]
        ]);

        return redirect()->route('backend.contents')->with('success', 'Content updated successfully');
    }




    public function contents()
    {
        // Veritabanından tüm verileri al
        $contents = ContentModels::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));

        $url = base64_decode(request()->query('url'));


        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/Content/Index', ['contents' => $contents, 'url' => $url]);
    }
}
