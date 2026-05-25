<?php

namespace App\Services;

use App\Mail\CodigoVerificacionMail;
use App\Models\CodigoVerificacion;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TwoFactorService
{
    public const MINUTOS_VIGENCIA = 5;

    public function emitirCodigo(User $usuario, ?string $ip = null): void
    {
        CodigoVerificacion::where('usuario_id', $usuario->id)->delete();

        $codigo = (string) random_int(100000, 999999);

        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => Hash::make($codigo),
            'expiracion' => now()->addMinutes(self::MINUTOS_VIGENCIA),
        ]);

        Mail::to($usuario->email)->send(
            new CodigoVerificacionMail($usuario, $codigo, self::MINUTOS_VIGENCIA)
        );

        Log::channel('autenticacion')->info('codigo_otp_generado', [
            'usuario_id' => $usuario->id,
            'ip' => $ip,
        ]);
    }

    public function verificarCodigo(User $usuario, string $codigo, ?string $ip = null): string
    {
        $registro = CodigoVerificacion::where('usuario_id', $usuario->id)
            ->latest('id')
            ->first();

        if (! $registro) {
            Log::channel('autenticacion')->info('codigo_invalido', [
                'usuario_id' => $usuario->id,
                'ip' => $ip,
            ]);

            return 'invalido';
        }

        if ($registro->expiracion->isPast()) {
            $registro->delete();

            Log::channel('autenticacion')->info('codigo_expirado', [
                'usuario_id' => $usuario->id,
                'ip' => $ip,
            ]);

            return 'expirado';
        }

        if (! Hash::check($codigo, $registro->codigo)) {
            Log::channel('autenticacion')->info('codigo_invalido', [
                'usuario_id' => $usuario->id,
                'ip' => $ip,
            ]);

            return 'invalido';
        }

        $registro->delete();

        Log::channel('autenticacion')->info('codigo_validado', [
            'usuario_id' => $usuario->id,
            'ip' => $ip,
        ]);

        return 'ok';
    }
}
