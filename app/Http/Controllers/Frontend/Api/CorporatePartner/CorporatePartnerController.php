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

        // Validate image
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp|max:5120',
        ]);

        try {

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                // Delete old image from R2
                if (!empty($cppartner->image)) {

                    $oldImagePath = 'corporate-partner-images/' . $cppartner->image;

                    if (Storage::disk('r2')->exists($oldImagePath)) {
                        Storage::disk('r2')->delete($oldImagePath);
                    }
                }

                // Generate unique image name
                $imageName = $cppartner->id . '_' . rand(1234, 9999) . '_' . time() . '.jpg';

                // Load image
                switch (strtolower($image->getClientOriginalExtension())) {

                    case 'jpg':
                    case 'jpeg':
                        $imgResource = imagecreatefromjpeg($image->getPathname());
                        break;

                    case 'png':
                        $imgResource = imagecreatefrompng($image->getPathname());
                        break;

                    case 'bmp':
                        $imgResource = imagecreatefrombmp($image->getPathname());
                        break;

                    default:
                        return response()->json([
                            'status' => false,
                            'message' => 'Unsupported image format.',
                        ], 422);
                }

                if (!$imgResource) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unable to process image.',
                    ], 422);
                }

                // Convert image to JPG in memory
                ob_start();

                imagejpeg($imgResource, null, 90);

                $imageContent = ob_get_clean();

                // Free memory
                imagedestroy($imgResource);

                // Upload to R2
                Storage::disk('r2')->put(
                    'corporate-partner-images/' . $imageName,
                    $imageContent
                );

                // Save image name
                $cppartner->image = $imageName;
                $cppartner->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Image uploaded successfully.',
                    'data' => new CorporatePartnerResource($cppartner),
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No image file found.',
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while uploading the image.',
                'error' => $e->getMessage(),
            ], 500);
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
