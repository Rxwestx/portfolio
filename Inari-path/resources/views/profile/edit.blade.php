<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="inari-list-page">
        <div class="space-y-4 sm:space-y-5">
            <div class="inari-card border-blade-neon/40 bg-white/90">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="inari-card border-blade-neon/40 bg-white/90">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="inari-card border-blade-neon/40 bg-white/90">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
