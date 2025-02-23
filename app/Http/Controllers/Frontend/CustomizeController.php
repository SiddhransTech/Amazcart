<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customization;
use Illuminate\Support\Facades\Storage;

class CustomizeController extends Controller
{
    /**
     * Store customization details.
     */
    public function saveCustomization(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'customText' => 'nullable|string|max:255',
            'customColor' => 'nullable|string',
            'customImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'customNotes' => 'nullable|string',
        ]);

        // Handle Image Upload
        if ($request->hasFile('customImage')) {
            $imagePath = $request->file('customImage')->store('custom_images', 'public');
        } else {
            $imagePath = null;
        }

        // Save Data to Database
        $customization = new Customization();
        $customization->custom_text = $request->customText;
        $customization->custom_color = $request->customColor;
        $customization->custom_image = $imagePath;
        $customization->custom_notes = $request->customNotes;
        $customization->save();

        return response()->json([
            'message' => 'Customization saved successfully!',
            'data' => $customization
        ]);
    }

    /**
     * Retrieve all customizations.
     */
    public function getCustomizations()
    {
        $customizations = Customization::all();
        return response()->json($customizations);
    }

    /**
     * Delete a customization by ID.
     */
    public function deleteCustomization($id)
    {
        $customization = Customization::find($id);

        if (!$customization) {
            return response()->json(['message' => 'Customization not found'], 404);
        }

        // Delete the image if exists
        if ($customization->custom_image) {
            Storage::delete('public/' . $customization->custom_image);
        }

        $customization->delete();

        return response()->json(['message' => 'Customization deleted successfully']);
    }
}
