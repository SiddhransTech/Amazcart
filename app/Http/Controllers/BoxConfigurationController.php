<?php

namespace App\Http\Controllers;

use App\Models\BoxDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BoxDesignResource;

class BoxConfigurationController extends Controller
{
    /**
     * Save box configuration and design
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        try {

              // Handle FormData
            // $boxData = json_decode($request->boxData, true);
            // $modelFile = $request->file('model');
            // $imageFile = $request->file('image');

            // Validate incoming data
            $validator = Validator::make($request->all(), [
                'boxData' => 'required|json',
                'model' => 'required|file|mimetypes:model/gltf-binary,application/octet-stream|max:10240',
                'image' => 'required|file|mimes:png,jpg,jpeg|max:2048',
                'price' => 'required|numeric|min:0',
                'seller_id' => 'required|exists:users,id'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Parse boxData
            $boxData = json_decode($request->input('boxData'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON in boxData: ' . json_last_error_msg());
            }

            // Save files
            $modelFile = $request->file('model');
            $imageFile = $request->file('image');

            $modelPath = $modelFile->store('box-designs/models', 'public');
            $imagePath = $imageFile->store('box-designs/images', 'public');

            // Create box design
            $boxDesign = BoxDesign::create([
                'user_id' => $request->input('user_id', auth()->id()),
                'breadth' => $boxData['parameters']['breadth'] ?? 0,
                'length' => $boxData['parameters']['length'] ?? 0,
                'height' => $boxData['parameters']['height'] ?? 0,
                'thickness' => $boxData['parameters']['thickness'] ?? 0,
                'flute_freq' => $boxData['parameters']['fluteFreq'] ?? 0,
                'model_path' => $modelPath,
                'image_path' => $imagePath,
                'faces' => $boxData['faces'] ?? []
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Box design saved successfully',
                'data' => [
                    'id' => $boxDesign->id,
                    'price' => $request->price,
                    'seller_id' => $request->seller_id
                ]
            ], 201);
    
        } catch (\Exception $e) {
            Log::error('Error saving box design: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save box design',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get box design details
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $boxDesign = BoxDesign::findOrFail($id);
            return response()->json([
                'data' => new BoxDesignResource($boxDesign)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Box design not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update box design
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $boxDesign = BoxDesign::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'boxData' => 'sometimes|json',
                'model' => 'sometimes|file|mimetypes:model/gltf-binary,application/octet-stream|max:10240',
                'image' => 'sometimes|file|mimes:png,jpg,jpeg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $updateData = [];
            
            if ($request->has('boxData')) {
                $boxData = json_decode($request->input('boxData'), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON in boxData: ' . json_last_error_msg());
                }

                $updateData = [
                    'breadth' => $boxData['parameters']['breadth'] ?? $boxDesign->breadth,
                    'length' => $boxData['parameters']['length'] ?? $boxDesign->length,
                    'height' => $boxData['parameters']['height'] ?? $boxDesign->height,
                    'thickness' => $boxData['parameters']['thickness'] ?? $boxDesign->thickness,
                    'flute_freq' => $boxData['parameters']['fluteFreq'] ?? $boxDesign->flute_freq,
                    'faces' => $boxData['faces'] ?? $boxDesign->faces
                ];
            }

            if ($request->hasFile('model')) {
                // Delete old model file
                if ($boxDesign->model_path) {
                    Storage::disk('public')->delete($boxDesign->model_path);
                }
                $modelPath = $request->file('model')->store('box-designs/models', 'public');
                $updateData['model_path'] = $modelPath;
            }

            if ($request->hasFile('image')) {
                // Delete old image file
                if ($boxDesign->image_path) {
                    Storage::disk('public')->delete($boxDesign->image_path);
                }
                $imagePath = $request->file('image')->store('box-designs/images', 'public');
                $updateData['image_path'] = $imagePath;
            }

            $boxDesign->update($updateData);

            return response()->json([
                'message' => 'Box design updated successfully',
                'data' => new BoxDesignResource($boxDesign)
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating box design: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update box design',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete box design
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $boxDesign = BoxDesign::findOrFail($id);

            // Delete associated files
            if ($boxDesign->model_path) {
                Storage::disk('public')->delete($boxDesign->model_path);
            }
            if ($boxDesign->image_path) {
                Storage::disk('public')->delete($boxDesign->image_path);
            }

            $boxDesign->delete();

            return response()->json([
                'message' => 'Box design deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting box design: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete box design',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all box designs for a user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = BoxDesign::query();

            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            $designs = $query->paginate($request->per_page ?? 10);

            return response()->json([
                'data' => BoxDesignResource::collection($designs),
                'meta' => [
                    'total' => $designs->total(),
                    'per_page' => $designs->perPage(),
                    'current_page' => $designs->currentPage(),
                    'last_page' => $designs->lastPage()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error listing box designs: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to list box designs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}