<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="py-8" style="padding-top: 28px;">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" style="display: grid; gap: 20px;">
            <div style="display: grid; row-gap: 16px; column-gap: 28px; grid-template-columns: repeat(1, minmax(0, 1fr));" class="profile-main-grid">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        <style>
            @media (min-width: 1024px) {
                .profile-main-grid {
                    grid-template-columns: 2fr 1fr !important;
                }
            }
        </style>
    </div>
</x-app-layout>
