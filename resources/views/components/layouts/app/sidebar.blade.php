<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ auth()->user()->hasRole(['super-admin', 'admin'])
                        ? route('admin.dashboard') 
                        : route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" 
                    :href="auth()->user()->hasRole(['super-admin', 'admin'])
                        ? route('admin.dashboard') 
                        : route('dashboard')"
                    :current="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                @canany(['view.roles', 'create.roles', 'update.roles', 'delete.roles'])
                    <flux:navlist.item icon="shield-check" :href="route('roles')" :current="request()->routeIs('roles')"
                        wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                @endcanany

                @canany(['view.member', 'create.member', 'update.member', 'delete.member'])
                    <flux:navlist.item icon="users" :href="route('members')" :current="request()->routeIs('members')"
                        wire:navigate class="hidden">{{ __('Create Member') }}</flux:navlist.item>
                @endcanany

                @can(['view.member'])
                    <flux:navlist.item icon="users" :href="route('users')" :current="request()->routeIs('users')"
                        wire:navigate>{{ __('Manage Members') }}</flux:navlist.item>
                @endcan

                @canany(['view.wallet', 'fund.wallet', 'withdraw.wallet'])
                    <flux:navlist.item icon="wallet" :href="route('wallets')" :current="request()->routeIs('wallets')"
                        wire:navigate>{{ __('Wallets') }}</flux:navlist.item>
                @endcanany

                @canany(['view.board'])
                    <flux:navlist.item icon="arrow-trending-up" :href="route('boards')" :current="request()->routeIs('boards')"
                        wire:navigate>{{ __('Stage Level') }}</flux:navlist.item>
                @endcanany

                @canany(['view.payment'])
                    <flux:navlist.item icon="credit-card" :href="route('payments')" :current="request()->routeIs('payments')"
                        wire:navigate>{{ __('Manage Payments') }}</flux:navlist.item>
                @endcanany

                @canany(['view.agent', 'create.agent', 'update.agent', 'delete.agent'])
                    <flux:navlist.item icon="user" :href="route('agents')" :current="request()->routeIs('agents')"
                        wire:navigate>{{ __('Manage Agents') }}</flux:navlist.item>
                @endcanany

                @canany(['view.withdrawal', 'pending.withdrawal', 'approve.withdrawal', 'reject.withdrawal', 'delete.withdrawal'])
                    <flux:navlist.item icon="user" :href="route('admin.withdrawals')" :current="request()->routeIs('admin.withdrawals')"
                        wire:navigate>{{ __('Manage Users Withdrawals') }}</flux:navlist.item>
                @endcanany

                @canany(['view.notification', 'create.notification', 'update.notification', 'delete.notification'])
                    <flux:navlist.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')"
                        wire:navigate>{{ __('Manage Notifications') }}</flux:navlist.item>
                @endcanany

                @role('member')
                <flux:navlist.group heading="Transaction Logs" expandable>
                    <flux:navlist.item href="{{ route('earnings.log') }}">Earning History</flux:navlist.item>
                    <flux:navlist.item href="{{ route('deposits.log') }}">Deposit History</flux:navlist.item>
                    <flux:navlist.item href="{{ route('withdrawal.log') }}">Withdrawal History</flux:navlist.item>
                </flux:navlist.group>
                @endrole()

                <flux:navlist.item icon="user" :href="route('settings.profile')" :current="request()->routeIs('settings.profile')"
                            wire:navigate>{{ __('Profile Settings') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline" class="hidden">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                <flux:menu.separator />
                </flux:menu.radio.group>
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                    <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                </flux:radio.group>
                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                    <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                </flux:radio.group>
                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
