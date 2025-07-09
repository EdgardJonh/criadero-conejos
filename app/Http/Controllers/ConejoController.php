<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conejo;
use Illuminate\Support\Facades\Storage;

class ConejoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conejos = Conejo::all();
        return view('conejos.index', compact('conejos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('conejos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto_principal' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'fotos_adicionales.*' => 'image|mimes:jpeg,png,jpg|max:1024',
            'numero' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'sexo' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'disponible' => 'nullable|boolean',
        ]);

        // Guardar foto principal
        $fotoPrincipalPath = $request->file('foto_principal')->store('conejos', 'public');

        // Guardar fotos adicionales
        $fotosAdicionales = [];
        if ($request->hasFile('fotos_adicionales')) {
            foreach ($request->file('fotos_adicionales') as $foto) {
                $fotosAdicionales[] = $foto->store('conejos', 'public');
            }
        }

        $conejo = Conejo::create([
            'nombre' => $request->nombre,
            'foto_principal' => $fotoPrincipalPath,
            'fotos_adicionales' => $fotosAdicionales,
            'numero' => $request->numero,
            'raza' => $request->raza,
            'color' => $request->color,
            'sexo' => $request->sexo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'disponible' => $request->has('disponible'),
        ]);

        return redirect()->route('conejos.index')->with('success', 'Conejo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $conejo = Conejo::findOrFail($id);
        return view('conejos.show', compact('conejo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $conejo = Conejo::findOrFail($id);
        return view('conejos.edit', compact('conejo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conejo = Conejo::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'foto_principal' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'fotos_adicionales.*' => 'image|mimes:jpeg,png,jpg|max:1024',
            'numero' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'sexo' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'disponible' => 'nullable|boolean',
        ]);

        // Actualizar foto principal si se sube una nueva
        if ($request->hasFile('foto_principal')) {
            if ($conejo->foto_principal) {
                Storage::disk('public')->delete($conejo->foto_principal);
            }
            $conejo->foto_principal = $request->file('foto_principal')->store('conejos', 'public');
        }

        // Actualizar fotos adicionales si se suben nuevas
        if ($request->hasFile('fotos_adicionales')) {
            // Borrar las anteriores
            if ($conejo->fotos_adicionales) {
                foreach ($conejo->fotos_adicionales as $foto) {
                    Storage::disk('public')->delete($foto);
                }
            }
            $fotosAdicionales = [];
            foreach ($request->file('fotos_adicionales') as $foto) {
                $fotosAdicionales[] = $foto->store('conejos', 'public');
            }
            $conejo->fotos_adicionales = $fotosAdicionales;
        }

        $conejo->nombre = $request->nombre;
        $conejo->numero = $request->numero;
        $conejo->raza = $request->raza;
        $conejo->color = $request->color;
        $conejo->sexo = $request->sexo;
        $conejo->fecha_nacimiento = $request->fecha_nacimiento;
        $conejo->descripcion = $request->descripcion;
        $conejo->precio = $request->precio;
        $conejo->disponible = $request->has('disponible');
        $conejo->save();

        return redirect()->route('conejos.index')->with('success', 'Conejo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $conejo = Conejo::findOrFail($id);
        // Borrar imágenes
        if ($conejo->foto_principal) {
            Storage::disk('public')->delete($conejo->foto_principal);
        }
        if ($conejo->fotos_adicionales) {
            foreach ($conejo->fotos_adicionales as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }
        $conejo->delete();
        return redirect()->route('conejos.index')->with('success', 'Conejo eliminado correctamente.');
    }
}
