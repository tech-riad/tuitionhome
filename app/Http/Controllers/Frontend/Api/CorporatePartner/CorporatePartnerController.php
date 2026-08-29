<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\AgentContactInfo;
use App\Models\CorporatePartner;
use App\Models\PartnerContactInfo;
use App\Models\PartnerPersonalInfo;
use App\Transformers\CorporatePartnerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CorporatePartnerController extends Controller
{
    public function imageUpload(Request $request)
    {
        $user = auth()->user();

        $cppartner = CorporatePartner::findOrFail($user->id);

            // Delete old image from R2
            if ($cppartner->image) {
                if (Storage::disk('r2')->exists('corporate-partner-images/' . $cppartner->image)) {
                    Storage::disk('r2')->delete('corporate-partner-images/' . $cppartner->image);
                }
            }

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = $cppartner->id . '_' . rand(1234, 9999) . time() . '.jpg';

                // Load image
                $imgResource = null;

                switch (strtolower($image->getClientOriginalExtension())) {

                    case 'jpg':
                    case 'jpeg':
                        $imgResource = imagecreatefromjpeg($image->getPathname());
                        break;

                    case 'bmp':
                        $imgResource = imagecreatefrombmp($image->getPathname());
                        break;

                    case 'png':
                        $imgResource = imagecreatefrompng($image->getPathname());
                        break;

                    default:
                        throw new \Exception('Unsupported image format');
                }

                // Convert to JPG in memory
                ob_start();
                imagejpeg($imgResource, null, 100);
                $imageContent = ob_get_clean();

                imagedestroy($imgResource);

                // Upload to R2
                Storage::disk('r2')->put(
                    'corporate-partner-images/' . $imageName,
                    $imageContent
                );

                $cppartner->image = $imageName;
                $cppartner->save();

                response()->json([
                    'status' => true,
                    'message' => 'Image uploaded successfully.',
                    'data' => new CorporatePartnerResource($cppartner)
                ]);
            }
    }
    public function getCorporatePartner(Request $request)
    {
        $corporatePartner = Auth::user();

        $corporatePartner =new CorporatePartnerResource($corporatePartner);

        return response()->json([
            'status' => true,
            'message' => 'Corporate Partner retrieved successfully',
            'data' => $corporatePartner
        ]);
    }
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        PartnerPersonalInfo::updateOrCreate(
            [
                'partner_id' => $user->id, // Search condition
            ],
            [
                'date_of_birth'          => $request->date_of_birth,
                'profession'             => $request->profession,
                'known_from'             => $request->known_from,
                'institute'              => $request->institute,
                'institute_category'     => $request->institute_category,
                'institute_designation'  => $request->institute_designation,
                'work_experience'        => $request->work_experience,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Personal information saved successfully.',
            'data' => new CorporatePartnerResource($user->fresh())
        ]);
    }
    public function updateContactInfo(Request $request)
    {
        $user = auth()->user();
        PartnerContactInfo::updateOrCreate(
            [
                'partner_id' => $user->id,
            ],
            [
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'location_id' => $request->location_id,
                'address' => $request->address,
                'additional_phone' => $request->additional_phone,
                'whatsapp' => $request->whatsapp,
                'facebook' => $request->facebook,
                'personal_opinion' => $request->personal_opinion,
            ]
        );
        return response()->json([
            'status' => true,
            'message' => 'Contact information saved successfully.',
            'data' => new CorporatePartnerResource($user->fresh())
        ]);

    }


}
