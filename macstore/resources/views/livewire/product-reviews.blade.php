<div class="mt-12">
    <h2 class="text-3xl font-bold mb-8">{{ __('Customer Reviews') }}</h2>

    <!-- Rating Summary -->
    @if($reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Average Rating -->
            <x-card class="p-6">
             <div class="text-center">
                    <div class="text-6xl font-bold text-accent mb-2">
                {{ number_format($averageRating, 1) }}
            </div>
              <div class="flex justify-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'text-yellow fill-current' : 'text-gray-300' }}"
                         viewBox="0 0 20 20">
                          <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
                 @endfor
               </div>
            <p class="text-text-secondary-light dark:text-text-secondary-dark">
        {{ __('Based on') }} {{ $reviews->count() }} {{ __('reviews') }}
                    </p>
                </div>
            </x-card>

            <!-- Rating Breakdown -->
            <x-card class="p-6">
                @foreach([5, 4, 3, 2, 1] as $star)
                  <div class="flex items-center gap-4 mb-2">
                        <span class="text-sm w-12">{{ $star }} {{ __('star') }}</span>
                 <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                  <div class="h-full bg-accent"
                         style="width: {{ $reviews->count() > 0 ? ($ratingCounts[$star] / $reviews->count() * 100) : 0 }}%"></div>
                     </div>
                      <span class="text-sm w-12 text-right">{{ $ratingCounts[$star] }}</span>
             </div>
            @endforeach
       </x-card>
        </div>
    @endif

    <!-- Write Review Button -->
    @auth
        @if(!$showForm)
            <div class="mb-8">
             <x-button variant="primary" wire:click="toggleForm">
                    {{ __('Write a Review') }}
                </x-button>
            </div>
      @endif
    @else
        <div class="mb-8">
            <p class="text-text-secondary-light dark:text-text-secondary-dark">
                <a href="{{ route('login') }}" class="text-accent hover:underline">{{ __('Login') }}</a>
                {{ __('to write a review') }}
            </p>
        </div>
    @endauth

    <!-- Review Form -->
    @if($showForm)
      <x-card class="p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">{{ __('Write Your Review') }}</h3>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green/10 text-green rounded-button">
                    {{ session('success') }}
                </div>
            @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red/10 text-red rounded-button">
                    {{ session('error') }}
            </div>
            @endif

            <form wire:submit="submitReview">
              <div class="mb-4">
             <label class="block text-sm font-medium mb-2">{{ __('Rating') }}</label>
           <div class="flex gap-2">
           @for($i = 1; $i <= 5; $i++)
                          <button type="button"
                          wire:click="$set('rating', {{ $i }})"
                                 class="focus:outline-none">
                 <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow fill-current' : 'text-gray-300' }}"
                              viewBox="0 0 20 20">
                             <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                  </svg>
                    </button>
                        @endfor
             </div>
           @error('rating') <span class="text-red text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
             <x-textarea
                  wire:model="comment"
                   label="{{ __('Your Review') }}"
                  placeholder="{{ __('Share your experience with this product...') }}"
                  rows="4"
                      required
                 />
              @error('comment') <span class="text-red text-sm">{{ $message }}</span> @enderror
                </div>

              <div class="flex gap-4">
                    <x-button type="submit" variant="primary">
                      {{ __('Submit Review') }}
               </x-button>
                  <x-button type="button" variant="ghost" wire:click="toggleForm">
                  {{ __('Cancel') }}
             </x-button>
         </div>
            </form>
        </x-card>
    @endif

    <!-- Reviews List -->
    @if($reviews->count() > 0)
        <div class="space-y-6">
            @foreach($reviews as $review)
                <x-card class="p-6">
               <div class="flex justify-between items-start mb-4">
                     <div>
                  <h4 class="font-bold">{{ $review->user->name }}</h4>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                    {{ $review->created_at->format('F d, Y') }}
          </p>
                 </div>
                  <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                              <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow fill-current' : 'text-gray-300' }}"
                         viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                           </svg>
                    @endfor
               </div>
                 </div>
                    <p class="text-text-primary-light dark:text-text-primary-dark">
                   {{ $review->comment }}
                    </p>
                </x-card>
            @endforeach
      </div>
    @else
        <x-card class="p-12 text-center">
            <p class="text-text-secondary-light dark:text-text-secondary-dark">
                {{ __('No reviews yet. Be the first to review this product!') }}
            </p>
     </x-card>
    @endif
</div>
