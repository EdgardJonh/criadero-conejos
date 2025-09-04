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
        try {
            // Log de la solicitud
            \Log::info('Creando nuevo conejo', [
                'request_data' => $request->all(),
                'files' => $request->allFiles()
            ]);

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
            'precio' => 'required|integer|min:0|max:999999999',
            'disponible' => 'nullable|boolean',
        ], [
            'precio.integer' => 'El precio debe ser un número entero en pesos chilenos (sin decimales)',
            'precio.min' => 'El precio debe ser mayor a 0 pesos',
            'precio.max' => 'El precio no puede exceder 999,999,999 pesos',
        ]);

            // Verificar que la foto principal se subió correctamente
            if (!$request->hasFile('foto_principal')) {
                throw new \Exception('No se subió la foto principal');
            }

            // Guardar foto principal
            $fotoPrincipalPath = $request->file('foto_principal')->store('conejos', 'public');
            \Log::info('Foto principal guardada', ['path' => $fotoPrincipalPath]);

            // Guardar fotos adicionales
            $fotosAdicionales = [];
            if ($request->hasFile('fotos_adicionales')) {
                foreach ($request->file('fotos_adicionales') as $foto) {
                    $fotosAdicionales[] = $foto->store('conejos', 'public');
                }
                \Log::info('Fotos adicionales guardadas', ['paths' => $fotosAdicionales]);
            }

            // Preparar datos para crear el conejo
            $conejoData = [
                'nombre' => $request->nombre,
                'foto_principal' => $fotoPrincipalPath,
                'fotos_adicionales' => $fotosAdicionales,
                'numero' => $request->numero,
                'raza' => $request->raza,
                'color' => $request->color,
                'sexo' => $request->sexo,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'descripcion' => $request->descripcion,
                'precio' => (int) $request->precio,
                'disponible' => $request->has('disponible') ? true : false,
            ];

            \Log::info('Datos del conejo preparados', $conejoData);

            // Crear el conejo
            $conejo = Conejo::create($conejoData);
            
            \Log::info('Conejo creado exitosamente', [
                'conejo_id' => $conejo->id,
                'conejo_data' => $conejo->toArray()
            ]);

            return redirect()->route('conejos.index')
                           ->with('success', '¡Conejo registrado con éxito!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación al crear conejo', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
                           
        } catch (\Exception $e) {
            \Log::error('Error al crear conejo', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                           ->with('error', 'Error al crear el conejo: ' . $e->getMessage())
                           ->withInput();
        }
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
        // Log de la solicitud
        \Log::info('Actualizando conejo', [
            'conejo_id' => $id,
            'request_data' => $request->all(),
            'files' => $request->allFiles()
        ]);
        
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
            'precio' => 'required|integer|min:0|max:999999999',
            'disponible' => 'nullable|boolean',
        ], [
            'precio.integer' => 'El precio debe ser un número entero en pesos chilenos (sin decimales)',
            'precio.min' => 'El precio debe ser mayor a 0 pesos',
            'precio.max' => 'El precio no puede exceder 999,999,999 pesos',
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
            \Log::info('Procesando fotos adicionales', [
                'count' => count($request->file('fotos_adicionales'))
            ]);
            
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
            
            \Log::info('Fotos adicionales procesadas', [
                'paths' => $fotosAdicionales
            ]);
        } else {
            \Log::info('No se encontraron fotos adicionales en la solicitud');
        }

        $conejo->nombre = $request->nombre;
        $conejo->numero = $request->numero;
        $conejo->raza = $request->raza;
        $conejo->color = $request->color;
        $conejo->sexo = $request->sexo;
        $conejo->fecha_nacimiento = $request->fecha_nacimiento;
        $conejo->descripcion = $request->descripcion;
        $conejo->precio = (int) $request->precio;
        $conejo->disponible = $request->has('disponible') ? true : false;
        
        \Log::info('Campo disponible procesado', [
            'request_has_disponible' => $request->has('disponible'),
            'disponible_value' => $conejo->disponible,
            'request_all' => $request->all()
        ]);
        
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
