<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BrandModels;
use App\Models\Brands;
use App\Models\Offers;
use Carbon\Carbon;
use Illuminate\Http\Request;



class BrandsController extends Controller
{
    public function createBrands(Request $request)
    {
        // Request body'den verileri al
        $offerData = $request->only([
            'brand_name',

        ]);

        // Yeni teklif oluştur
        $offer = Brands::create($offerData);

        // Başarılı yanıt döndür
        return redirect()->route('backend.brands')->with('success', 'Brand created successfully');
    }

    public function brands()
    {
        // Veritabanından tüm verileri al
        $brands = Brands::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));
    
        // Marka tipini adlandır
        foreach ($brands as $brand) {
            $brand->brand_type = $brand->brand_type === 'E' ? 'Elektrikli' : ($brand->brand_type === 'L' ? 'Lüks' : $brand->brand_type);
        }
    
        $url = base64_decode(request()->query('url'));
        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/Brand/Index', ['brands' => $brands, 'url' => $url]);
    }

    public function carModels()
    {
        // Veritabanından tüm verileri al
        $carModels = BrandModels::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));

        $url = base64_decode(request()->query('url'));

        $brands = Brands::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));
        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/CarModels/Index', ['models' => $carModels, 'brands' => $brands, 'url' => $url]);
    }

    public function getOffers()
    {
        // Veritabanından tüm verileri al ve ilgili brand verisini de ekle
        $offers = Offers::with('brand') // Brand ilişkisini yükle
            ->latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));
    
        $url = base64_decode(request()->query('url'));
        
        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/Offer/Index', [
            'offers' => $offers, 
            'url' => $url
        ]);
    }
    

    public function createModels(Request $request)
    {
        $request->validate([

            'name_tr' => 'required|string',
            'name_en' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'price_tr' => 'required|string',
            'price_en' => 'required|string',
            'brand_id' => 'required|integer' // brand_id alanı doğrulandı
        ]);
        $now = Carbon::now();
        $file = $request->file('file');
        $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);

        $project = BrandModels::create([
            'desc' => json_encode(["tr" => $request->desc_tr, "en" => $request->desc_en]),
            'name' => json_encode(["tr" => $request->name_tr, "en" => $request->name_en]),
            'price' => json_encode(["tr" => $request->price_tr, "en" => $request->price_en]),
            'image' => $fileName,
            'created_at' => $now,
            'brand_id' => $request->brand_id
        ]);

  

        // Başarılı yanıt döndür
        return redirect()->route('backend.carModels')->with('success', 'Models created successfully');
    }

    public function update(Request $request, $id)
    {
        // İlgili proje kaydını bul
        $project = BrandModels::find($id);

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found');
        }

        // Doğrulama kuralları
        $request->validate([
            'name_tr' => 'required|string',
            'name_en' => 'required|string',
            'desc_en' => 'required|string',
            'desc_tr' => 'required|string',
            'price_tr' => 'required|string',
            'price_en' => 'required|string',
            'brand_id' => 'required|integer|exists:brands,id',

        ]);

        // Gelen verilerle projeyi güncelle
        $project->name = ["tr" => $request->name_tr, "en" => $request->name_en];
        $project->desc = ["tr" => $request->desc_tr, "en" => $request->desc_en];
        $project->price = ["tr" => $request->price_tr, "en" => $request->price_en];
        $project->brand_id = $request->brand_id;

        // Yeni bir dosya yüklenmişse işle
        if ($request->hasFile('file')) {
            // Mevcut dosyayı silmek isterseniz
            if ($project->image) {
                $oldFilePath = public_path('uploads/' . $project->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Yeni dosyayı yükle
            $file = $request->file('file');
            $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            // Dosya adını kaydet
            $project->image = $fileName;
        }

        // Projeyi kaydet
        $project->save();

        // Başarılı yanıt döndür
        return redirect()->route('backend.carModels')->with('success', 'Model updated successfully');
    }
    public function modelDelete($id)
    {
        $model = BrandModels::findOrFail($id);
        $model->delete();  // Soft delete will update the `deleted_at` timestamp
        return response()->json(['success' => 'Record soft deleted']);
    }




    public function getModelWithBrand(Request $request)
    {
        $id = $request->query('id');

        // Filtrelenmiş verileri al ve ilgili modelleri yükle
        $brandModels = BrandModels::where('brand_id', $id)

            ->get();

        // Eğer sonuç yoksa, uygun bir yanıt döndür
        if ($brandModels->isEmpty()) {
            return response()->json(['message' => 'No brands found for this type'], 404);
        }

        // Dönüştürülmüş veriyi JSON olarak döndür
        return response()->json(['items' => $brandModels]);
    }
    public function getBrandsWithType(Request $request)
    {
        $type = $request->query('type');

        // Filtrelenmiş verileri al ve ilgili modelleri yükle
        $brands = Brands::where('brand_type', $type)
            ->with('brandModels')
            ->get();

        // Eğer sonuç yoksa, uygun bir yanıt döndür
        if ($brands->isEmpty()) {
            return response()->json(['message' => 'No brands found for this type'], 404);
        }

        // Dönüştürülmüş veriyi JSON olarak döndür
        return response()->json(['items' => $brands]);
    }
    public function getBrandsModel(Request $request)
    {
        $id = $request->query('id');
        $type = $request->query('type');

        // Belirli bir türdeki veya markaya ait modelleri getir
        $brandModels = BrandModels::with('brand')
            ->when($type, function ($query) use ($type) {
                $query->whereHas('brand', function ($query) use ($type) {
                    $query->where('brand_type', $type);
                });
            })
            ->when($id != 0, function ($query) use ($id) {
                $query->where('brand_id', $id);
            })
            ->get();

        // Eğer sonuç yoksa veya brand null ise, uygun bir yanıt döndür
        if ($brandModels->isEmpty()) {
            return response()->json(['message' => 'Bu türe ait otomobil bulunamamaktadır'], 404);
        }

        // Dönüştürülmüş veriyi JSON olarak döndür
        return response()->json(['items' => $brandModels]);
    }

    public function createOffers(Request $request)
    {
        // Request body'den verileri al
        $offerData = $request->only([
            'firstname',
            'lastname',
            'phone_number',
            'email',
            'brand',
            'carname',
            'rental_period',
            'km_time',
            'offer_type',
        ]);

        // Yeni teklif oluştur
        $offer = Offers::create($offerData);

        // Başarılı yanıt döndür
        return response()->json([
            'message' => 'Teklif başarıyla oluşturuldu.',
            'offer' => $offer
        ], 201);
    }
}
