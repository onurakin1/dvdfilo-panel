<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ContentModels;
use App\Models\InstitutionalModels;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionalController extends Controller
{


    public function create(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'content_tr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'file_tr' => 'nullable|file|mimes:jpg,jpeg,png,gif', // Validate Turkish file type
            'file_en' => 'nullable|file|mimes:jpg,jpeg,png,gif', // Validate English file type
        ]);
    
        // Initialize variables for file names
        $fileNameTr = null;
        $fileNameEn = null;
    
        // Handle Turkish image upload if a file is provided
        if ($request->hasFile('file_tr')) {
            $fileTr = $request->file('file_tr');
            $fileNameTr = md5(time() . '_tr') . '.' . $fileTr->getClientOriginalExtension();
            $fileTr->move(public_path('uploads'), $fileNameTr);
        }
    
        // Handle English image upload if a file is provided
        if ($request->hasFile('file_en')) {
            $fileEn = $request->file('file_en');
            $fileNameEn = md5(time() . '_en') . '.' . $fileEn->getClientOriginalExtension();
            $fileEn->move(public_path('uploads'), $fileNameEn);
        }
    
        // Encode the image data as JSON
        $imageData = json_encode([
            'tr' => $fileNameTr,
            'en' => $fileNameEn,
        ]);
    
        // Encode the content fields as JSON
        $aboutUsData = json_encode([
            'tr' => $request->input('content_tr', ''),
            'en' => $request->input('content_en', ''),
        ]);
    
        // Create a new content model
        $project = InstitutionalModels::create([
            'image' => $imageData, // Store image data as JSON
            'content' => $aboutUsData, // Store content as JSON
        ]);
    
        return redirect()->route('backend.institutional')->with('success', 'Contents created successfully');
    }



    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'content_tr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'file_tr' => 'nullable', // Validate Turkish file type
            'file_en' => 'nullable', // Validate English file type
        ]);
    
        // Fetch the existing content
        $contentModel = InstitutionalModels::findOrFail($id);
    
        // Initialize variables for file names
        $imageData = json_decode($contentModel->image, true); // Decode JSON into associative array

        $fileNameTr = $imageData['tr'] ?? null; // Access Turkish image or set to null if not exists
        $fileNameEn = $imageData['en'] ?? null;
    
        // Handle Turkish image upload if a new file is provided
        if ($request->hasFile('file_tr')) {
            $fileTr = $request->file('file_tr');
            $fileNameTr = md5(time() . '_tr') . '.' . $fileTr->getClientOriginalExtension();
            $fileTr->move(public_path('uploads'), $fileNameTr);
    
            // Delete the old Turkish file if it exists
            if ($contentModel->image_tr && file_exists(public_path('uploads/' . $contentModel->image_tr))) {
                unlink(public_path('uploads/' . $contentModel->image_tr));
            }
        }
    
        // Handle English image upload if a new file is provided
        if ($request->hasFile('file_en')) {
            $fileEn = $request->file('file_en');
            $fileNameEn = md5(time() . '_en') . '.' . $fileEn->getClientOriginalExtension();
            $fileEn->move(public_path('uploads'), $fileNameEn);
    
            // Delete the old English file if it exists
            if ($contentModel->image_en && file_exists(public_path('uploads/' . $contentModel->image_en))) {
                unlink(public_path('uploads/' . $contentModel->image_en));
            }
        }
    
        // Encode the image data as JSON
        $imageData = json_encode([
            'tr' => $fileNameTr,
            'en' => $fileNameEn,
        ]);
    
        // Encode the content fields as JSON
        $aboutUsData = json_encode([
            'tr' => $request->input('content_tr', ''),
            'en' => $request->input('content_en', ''),
        ]);
    
        // Update the content model
        $contentModel->update([
            'image' => $imageData,
            'content' => $aboutUsData,
        ]);
    
        return redirect()->route('backend.institutional')->with('success', 'Content updated successfully');
    }
    
    
    



    public function contents()
    {
        // Veritabanından tüm verileri al
        $contents = InstitutionalModels::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));

        $url = base64_decode(request()->query('url'));


        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/Institutional/Index', ['institutional' => $contents, 'url' => $url]);
    }
}
