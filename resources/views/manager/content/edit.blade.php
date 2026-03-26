<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contenido del Inicio</h2>
    </x-slot>

    <div class="py-8" style="padding-top: 28px;">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('status'))
                    <p style="margin-bottom: 12px; color: #15803d; font-weight: 600;">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ route('manager.content.update') }}" style="display: grid; gap: 14px;">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="about_us" style="display: block; font-weight: 600; margin-bottom: 6px;">Quienes somos</label>
                        <textarea id="about_us" name="about_us" rows="4" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;">{{ old('about_us', $content->about_us) }}</textarea>
                        @error('about_us') <p style="color: #dc2626; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="mission" style="display: block; font-weight: 600; margin-bottom: 6px;">Mision</label>
                        <textarea id="mission" name="mission" rows="4" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;">{{ old('mission', $content->mission) }}</textarea>
                        @error('mission') <p style="color: #dc2626; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="vision" style="display: block; font-weight: 600; margin-bottom: 6px;">Vision</label>
                        <textarea id="vision" name="vision" rows="4" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;">{{ old('vision', $content->vision) }}</textarea>
                        @error('vision') <p style="color: #dc2626; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" style="display: block; font-weight: 600; margin-bottom: 6px;">Ubicacion</label>
                        <textarea id="location" name="location" rows="3" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;">{{ old('location', $content->location) }}</textarea>
                        @error('location') <p style="color: #dc2626; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact" style="display: block; font-weight: 600; margin-bottom: 6px;">Contactanos</label>
                        <textarea id="contact" name="contact" rows="3" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;">{{ old('contact', $content->contact) }}</textarea>
                        @error('contact') <p style="color: #dc2626; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="display: flex; gap: 10px; align-items: center; margin-top: 6px;">
                        <button type="submit" style="background: #2563eb; color: #ffffff; border: 0; border-radius: 6px; padding: 10px 14px; font-weight: 700; cursor: pointer;">
                            Guardar cambios
                        </button>
                        <a href="{{ route('manager.dashboard') }}" style="display: inline-block; background: #e5e7eb; color: #111827; padding: 10px 14px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

