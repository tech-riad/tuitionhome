<?php

namespace App\Http\Controllers\Frontend\Api\CorporateAgent;

use App\Http\Controllers\Controller;
use App\Models\AgentContactInfo;
use App\Models\AgentPersonalInfo;
use App\Models\CorporateAgent;
use App\Transformers\CorporateAgentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CorporateAgentCOntroller extends Controller
{
    //

    public function imageUpload(Request $request)
    {
        $user = auth()->user();

        $corporateAgent = CorporateAgent::findOrFail($user->id);

        // Validate image
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp|max:5120',
        ]);

        try {

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                // Delete old image from R2
                if (!empty($corporateAgent->image)) {

                    $oldImagePath = 'corporate-agent-images/' . $corporateAgent->image;

                    if (Storage::disk('r2')->exists($oldImagePath)) {
                        Storage::disk('r2')->delete($oldImagePath);
                    }
                }

                // Generate unique image name
                $imageName = $corporateAgent->id . '_' . rand(1234, 9999) . '_' . time() . '.jpg';

                // Load image
                $imgResource = null;

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
                        'message' => 'Unable to process the image.',
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
                    'corporate-agent-images/' . $imageName,
                    $imageContent,
                    'public'
                );

                // Save image name in database
                $corporateAgent->image = $imageName;
                $corporateAgent->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Image uploaded successfully.',
                    'data' => new CorporateAgentResource($corporateAgent),
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
    public function getCorporateAgent(Request $request)
    {

        $corporateAgent =new CorporateAgentResource(auth()->user());


        return response()->json([
            'status' => true,
            'message' => 'Corporate Agent retrieved successfully',
            'data' => $corporateAgent
        ]);
    }
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        AgentPersonalInfo::updateOrCreate(
            [
                'agent_id' => $user->id, // Search condition
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
            'data' => new CorporateAgentResource($user->fresh())
        ]);
    }
    public function updateContactInfo(Request $request)
    {
        $user = auth()->user();

        AgentContactInfo::updateOrCreate(
            [
                'agent_id' => $user->id,
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
            'message' => 'Contact information updated successfully.',
            'data' => new CorporateAgentResource($user->fresh())
        ]);
    }
}
