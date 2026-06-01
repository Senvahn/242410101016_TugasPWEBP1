<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'is_active' => 'sometimes|boolean',
        ]);

        Service::create(array_merge($validated, [
            'is_active' => $request->has('is_active'),
        ]));

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa grooming berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'is_active' => 'sometimes|boolean',
        ]);

        $service->update(array_merge($validated, [
            'is_active' => $request->has('is_active'),
        ]));

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa grooming berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        // Soft-deactivate instead of hard delete so admin can restore later
        $service->is_active = false;
        $service->save();

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa grooming berhasil dinonaktifkan (soft-deleted).');
    }

    public function restore(Service $service)
    {
        $service->is_active = true;
        $service->save();

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa grooming berhasil dipulihkan.');
    }
}
