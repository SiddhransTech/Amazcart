<?php

namespace App\Http\Controllers;

use App\Models\BoxConfiguration;
use App\Models\BoxFace;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoxConfigurationController extends Controller
{
    public function save(Request $request) // Changed from 'store' to 'save' to match custom3d.js route
    {
        try {
            // Validate incoming data
            $validated = $request->validate([
                'parameters.breadth' => 'required|numeric',
                'parameters.length' => 'required|numeric',
                'parameters.height' => 'required|numeric',
                'parameters.thickness' => 'required|numeric',
                'parameters.fluteFreq' => 'required|integer',
                'faces.front.hasAttachment' => 'required|boolean',
                'faces.*.hasAttachment' => 'boolean',
                'faces.*.attachment.type' => 'nullable|string|in:text,image',
                'faces.*.attachment.content' => 'nullable|string',
                'faces.*.attachment.fontStyle' => 'nullable|string|max:50',
                'faces.*.attachment.fontSize' => 'nullable|string|max:10',
                'faces.*.attachment.position.x' => 'nullable|numeric',
                'faces.*.attachment.position.y' => 'nullable|numeric',
                'faces.*.attachment.position.z' => 'nullable|numeric',
                'faces.*.attachment.rotation.x' => 'nullable|numeric',
                'faces.*.attachment.rotation.y' => 'nullable|numeric',
                'faces.*.attachment.rotation.z' => 'nullable|numeric',
            ]);

            // Create box configuration
            $boxConfig = BoxConfiguration::create([
                'breadth' => $request->input('parameters.breadth'),
                'length' => $request->input('parameters.length'),
                'height' => $request->input('parameters.height'),
                'thickness' => $request->input('parameters.thickness'),
                'flute_freq' => $request->input('parameters.fluteFreq'),
            ]);

            // Create faces and attachments
            foreach ($request->input('faces', []) as $faceName => $faceData) {
                $boxFace = BoxFace::create([
                    'box_configuration_id' => $boxConfig->id,
                    'face_name' => $faceName,
                    'has_attachment' => $faceData['hasAttachment'] ?? false,
                ]);

                if ($boxFace->has_attachment && isset($faceData['attachment'])) {
                    $attachmentData = $faceData['attachment'];
                    Attachment::create([
                        'box_face_id' => $boxFace->id,
                        'type' => $attachmentData['type'] ?? null,
                        'content' => $attachmentData['content'] ?? null,
                        'font_style' => $attachmentData['fontStyle'] ?? null,
                        'font_size' => $attachmentData['fontSize'] ?? null,
                        'position_x' => $attachmentData['position']['x'] ?? 0,
                        'position_y' => $attachmentData['position']['y'] ?? 0,
                        'position_z' => $attachmentData['position']['z'] ?? 0,
                        'rotation_x' => $attachmentData['rotation']['x'] ?? 0,
                        'rotation_y' => $attachmentData['rotation']['y'] ?? 0,
                        'rotation_z' => $attachmentData['rotation']['z'] ?? 0,
                    ]);
                }
            }

            // Return success response
            return response()->json([
                'message' => 'Box configuration saved successfully',
                'id' => $boxConfig->id,
                'data' => $request->all()
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saving box configuration: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return response()->json([
                'message' => 'Failed to save configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}