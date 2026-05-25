<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Foto;
use App\Models\Producto;
use App\Models\User;
use Database\Factories\ProductoFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductoSeeder extends Seeder
{
    private static string $placeholderJpeg = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/wAAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAf/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AKwAB//Z';

    public function run(): void
    {
        $categoriasPorNombre = Categoria::pluck('id', 'nombre');

        if ($categoriasPorNombre->isEmpty()) {
            return;
        }

        // Mapa nombre-categoría para asignar correctamente según el factory
        $mapaCategorias = [
            'Laptops'     => 'Laptops',
            'Smartphones' => 'Smartphones',
            'Tablets'     => 'Tablets',
            'Monitores'   => 'Monitores',
            'Periféricos' => 'Periféricos',
            'Audio'       => 'Audio',
            'Cámaras'     => 'Cámaras',
            'Accesorios'  => 'Accesorios',
        ];

        $productosDef = $this->productosDefinicion();
        $vendedores = User::where('rol', 'vendedor')->pluck('id')->all();

        if (empty($vendedores)) {
            return;
        }

        // Cada vendedor recibe mínimo 3 productos (PDF sec. 6).
        foreach ($vendedores as $vendedorId) {
            $cantidad = rand(3, 5);
            $seleccion = collect($productosDef)->random(min($cantidad, count($productosDef)));

            foreach ($seleccion as $def) {
                $producto = Producto::create([
                    'vendedor_id' => $vendedorId,
                    'nombre'      => $def['nombre'],
                    'descripcion' => $def['descripcion'],
                    'precio'      => $def['precio'],
                    'stock'       => rand(5, 50),
                ]);

                $categoriaId = $categoriasPorNombre->get($def['categoria']);
                if ($categoriaId) {
                    $producto->categorias()->sync([$categoriaId]);
                }

                $this->crearFotoPlaceholder($producto->id);
            }
        }
    }

    private function crearFotoPlaceholder(int $productoId): void
    {
        $disco = Storage::disk('public');
        $ruta = "products/{$productoId}/placeholder.jpg";
        $disco->put($ruta, base64_decode(self::$placeholderJpeg));

        Foto::create([
            'producto_id' => $productoId,
            'ruta'        => $ruta,
        ]);
    }

    private function productosDefinicion(): array
    {
        return [
            ['nombre' => 'MacBook Pro 14"', 'descripcion' => 'Laptop Apple M3 Pro, 18 GB RAM, SSD 512 GB, pantalla Liquid Retina XDR.', 'precio' => 29999, 'categoria' => 'Laptops'],
            ['nombre' => 'Dell XPS 13 Plus', 'descripcion' => 'Ultrabook Intel Core i7-1360P, 16 GB LPDDR5, SSD 512 GB, pantalla OLED 13.4".', 'precio' => 22499, 'categoria' => 'Laptops'],
            ['nombre' => 'ASUS ZenBook 14 OLED', 'descripcion' => 'Laptop Ryzen 7, 16 GB RAM, SSD 1 TB, pantalla OLED 2.8K 90 Hz.', 'precio' => 16999, 'categoria' => 'Laptops'],
            ['nombre' => 'HP Spectre x360 16"', 'descripcion' => 'Convertible 2-en-1 Intel i7, 16 GB DDR5, pantalla OLED táctil con lápiz.', 'precio' => 24999, 'categoria' => 'Laptops'],
            ['nombre' => 'Lenovo ThinkPad X1 Carbon', 'descripcion' => 'Business laptop ultradelgado, Core i7, 16 GB RAM, certificación militar.', 'precio' => 26499, 'categoria' => 'Laptops'],

            ['nombre' => 'iPhone 15 Pro Max', 'descripcion' => 'Apple A17 Pro, 256 GB, cámara 48 MP triple, titanio, Dynamic Island.', 'precio' => 22999, 'categoria' => 'Smartphones'],
            ['nombre' => 'Samsung Galaxy S24 Ultra', 'descripcion' => 'Snapdragon 8 Gen 3, 12 GB RAM, cámara 200 MP, S Pen incluido.', 'precio' => 21499, 'categoria' => 'Smartphones'],
            ['nombre' => 'Google Pixel 8 Pro', 'descripcion' => 'Tensor G3, 12 GB RAM, cámara pro con IA, 7 años de actualizaciones.', 'precio' => 15999, 'categoria' => 'Smartphones'],
            ['nombre' => 'OnePlus 12', 'descripcion' => 'Snapdragon 8 Gen 3, 12 GB RAM, carga rápida 100 W, AMOLED 120 Hz.', 'precio' => 12999, 'categoria' => 'Smartphones'],
            ['nombre' => 'Motorola Edge 40 Pro', 'descripcion' => 'Snapdragon 8 Gen 2, 12 GB RAM, pantalla pOLED curva 165 Hz, carga 125 W.', 'precio' => 11499, 'categoria' => 'Smartphones'],

            ['nombre' => 'iPad Pro 12.9" M2', 'descripcion' => 'Apple M2, 256 GB, pantalla Liquid Retina XDR, Apple Pencil 2.', 'precio' => 19999, 'categoria' => 'Tablets'],
            ['nombre' => 'Samsung Galaxy Tab S9+', 'descripcion' => 'Snapdragon 8 Gen 2, 12 GB RAM, pantalla AMOLED 12.4" 120 Hz, S Pen.', 'precio' => 17499, 'categoria' => 'Tablets'],
            ['nombre' => 'Lenovo Tab P12 Pro', 'descripcion' => 'Snapdragon 870, 8 GB RAM, pantalla AMOLED 12.6" 120 Hz, stylus.', 'precio' => 10999, 'categoria' => 'Tablets'],
            ['nombre' => 'Microsoft Surface Pro 9', 'descripcion' => 'Core i7, 16 GB RAM, 256 GB SSD, pantalla 13" 120 Hz, teclado opcional.', 'precio' => 22999, 'categoria' => 'Tablets'],

            ['nombre' => 'LG UltraWide 34" 4K', 'descripcion' => 'Monitor curvo QHD 3440×1440, 144 Hz, IPS, USB-C 96 W, HDR400.', 'precio' => 12499, 'categoria' => 'Monitores'],
            ['nombre' => 'Samsung Odyssey G7 27"', 'descripcion' => 'Monitor gaming curvo 1000R, QHD 240 Hz, 1 ms GTG, G-Sync compatible.', 'precio' => 9999, 'categoria' => 'Monitores'],
            ['nombre' => 'Dell UltraSharp U2723QE', 'descripcion' => 'Monitor 4K 27" IPS Black, USB-C hub, calibración de fábrica, ΔE < 2.', 'precio' => 11499, 'categoria' => 'Monitores'],
            ['nombre' => 'ASUS ProArt PA329CV', 'descripcion' => 'Monitor 4K 32" IPS, 100% sRGB, Adobe RGB 99%, USB-C 96W, diseño profesional.', 'precio' => 13999, 'categoria' => 'Monitores'],

            ['nombre' => 'Logitech MX Master 3S', 'descripcion' => 'Mouse inalámbrico 8000 DPI, scroll MagSpeed, hasta 3 dispositivos, silencioso.', 'precio' => 1999, 'categoria' => 'Periféricos'],
            ['nombre' => 'Keychron K2 Pro', 'descripcion' => 'Teclado mecánico inalámbrico 75%, switches Gateron, RGB, Mac/Windows.', 'precio' => 2499, 'categoria' => 'Periféricos'],
            ['nombre' => 'Razer DeathAdder V3', 'descripcion' => 'Mouse gaming 30000 DPI, Focus Pro sensor, diseño ergonómico ultra ligero.', 'precio' => 1699, 'categoria' => 'Periféricos'],
            ['nombre' => 'Corsair K100 RGB', 'descripcion' => 'Teclado mecánico gaming, OPX switches ópticos, rueda de control, AXON 44-Zone RGB.', 'precio' => 3499, 'categoria' => 'Periféricos'],
            ['nombre' => 'Elgato Stream Deck MK.2', 'descripcion' => '15 teclas LCD personalizables, integración con OBS, streaming y productividad.', 'precio' => 2999, 'categoria' => 'Periféricos'],

            ['nombre' => 'Sony WH-1000XM5', 'descripcion' => 'Auriculares over-ear ANC líder, 30 h batería, carga rápida, micrófono dual.', 'precio' => 5999, 'categoria' => 'Audio'],
            ['nombre' => 'Apple AirPods Pro 2', 'descripcion' => 'Auriculares in-ear ANC adaptativo, audio espacial, chip H2, estuche MagSafe.', 'precio' => 5499, 'categoria' => 'Audio'],
            ['nombre' => 'JBL Charge 5', 'descripcion' => 'Bocina portátil Bluetooth IP67, 20 h autonomía, power bank integrado, PartyBoost.', 'precio' => 3199, 'categoria' => 'Audio'],
            ['nombre' => 'Bose QuietComfort 45', 'descripcion' => 'Auriculares ANC premium, modo Aware, 24 h batería, plegables, audio cristalino.', 'precio' => 5299, 'categoria' => 'Audio'],

            ['nombre' => 'Sony Alpha a7 IV', 'descripcion' => 'Mirrorless full-frame 33 MP, 4K 60fps, IBIS 5 ejes, Eye-AF, dual SD.', 'precio' => 38999, 'categoria' => 'Cámaras'],
            ['nombre' => 'Canon EOS R8', 'descripcion' => 'Mirrorless full-frame 24.2 MP, 4K 60fps, DPAF II, ideal para iniciantes.', 'precio' => 18499, 'categoria' => 'Cámaras'],
            ['nombre' => 'GoPro HERO12 Black', 'descripcion' => 'Cámara de acción 5.3K 60fps, HyperSmooth 6.0, HDR, sumergible 10 m.', 'precio' => 8999, 'categoria' => 'Cámaras'],

            ['nombre' => 'Hub USB-C 12 en 1', 'descripcion' => 'Docking station HDMI 4K, DP, 4×USB-A, SD/microSD, Ethernet, PD 100W.', 'precio' => 1299, 'categoria' => 'Accesorios'],
            ['nombre' => 'Cargador Anker GaN 120W', 'descripcion' => 'Cargador 4 puertos (2×USB-C + 2×USB-A), GaN, carga simultánea hasta 120W.', 'precio' => 999, 'categoria' => 'Accesorios'],
            ['nombre' => 'Soporte Laptop Ajustable', 'descripcion' => 'Soporte ergonómico aluminio, 6 alturas, plegable, 10-17", disipación de calor.', 'precio' => 699, 'categoria' => 'Accesorios'],
            ['nombre' => 'Webcam Logitech C920s', 'descripcion' => '1080p 30fps, cobertura de privacidad, micrófono estéreo, Teams/Zoom.', 'precio' => 1599, 'categoria' => 'Accesorios'],
            ['nombre' => 'SSD Externo Samsung T7', 'descripcion' => 'Disco SSD portátil 1 TB, USB 3.2 Gen 2, 1050 MB/s lectura, resistente a golpes.', 'precio' => 1899, 'categoria' => 'Accesorios'],
        ];
    }
}
