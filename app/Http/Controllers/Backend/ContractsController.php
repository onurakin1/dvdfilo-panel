<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ContentModels;
use App\Models\ContractsModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContractsController extends Controller
{


    public function create(Request $request)
    {
        $request->validate([
            'clarification_text_en' => 'nullable|string',
            'clarification_text_tr' => 'nullable|string',
            'our_privacy_policy_en' => 'nullable|string',
            'our_privacy_policy_tr' => 'nullable|string',
            'privacy_policy_tr' => 'nullable|string',
            'privacy_policy_en' => 'nullable|string',
        ]);

        // JSON formatında dizi oluşturma
        $clarificationTextData = json_encode([
            'tr' => $request->clarification_text_tr,
            'en' => $request->clarification_text_en,
        ]);

        $ourPrivacyPolicyData = json_encode([
            'tr' => $request->our_privacy_policy_tr,
            'en' => $request->our_privacy_policy_en,
        ]);
        $privacyPolicyData = json_encode([
            'tr' => $request->privacy_policy_tr,
            'en' => $request->privacy_policy_en,
        ]);
        $now = Carbon::now();
  
        $project = ContractsModel::create([
      
            'clarification_text' => $clarificationTextData,  // JSON olarak saklama
            'our_privacy_policy' => $ourPrivacyPolicyData, 
            'privacy_policy' => $privacyPolicyData, 
            'created_at' => $now
         
        ]);

        return redirect()->route('backend.contract')->with('success', 'Contracts created successfully');
    }


    
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'clarification_text_en' => 'nullable|string',
            'clarification_text_tr' => 'nullable|string',
            'our_privacy_policy_en' => 'nullable|string',
            'our_privacy_policy_tr' => 'nullable|string',
            'privacy_policy_tr' => 'nullable|string',
            'privacy_policy_en' => 'nullable|string',
        ]);

        // Fetch the existing content
        $contentModel = ContractsModel::findOrFail($id);
        // JSON formatında dizi oluşturma
        $clarificationTextData = json_encode([
            'tr' => $request->clarification_text_tr,
            'en' => $request->clarification_text_en,
        ]);

        $ourPrivacyPolicyData = json_encode([
            'tr' => $request->our_privacy_policy_tr,
            'en' => $request->our_privacy_policy_en,
        ]);
        $privacyPolicyData = json_encode([
            'tr' => $request->privacy_policy_tr,
            'en' => $request->privacy_policy_en,
        ]);
  
        // Update the content model
        $contentModel->update([

          'clarification_text' => $clarificationTextData,  // JSON olarak saklama
            'our_privacy_policy' => $ourPrivacyPolicyData, 
            'privacy_policy' => $privacyPolicyData, 
 
  
        ]);

        return redirect()->route('backend.contract')->with('success', 'Contracts updated successfully');
    }




    public function contents()
    {
        // Veritabanından tüm verileri al
        $contents = ContractsModel::latest()
            ->limit(request()->get('limit', 50))
            ->paginate(request()->get('page', 50));

        $url = base64_decode(request()->query('url'));


        // Dönüştürülmüş veriyi JSON olarak döndür
        return inertia('Admin/Contracts/Index', ['contract' => $contents, 'url' => $url]);
    }
}
