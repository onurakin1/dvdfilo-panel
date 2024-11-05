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
        $request->validate([
            'content_tr' => 'nullable|string',
            'content_en' => 'nullable|string',
         

        ]);

        // JSON formatında dizi oluşturma
        $aboutUsData = json_encode([
            'tr' => $request->content_tr,
            'en' => $request->content_en,
        ]);

        $now = Carbon::now();
        $file = $request->file('file');
        $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
      
     


        $project = InstitutionalModels::create([
      'image' => $fileName,
            'content' => $aboutUsData,  // JSON olarak saklama
         
        ]);

        return redirect()->route('backend.institutional')->with('success', 'Contents created successfully');
    }


    
    
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'content_tr' => 'nullable|string',
            'content_en' => 'nullable|string',
         

        ]);

        // Fetch the existing content
        $contentModel = InstitutionalModels::findOrFail($id);

        $now = Carbon::now();
        $file = $request->file('file');
        $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
      

        // Encode the about_us and our_services fields as JSON
        $aboutUsData = json_encode([
            'tr' => $request->content_tr,
            'en' => $request->content_en,
        ]);
 




        // Update the content model
        $contentModel->update([
       'image' => $fileName,
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
