<?php

use App\Models\User;
use App\Models\Referral;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $ref_code = '';
    public string $user_type = 'individual';
    public bool $terms_accepted = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'ref_code' => ['nullable', 'string'],
            'user_type' => ['required', 'in:individual,organization'],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $referrer = null;
        $useOldestUserLogic = false;

        if ($this->ref_code) {
            $potentialReferrer = User::where('referral_code', $this->ref_code)->first();
            
            if (!$potentialReferrer) {
                $this->addError('ref_code', 'Invalid referral code. Please check and try again.');
                return;
            }

            // Check if the referrer has made a payment of 20,000 with status "paid"
            $hasValidPayment = $potentialReferrer->payments()
                ->where('amount', '>=', 20000)
                ->where('status', 'paid')
                ->exists();

            if (!$hasValidPayment) {
                // Don't show error, just use oldest user logic
                $useOldestUserLogic = true;
            } else {
                $referralCount = $potentialReferrer->referrals()->count();
                if ($referralCount >= 4) {
                    // If referrer has 4+ referrals, use oldest user logic
                    $useOldestUserLogic = true;
                } else {
                    // Valid referrer with payment and less than 4 referrals
                    $referrer = $potentialReferrer;
                }
            }
        } else {
            $useOldestUserLogic = true;
        }

        // If we need to use oldest user logic
        if ($useOldestUserLogic) {
            $referrer = User::role('member')
                ->where('id', '!=', 1)
                ->withCount('referrals')
                ->having('referrals_count', '<', 4)
                ->orderBy('created_at', 'asc')
                ->first();
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['referral_code'] = strtoupper(Str::random(8));

        $user = User::create($validated);
        
        // Assign member role using Spatie
        $user->assignRole('member');

        // Check if this is the first member user
        $isFirstMember = User::role('member')->count() === 1;

        if (!$isFirstMember && $referrer) {
            $user->referred_by = $referrer->id;
            $user->save();

            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        session()->flash('status', "Welcome {$this->name}! Your account has been created successfully.");

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Username -->
        <flux:input
            wire:model="username"
            :label="__('Username')"
            type="text"
            required
            autocomplete="username"
            placeholder="username"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <!-- User Type Selection -->
        <div class="flex flex-col gap-2">
            <label class="block font-medium text-sm text-zinc-700 dark:text-zinc-300">
                {{ __('Account Type') }}
            </label>
            <div class="flex gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="user_type" value="individual" class="form-radio" required>
                    <span class="ml-2">{{ __('Individual') }}</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="user_type" value="organization" class="form-radio" required>
                    <span class="ml-2">{{ __('Organization') }}</span>
                </label>
            </div>
        </div>

        <!-- Referral Code -->
        <flux:input
            wire:model="ref_code"
            :label="__('Referral Code')"
            type="text"
            autocomplete="off"
            :placeholder="__('Referral Code (optional)')"
        />

        <div class="flex items-center justify-end">
            <!-- Terms and Conditions -->
            <div class="mt-4">
                <label class="flex items-start">
                    <input type="checkbox" wire:model="terms_accepted" id="terms-checkbox" class="rounded border-zinc-300 text-primary-600 shadow-sm focus:ring-primary-500 mt-1" required>
                    <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('I agree to the') }} 
                        <a href="{{ route('terms-conditions') }}" target="_blank" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                            {{ __('Terms & Conditions') }}
                        </a>
                    </span>
                </label>
                @error('terms_accepted')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <flux:button type="submit" variant="primary" class="w-full mt-4" id="register-button" disabled>
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <!-- JavaScript to handle terms checkbox and button state -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const termsCheckbox = document.getElementById('terms-checkbox');
            const registerButton = document.getElementById('register-button');

            // Function to update button state
            function updateButtonState() {
                if (termsCheckbox.checked) {
                    registerButton.disabled = false;
                    registerButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    registerButton.disabled = true;
                    registerButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // Initial state
            updateButtonState();

            // Listen for checkbox changes
            termsCheckbox.addEventListener('change', updateButtonState);

            // Also listen for Livewire property changes (in case of validation errors)
            document.addEventListener('livewire:init', function() {
                Livewire.on('property-updated', function(property, value) {
                    if (property === 'terms_accepted') {
                        updateButtonState();
                    }
                });
            });
        });
    </script>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>