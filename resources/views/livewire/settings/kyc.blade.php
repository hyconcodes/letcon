<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $kyc_type = '';
    public $kyc_id = null;
    public $kyc_image = null;
    public $status = 'unverified';
    public $showModal = false;

    public function mount()
    {
        $user = auth()->user();
        $this->kyc_type = $user->kyc_type;
        $this->kyc_id = $user->kyc_id;
        $this->kyc_image = $user->kyc_image;
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function uploadDocuments()
    {
        $validationRules = [
            'kyc_type' => 'required|in:nin,voters_card,driver_license,passport',
            'kyc_id' => 'required|string|min:6',
        ];

        // Only validate image if it's a new file upload (not an existing path string)
        if ($this->kyc_image && is_object($this->kyc_image)) {
            $validationRules['kyc_image'] = 'image|max:2048';
        }

        $this->validate($validationRules);

        $user = auth()->user();

        $updateData = [
            'kyc_type' => $this->kyc_type,
            'kyc_id' => $this->kyc_id,
        ];

        // Only store and update image if a new one was uploaded
        if ($this->kyc_image && is_object($this->kyc_image)) {
            $path = $this->kyc_image->store('kyc_documents', 'public');
            $updateData['kyc_image'] = $path;
        }

        // Update user KYC information
        $user->update($updateData);

        // Refresh the data
        $this->mount();

        session()->flash('message', 'KYC documents uploaded successfully.');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('KYC')" :subheading="__('Complete your identity verification by uploading the required documents')">
        <div class="space-y-6">
            @if (session()->has('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="border rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">{{ __('Identity Verification') }}</h3>

                <div class="space-y-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <h4 class="font-medium text-yellow-800 mb-2">{{ __('Important Instructions:') }}</h4>
                        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                            <li>{{ __('Ensure your ID document is valid and not expired') }}</li>
                            <li>{{ __('Image must be clear, well-lit, and all text should be readable') }}</li>
                            <li>{{ __('File size should not exceed 2MB') }}</li>
                            <li>{{ __('Supported formats: JPG, PNG, JPEG') }}</li>
                        </ul>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('ID Type') }}</label>
                        <flux:select wire:model="kyc_type"
                            class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">{{ __('Select ID Type') }}</option>
                            <option value="nin">{{ __('National Identity Number (NIN)') }}</option>
                            <option value="voters_card">{{ __('Voters Card') }}</option>
                            <option value="driver_license">{{ __('Driver\'s License') }}</option>
                            <option value="passport">{{ __('International Passport') }}</option>
                        </flux:select>
                        @error('kyc_type')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('ID Number') }}</label>
                        <flux:input type="text" wire:model="kyc_id"
                            class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                            placeholder="{{ __('Enter your ID number') }}" />
                        @error('kyc_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('ID Document Image') }}</label>
                        <flux:input type="file" wire:model="kyc_image" class="w-full" accept="image/*" />
                        @error('kyc_image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <flux:button wire:click="uploadDocuments"
                        class="px-4 py-2 !bg-accent !text-white rounded-md !hover:bg-accent">
                        {{ __('Submit Documents') }}
                    </flux:button>
                </div>
            </div>

            <div class="border rounded-lg p-6">
                <h3 class="text-lg font-medium mb-2">{{ __('Current KYC Information') }}</h3>
                @if ($kyc_type)
                    <div class="space-y-2">
                        @if ($kyc_image)
                            <div class="relative group">
                                <img src="{{ storage_asset($kyc_image) }}" alt="KYC Document"
                                    class="w-full h-full object-cover cursor-pointer rounded" wire:click="toggleModal">
                                <div
                                    class="absolute inset-0 bg-green-100 bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded flex items-center justify-center">
                                    <div class="text-center p-2">
                                        <p class="text-sm font-medium">
                                            {{ __(strtoupper(str_replace('_', ' ', $kyc_type))) }}</p>
                                        <p class="text-xs">{{ $kyc_id }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">
                            <span class="font-medium dark:text-zinc-200">{{ __('ID Type:') }}</span>
                            {{ __(strtoupper(str_replace('_', ' ', $kyc_type))) }}
                        </p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">
                            <span class="font-medium dark:text-zinc-200">{{ __('ID Number:') }}</span>
                            {{ $kyc_id }}
                        </p>
                    </div>
                @else
                    <p class="text-sm text-zinc-600">{{ __('No KYC information submitted yet.') }}</p>
                @endif
            </div>
        </div>
    </x-settings.layout>

    @if ($showModal && $kyc_image)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            wire:click="toggleModal">
            <div class="bg-white p-4 rounded-lg max-w-4xl max-h-[90vh] overflow-auto">
                <img src="{{ storage_asset($kyc_image) }}" alt="KYC Document" class="max-w-full">
                <div class="mt-4 bg-green-100 p-3 rounded">
                    <p class="font-medium">{{ __(strtoupper(str_replace('_', ' ', $kyc_type))) }}</p>
                    <p class="text-sm">{{ $kyc_id }}</p>
                </div>
            </div>
        </div>
    @endif
</section>
