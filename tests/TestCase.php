<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase
{
    /**
     * PNG 1x1 transparente real (validable por la regla `image` de Laravel)
     * embebido en base64 — evita depender de la extensión GD en CI/local.
     */
    private const PNG_1X1_BASE64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    /**
     * Crea un UploadedFile fake con contenido PNG válido para usar en pruebas
     * que requieren la regla `image` sin depender de GD.
     */
    protected function imagenFake(string $nombre = 'foto.png'): UploadedFile
    {
        $tmp = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tmp, base64_decode(self::PNG_1X1_BASE64));

        return new UploadedFile(
            $tmp,
            $nombre,
            'image/png',
            null,
            true // test mode: omite validaciones de upload real
        );
    }
}
