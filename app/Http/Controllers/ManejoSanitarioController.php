<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManejoSanitario;
use App\Models\Conejo;

class ManejoSanitarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manejoSanitario = ManejoSanitario::with('conejo')->orderBy('fecha_control', 'desc')->get();
        return view('manejo-sanitario.index', compact('manejoSanitario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $conejos = Conejo::where('disponible', true)->orderBy('nombre')->get();
        return view('manejo-sanitario.create', compact('conejos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conejo_id' => 'required|exists:conejos,id',
            'fecha_control' => 'required|date',
            'tipo_control' => 'required|in:Vacunación,Desparasitación,Revisión médica,Tratamiento,Enfermedad,Otro',
            'producto_aplicado' => 'nullable|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'via_administracion' => 'nullable|in:Oral,Inyectable,Tópica',
            'veterinario' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'proximo_control' => 'nullable|date|after:fecha_control',
            'estado' => 'required|in:Pendiente,Completado,En tratamiento,Recuperado',
        ]);

        ManejoSanitario::create($request->all());

        return redirect()->route('manejo-sanitario.index')
                        ->with('success', 'Manejo sanitario registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ManejoSanitario $manejoSanitario)
    {
        $manejoSanitario->load('conejo');
        return view('manejo-sanitario.show', compact('manejoSanitario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManejoSanitario $manejoSanitario)
    {
        $conejos = Conejo::orderBy('nombre')->get();
        return view('manejo-sanitario.edit', compact('manejoSanitario', 'conejos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManejoSanitario $manejoSanitario)
    {
        $request->validate([
            'conejo_id' => 'required|exists:conejos,id',
            'fecha_control' => 'required|date',
            'tipo_control' => 'required|in:Vacunación,Desparasitación,Revisión médica,Tratamiento,Enfermedad,Otro',
            'producto_aplicado' => 'nullable|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'via_administracion' => 'nullable|in:Oral,Inyectable,Tópica',
            'veterinario' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'proximo_control' => 'nullable|date|after:fecha_control',
            'estado' => 'required|in:Pendiente,Completado,En tratamiento,Recuperado',
        ]);

        $manejoSanitario->update($request->all());

        return redirect()->route('manejo-sanitario.index')
                        ->with('success', 'Manejo sanitario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManejoSanitario $manejoSanitario)
    {
        $manejoSanitario->delete();

        return redirect()->route('manejo-sanitario.index')
                        ->with('success', 'Manejo sanitario eliminado correctamente.');
    }
}
