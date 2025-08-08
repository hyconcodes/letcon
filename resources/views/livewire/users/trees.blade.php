<?php

use Livewire\Volt\Component;
use App\Models\Referral;
use App\Models\User;

new class extends Component {
    public $level;
    public $treeData = [];

    public function mount($level = 3)
    {
        $this->level = min(10, max(1, intval($level)));
        $this->buildTree(auth()->id(), 1);
    }

    private function buildTree($userId, $currentLevel)
    {
        if ($currentLevel > $this->level) return;

        $referrals = User::where('referred_by', $userId)
            ->select('id', 'name', 'picture')
            ->take(4)
            ->get();

        $this->treeData[$currentLevel][] = [
            'parent' => $userId,
            'referrals' => $referrals
        ];

        foreach ($referrals as $referral) {
            $this->buildTree($referral->id, $currentLevel + 1);
        }
    }
}; ?>

<div class="p-4">
    <div class="max-w-7xl mx-auto overflow-x-auto min-w-max">
        @foreach($treeData as $level => $nodes)
            <div class="flex justify-center mb-8">
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach($nodes as $node)
                        @foreach($node['referrals'] as $referral)
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-gold-400 shadow-lg flex items-center justify-center bg-white">
                                    @if($referral->picture)
                                        <img src="{{ Storage::url($referral->picture) }}" 
                                             alt="Profile Photo"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-sm font-medium mt-2">{{ $referral->name }}</span>
                                @if($level < count($treeData))
                                    <div class="w-px h-8 bg-gray-300"></div>
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

