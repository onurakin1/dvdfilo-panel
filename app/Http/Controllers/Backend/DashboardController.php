<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Brands;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{


    public function index()
    {
        $offers = Offers::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));

        $totalOffers = $offers->total();

        $distinctOffersCount = Offers::select('firstname', 'lastname')
            ->distinct()
            ->get()
            ->count();

        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $monthlyData = Offers::join('brands', 'offers.brand', '=', 'brands.id')
            ->whereBetween('offers.created_at', [$startDate, $endDate]) // Son 6 ayın verileri
            ->select(
                DB::raw("DATE_FORMAT(offers.created_at, '%Y-%m') as month"), // Yıl-ay formatında
                'brands.brand_type',
                DB::raw('count(*) as total')
            )
            ->groupBy('month', 'brands.brand_type')
            ->orderBy('month', 'asc')
            ->get();

        // Son 6 ayın boş veri seti
        $results = [
            'Elektrikli' => array_fill(0, 6, 0), // 6 aylık sıfırlarla doldurulmuş array
            'Lüks' => array_fill(0, 6, 0)
        ];

        // Her bir ayın başladığı zamanı alalım (Son 6 ay için)
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = Carbon::now()->subMonths(5 - $i)->format('Y-m'); // Son 6 ayı geriden alıyoruz
        }

        // Son 6 ayın her biri için ayı ve toplam sayıyı al
        foreach ($monthlyData as $data) {
            $index = array_search($data->month, $months); // Ayın dizideki yerini bul
            if ($index !== false) { // Eğer ay mevcutsa
                if ($data->brand_type == 'E') {
                    $results['Elektrikli'][$index] = $data->total;
                } elseif ($data->brand_type == 'L') {
                    $results['Lüks'][$index] = $data->total;
                }
            }
        }

        // Formatlama: İstenen çıktı şekline getir
        $finalResults = [
            [
                'name' => 'Elektrikli',
                'data' => $results['Elektrikli']
            ],
            [
                'name' => 'Lüks',
                'data' => $results['Lüks']
            ]
        ];


        $mostPreferredBrand = Offers::select('brand', DB::raw('count(*) as total'))
            ->groupBy('brand')
            ->orderBy('total', 'desc')
            ->with('brand') // Markayı almak için ilişkili modeli yükleyin
            ->first();

        // Eğer marka varsa, adı ile birlikte döndürelim
        if ($mostPreferredBrand) {
            $brandName = Brands::find($mostPreferredBrand->brand)->brand_name;
            $result = [
                'brand_id' => $mostPreferredBrand->brand_id,
                'brand_name' => $brandName,
                'total' => $mostPreferredBrand->total,
            ];
        } else {
            $result = null; // Hiç kayıt yoksa
        }

        $mostPreferredCar = Offers::join('brand_models', 'offers.carname', '=', 'brand_models.id')
        ->join('brands', 'brand_models.brand_id', '=', 'brands.id') // Join with Brands model
        ->select(
            'brand_models.name as car_name',
            'brands.brand_name as brand_name', // Select the brand name from Brands model
            DB::raw('count(*) as total'),
            'brand_models.image',
            'brand_models.desc',
            'brand_models.price'
        )
        ->groupBy('brand_models.name', 'brand_models.image', 'brand_models.desc', 'brand_models.price', 'brands.brand_name')
        ->orderBy('total', 'desc')
        ->limit(10)
        ->get();

        return Inertia::render('Admin/Dashboard/Index', ['totalOffers' => $totalOffers, 'distinctOffersCount' => $distinctOffersCount, 'mostPreferredType' => $finalResults, 'mostPreferredBrand' => $result, 'mostPreferredCar' => $mostPreferredCar]);
    }
}
