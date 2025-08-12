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
    public string $password = '';
    public string $password_confirmation = '';
    public string $ref_code = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'ref_code' => ['nullable', 'string']
        ]);

        if ($this->ref_code) {
            $referrer = User::where('referral_code', $this->ref_code)->first();
            
            if (!$referrer) {
                $this->addError('ref_code', 'Invalid referral code. Please check and try again.');
                return;
            }

            $referralCount = $referrer->referrals()->count();
            if ($referralCount >= 4) {
                // Instead of showing error, get the oldest user with less than 4 referrals
                $referrer = User::role('member')
                    ->where('id', '!=', 1)
                    ->withCount('referrals')
                    ->having('referrals_count', '<', 4)
                    ->orderBy('created_at', 'asc')
                    ->first();
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['referral_code'] = strtoupper(Str::random(8));

        $user = User::create($validated);
        
        // Assign member role using Spatie
        $user->assignRole('member');

        if ($this->ref_code && isset($referrer)) {
            $user->referred_by = $referrer->id;
            $user->save();

            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
            ]);
        } else {
            // Get the oldest user with less than 4 referrals, excluding user with ID 1
            $referrer = User::role('member')
                ->where('id', '!=', 1)
                ->withCount('referrals')
                ->having('referrals_count', '<', 4)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($referrer) {
                $user->referred_by = $referrer->id;
                $user->save();

                Referral::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                ]);
            }
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

        <!-- Referral Code -->
        <flux:input
            wire:model="ref_code"
            :label="__('Referral Code')"
            type="text"
            autocomplete="off"
            :placeholder="__('Referral Code (optional)')"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
