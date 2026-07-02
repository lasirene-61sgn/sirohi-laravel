<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobileindex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MobileIndexController extends Controller
{
    public function index()
    {
        $mobileIndex = Mobileindex::first();
        return view('admin.mobile_index.index', compact('mobileIndex'));
    }

    public function create()
    {
        return view('admin.mobile_index.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile_images' => 'required|array',
            'mobile_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
            'image_seconds' => 'required|array',
        ]);

        $mobileIndex = new Mobileindex();
        $imageObjects = [];

        if ($request->hasFile('mobile_images')) {
            foreach ($request->file('mobile_images') as $index => $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/mobile_index'), $imageName);

                $seconds = isset($request->image_seconds[$index]) ? (int)$request->image_seconds[$index] : 5;

                $imageObjects[] = [
                    'image' => $imageName,
                    'seconds' => $seconds
                ];
            }
        }

        $mobileIndex->mobile_images = $imageObjects;
        $mobileIndex->save();

        return redirect()->route('admin.mobile_index.index')->with('success', 'Mobile Index Images Added');
    }

    public function edit($id)
    {
        $mobileIndex = Mobileindex::findOrFail($id);
        return view('admin.mobile_index.edit', compact('mobileIndex'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mobile_images' => 'nullable|array',
            'mobile_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
            'image_seconds' => 'nullable|array',
            'existing_seconds' => 'nullable|array',
        ]);

        $mobileIndex = Mobileindex::findOrFail($id);
        $rawImages = $mobileIndex->mobile_images ?? [];
        $currentImages = [];

        // Step A: Standardize existing images to the new format and update seconds
        foreach ($rawImages as $imgData) {
            // If it's a string (old format), convert it to the new array structure
            if (is_string($imgData)) {
                $imageName = $imgData;
                $seconds = isset($request->existing_seconds[$imageName]) ? (int)$request->existing_seconds[$imageName] : 5;
            } else {
                // New format (array)
                $imageName = $imgData['image'] ?? '';
                $seconds = isset($request->existing_seconds[$imageName]) ? (int)$request->existing_seconds[$imageName] : ($imgData['seconds'] ?? 5);
            }

            if (!empty($imageName)) {
                $currentImages[] = [
                    'image' => $imageName,
                    'seconds' => $seconds
                ];
            }
        }

        // Step B: Append new files with their respective seconds
        if ($request->hasFile('mobile_images')) {
            foreach ($request->file('mobile_images') as $index => $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/mobile_index'), $imageName);

                $seconds = isset($request->image_seconds[$index]) ? (int)$request->image_seconds[$index] : 5;

                $currentImages[] = [
                    'image' => $imageName,
                    'seconds' => $seconds
                ];
            }
        }

        $mobileIndex->mobile_images = $currentImages;
        $mobileIndex->save();

        return redirect()->route('admin.mobile_index.index')->with('success', 'Mobile Index Updated Successfully');
    }

    public function removeImage(Request $request, $id)
    {
        $request->validate([
            'image_name' => 'required|string',
        ]);

        $mobileIndex = Mobileindex::findOrFail($id);
        $rawImages = $mobileIndex->mobile_images ?? [];
        $currentImages = [];
        $found = false;

        foreach ($rawImages as $imgData) {
            // Extract name regardless of old or new format
            $imageName = is_string($imgData) ? $imgData : ($imgData['image'] ?? '');

            if ($imageName === $request->image_name) {
                // Delete physical file
                $filePath = public_path('uploads/mobile_index/' . $imageName);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $found = true;
                continue; // Skip adding to currentImages (removes it)
            }

            // Re-build standard item if not being deleted
            if (!empty($imageName)) {
                $currentImages[] = is_string($imgData) ? ['image' => $imageName, 'seconds' => 5] : $imgData;
            }
        }

        if ($found) {
            $mobileIndex->mobile_images = array_values($currentImages);
            $mobileIndex->save();
            return response()->json(['success' => true, 'message' => 'Image removed successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    public function destroy($id)
    {
        $mobileIndex = Mobileindex::findOrFail($id);
        $currentImages = $mobileIndex->mobile_images ?? [];

        foreach ($currentImages as $imgData) {
            $filePath = public_path('uploads/mobile_index/' . $imgData['image']);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $mobileIndex->delete();

        return redirect()->route('admin.mobile_index.index')->with('success', 'Mobile Index Record Deleted completely');
    }
}
