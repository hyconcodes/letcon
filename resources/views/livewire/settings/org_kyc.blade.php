<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $name;
    public $kyc_org_image = null;
    public $kyc_image = null;
    public $showModal = false;

    public function mount()
    {
        $user = auth()->user();
        if ($user->user_type !== 'organization') {
            abort(403);
        };
        $this->name = $user->name;
        $this->kyc_org_image = $user->kyc_org_image;
        $this->kyc_image = $user->kyc_image;
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function uploadDocuments()
    {
        $validationRules = [
            'name' => 'required|string|max:255',
        ];

        // Validate images if they are new file uploads
        if ($this->kyc_org_image && is_object($this->kyc_org_image)) {
            $validationRules['kyc_org_image'] = 'image|max:5048';
        }
        if ($this->kyc_image && is_object($this->kyc_image)) {
            $validationRules['kyc_image'] = 'image|max:5048';
        }

        $this->validate($validationRules);

        $user = auth()->user();
        $updateData = ['name' => $this->name];

        // Store and update organization image if uploaded
        if ($this->kyc_org_image && is_object($this->kyc_org_image)) {
            $orgPath = $this->kyc_org_image->store('kyc_documents', 'public');
            $updateData['kyc_org_image'] = $orgPath;
        }

        // Store and update KYC image if uploaded
        if ($this->kyc_image && is_object($this->kyc_image)) {
            $kycPath = $this->kyc_image->store('kyc_documents', 'public');
            $updateData['kyc_image'] = $kycPath;
        }

        // Update user information
        $user->update($updateData);

        // Refresh the data
        $this->mount();

        session()->flash('message', 'Organization documents uploaded successfully.');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Organization KYC')" :subheading="__('Complete your organization verification by uploading the required documents')">
        <div class="space-y-6">
            @if (session()->has('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="border rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">{{ __('Organization Verification') }}</h3>

                <div class="space-y-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <h4 class="font-medium text-yellow-800 mb-2">{{ __('Important Instructions:') }}</h4>
                        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                            <li>{{ __('Organization documents must be valid and current') }}</li>
                            <li>{{ __('Images must be clear and well-lit') }}</li>
                            <li>{{ __('File size should not exceed 2MB') }}</li>
                            <li>{{ __('Supported formats: JPG, PNG, JPEG') }}</li>
                        </ul>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Organization Name') }}</label>
                        <flux:input type="text" wire:model="name"
                            class="w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                            placeholder="{{ __('Enter organization name') }}" />
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __("Initiator NIN or Voter's Card Document") }}</label>
                        <p class="text-sm text-yellow-600 mb-2">Upload a clear image of the NIN or Voter's card belonging to the person in charge of this organization</p>
                        <flux:input type="file" wire:model="kyc_image" class="w-full" accept="image/*" />
                        @error('kyc_image')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __("Organization Photo") }}</label>
                        <p class="text-sm text-yellow-600 mb-2">Upload a clear photo of your organization's physical location or official premises</p>
                        <flux:input type="file" wire:model="kyc_org_image" class="w-full" accept="image/*" />
                        @error('kyc_org_image')
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
                <h3 class="text-lg font-medium mb-2">{{ __('Current Organization Information') }}</h3>
                <div class="space-y-4">
                    <p class="text-sm text-zinc-600 dark:text-zinc-300">
                        <span class="font-medium dark:text-zinc-200">{{ __('Organization Name:') }}</span>
                        {{ $name }}
                    </p>

                    @if ($kyc_image)
                        <div>
                            <h4 class="text-sm font-medium mb-2">{{ __("Initiator NIN or Voter's Card Document") }}</h4>
                            <div class="relative group">
                                <img src="{{ asset('storage/app/public/' . $kyc_image) }}" alt="Supporting Document"
                                    class="w-full h-full object-cover cursor-pointer rounded" wire:click="toggleModal">
                            </div>
                        </div>
                    @endif

                    @if ($kyc_org_image)
                        <div>
                            <h4 class="text-sm font-medium mb-2">{{ __('Organization Photo:') }}</h4>
                            <div class="relative group">
                                <img src="{{ asset('storage/app/public/' . $kyc_org_image) }}" alt="Organization Document"
                                    class="w-full h-full object-cover cursor-pointer rounded" wire:click="toggleModal">
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </x-settings.layout>

    @if ($showModal && ($kyc_org_image || $kyc_image))
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            wire:click="toggleModal">
            <div class="bg-white p-4 rounded-lg max-w-4xl max-h-[90vh] overflow-auto">
                <img src="{{ asset('storage/app/public/' . ($kyc_org_image ?: $kyc_image)) }}" alt="Document" class="max-w-full">
                <div class="mt-4 bg-green-100 p-3 rounded">
                    <p class="font-medium text-accent-content">{{ $name }}</p>
                </div>
            </div>
        </div>
    @endif
</section>
