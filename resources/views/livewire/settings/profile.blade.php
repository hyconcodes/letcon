<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $country = '';
    public string $state = '';
    public string $city = '';
    public string $address = '';
    public string $phone = '';
    public string $picture = '';
    public string $postal_code = '';
    public string $bank_name = '';
    public string $bank_account_name = '';
    public string $bank_account_number = '';
    public string $pin = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->country = $user->country ?? '';
        $this->state = $user->state ?? '';
        $this->city = $user->city ?? '';
        $this->address = $user->address ?? '';
        $this->phone = $user->phone ?? '';
        $this->picture = $user->picture ?? '';
        $this->postal_code = $user->postal_code ?? '';
        $this->bank_name = $user->bank_name ?? '';
        $this->bank_account_name = $user->bank_account_name ?? '';
        $this->bank_account_number = $user->bank_account_number ?? '';
        $this->pin = $user->pin ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'picture' => ['nullable', 'string'],
            'postal_code' => ['required', 'string', 'max:20'],
        ]);

        $user->fill($validated);
        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Update bank information only if fields are null
     */
    public function updateBankInformation(): void
    {
        $user = Auth::user();

        // Only allow updates if bank fields are null
        if (!is_null($user->bank_name) || !is_null($user->bank_account_name) || !is_null($user->bank_account_number)) {
            Session::flash('bank-error', 'Bank information can only be updated once. Please contact admin support for changes.');
            return;
        }

        $validated = $this->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'pin' => ['required', 'string', 'max:6'],
        ]);

        $user->fill($validated);
        $user->save();

        $this->dispatch('bank-updated');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information')">
        @if(session()->has('bank-error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('bank-error') }}
            </div>
        @endif

        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" disabled />
                <p class="text-sm text-gray-500 mt-1">{{ __('Email cannot be changed. Contact admin support for assistance.') }}</p>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <flux:input wire:model="phone" :label="__('Phone')" type="tel" required />
            <flux:input wire:model="country" :label="__('Country')" type="text" required />
            <flux:input wire:model="state" :label="__('State')" type="text" required />
            <flux:input wire:model="city" :label="__('City')" type="text" required />
            <flux:input wire:model="address" :label="__('Address')" type="text" required />
            <flux:input wire:model="postal_code" :label="__('Postal Code')" type="text" required />
            <flux:input wire:model="picture" :label="__('Profile Picture URL')" type="text" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Profile') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <div class="mt-10 pt-10 border-t">
            <h3 class="text-lg font-medium">{{ __('Bank Information') }}</h3>
            <p class="text-sm text-red-600 mb-4">{{ __('Warning: Bank information can only be set once. Contact admin support for any changes after initial setup.') }}</p>

            <form wire:submit="updateBankInformation" class="space-y-6">
                <flux:input wire:model="bank_name" :label="__('Bank Name')" type="text" required />
                <flux:input wire:model="bank_account_name" :label="__('Account Name')" type="text" required />
                <flux:input wire:model="bank_account_number" :label="__('Account Number')" type="text" required />
                <flux:input wire:model="pin" :label="__('PIN')" type="password" required maxlength="6" />

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Bank Information') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="bank-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        </div>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
