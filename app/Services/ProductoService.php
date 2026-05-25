<?php

namespace App\Services;

use App\Models\Foto;
use App\Models\Producto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductoService
{
    private const DISCO = 'public';

    public function crear(array $datos, array $categorias, array $fotos = []): Producto
    {
        $producto = Producto::create([
            'vendedor_id' => $datos['vendedor_id'],
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
        ]);

        $producto->categorias()->sync($categorias);

        $this->guardarFotos($producto, $fotos);

        return $producto;
    }

    public function actualizar(
        Producto $producto,
        array $datos,
        array $categorias,
        array $fotosNuevas = [],
        array $fotosEliminarIds = [],
    ): Producto {
        $cambios = [
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
        ];

        if (array_key_exists('vendedor_id', $datos)) {
            $cambios['vendedor_id'] = $datos['vendedor_id'];
        }

        $producto->update($cambios);

        $producto->categorias()->sync($categorias);

        if (! empty($fotosEliminarIds)) {
            $this->eliminarFotos($producto, $fotosEliminarIds);
        }

        $this->guardarFotos($producto, $fotosNuevas);

        return $producto->fresh(['fotos', 'categorias']);
    }

    public function eliminar(Producto $producto): void
    {
        $carpeta = "products/{$producto->id}";

        if (Storage::disk(self::DISCO)->exists($carpeta)) {
            Storage::disk(self::DISCO)->deleteDirectory($carpeta);
        }

        $producto->delete();
    }

    /**
     * @param  array<UploadedFile>  $archivos
     */
    private function guardarFotos(Producto $producto, array $archivos): void
    {
        if (empty($archivos)) {
            return;
        }

        $carpeta = "products/{$producto->id}";

        foreach ($archivos as $archivo) {
            if (! $archivo instanceof UploadedFile) {
                continue;
            }

            $ruta = $archivo->store($carpeta, self::DISCO);

            Foto::create([
                'producto_id' => $producto->id,
                'ruta' => $ruta,
            ]);
        }
    }

    /**
     * @param  array<int>  $fotoIds
     */
    private function eliminarFotos(Producto $producto, array $fotoIds): void
    {
        $fotos = $producto->fotos()->whereIn('id', $fotoIds)->get();

        foreach ($fotos as $foto) {
            if (Storage::disk(self::DISCO)->exists($foto->ruta)) {
                Storage::disk(self::DISCO)->delete($foto->ruta);
            }
            $foto->delete();
        }
    }
}
