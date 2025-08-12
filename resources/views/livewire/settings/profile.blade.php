<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $country = '';
    public string $state = '';
    public string $city = '';
    public string $address = '';
    public string $phone = '';
    public $picture = null;
    public $temp_picture = null;
    public string $postal_code = '';
    public string $bank_name = '';
    public string $bank_code = '';
    public string $bank_account_name = '';
    public string $bank_account_number = '';
    public string $pin = '';
    public $bankData = [];
    public $loading_account_name = false;

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

        $this->loadBanks();
    }

    public function loadBanks()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Accept' => 'application/json',
            ])->get('https://api.paystack.co/bank');

            if ($response->successful()) {
                $this->bankData = $response->json('data');
                Log::info('Successfully retrieved bank list:', $this->bankData);
            } else {
                Log::error('Failed to fetch bank list: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
        }
    }

    public function updatedBankName($value)
    {
        // Find the selected bank's code
        $selectedBank = collect($this->bankData)->firstWhere('name', $value);
        if ($selectedBank) {
            $this->bank_code = $selectedBank['code'];
        }
    }

    public function verifyAccountNumber()
    {
        if (empty($this->bank_code) || empty($this->bank_account_number)) {
            return;
        }

        $this->loading_account_name = true;
        $this->bank_account_name = '';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Accept' => 'application/json',
            ])->get('https://api.paystack.co/bank/resolve', [
                'account_number' => $this->bank_account_number,
                'bank_code' => $this->bank_code,
            ]);

            if ($response->successful()) {
                $this->bank_account_name = $response->json('data.account_name');
            } else {
                $this->bank_account_name = '';
                Session::flash('bank-error', 'Could not verify account number. Please check and try again.');
            }
        } catch (\Exception $e) {
            Log::error('Error verifying account: ' . $e->getMessage());
            Session::flash('bank-error', 'An error occurred while verifying the account.');
        }

        $this->loading_account_name = false;
    }

    public function updatedBankAccountNumber()
    {
        $this->verifyAccountNumber();
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
            'temp_picture' => ['nullable', 'image', 'max:1024'], // 1MB Max
            'postal_code' => ['required', 'string', 'max:20'],
        ]);

        if ($this->temp_picture) {
            if ($user->picture && Storage::exists($user->picture)) {
                Storage::delete($user->picture);
            }
            $path = $this->temp_picture->store('pictures', 'public');
            $validated['picture'] = $path;
        }

        unset($validated['temp_picture']);

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

        if (!is_null($user->bank_name) || !is_null($user->bank_account_name) || !is_null($user->bank_account_number)) {
            Session::flash('bank-error', 'Bank information can only be updated once. Please contact admin support for changes.');
            return;
        }

        if (empty($this->bank_account_name)) {
            Session::flash('bank-error', 'Please ensure the account number is verified before saving.');
            return;
        }

        $validated = $this->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'pin' => ['required', 'string', 'max:4'],
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
        @if (session()->has('bank-error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('bank-error') }}
            </div>
        @endif

        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <div class="flex flex-col items-center">
                @if ($picture)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $picture) }}" alt="Profile Picture"
                            class="w-32 h-32 rounded-full object-cover">
                    </div>
                @endif
                <flux:input wire:model="temp_picture" :label="__('Profile Picture')" type="file" accept="image/*" />
                @error('temp_picture')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus
                autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email"
                    readonly disabled />
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Email cannot be changed. Contact admin support for assistance.') }}</p>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
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

            @role('member')
                <flux:input wire:model="phone" :label="__('Phone')" type="tel" required />
                <flux:input wire:model="country" :label="__('Country')" type="text" required />
                <flux:input wire:model="state" :label="__('State')" type="text" required />
                <flux:input wire:model="city" :label="__('City')" type="text" required />
                <flux:input wire:model="address" :label="__('Address')" type="text" required />
                <flux:input wire:model="postal_code" :label="__('Postal Code')" type="text" required />
            @endrole()

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Profile') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        @role('member')
            <div class="mt-10 pt-10 border-t">
                <h3 class="text-lg font-medium">{{ __('Bank Information') }}</h3>
                <p class="text-sm text-red-600 mb-4">
                    {{ __('Warning: Bank information can only be set once. Contact admin support for any changes after initial setup.') }}
                </p>

                <form wire:submit="updateBankInformation" class="space-y-6">
                    <flux:select wire:model="bank_name" :label="__('Bank Name')" required>
                        <option value="">Select a bank</option>
                        @foreach($bankData ?? [] as $bank)
                            <option value="{{ $bank['name'] }}">{{ $bank['name'] }}</option>
                        @endforeach
                    </flux:select>
                    <flux:input wire:model="bank_account_number" :label="__('Account Number')" type="text" required />
                    <flux:input wire:model="bank_account_name" :label="__('Account Name')" type="text" required readonly disabled />
                    @if($loading_account_name)
                        <div class="text-sm text-gray-500">Verifying account...</div>
                    @endif
                    <flux:input wire:model="pin" :label="__('PIN')" type="password" required maxlength="4" />

                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Bank Information') }}
                            </flux:button>
                        </div>

                        <x-action-message class="me-3" on="bank-updated">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                </form>
            </div>
        @endrole()

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
