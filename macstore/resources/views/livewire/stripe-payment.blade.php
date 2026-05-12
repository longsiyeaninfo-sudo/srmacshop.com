<div>
    <x-layouts.storefront>
        <x-slot name="title">{{ __('Payment') }}</x-slot>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold mb-8">{{ __('Complete Payment') }}</h1>

            @if(session('success'))
          <div class="mb-6 p-4 bg-green/10 text-green rounded-button">
                 {{ session('success') }}
           </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red/10 text-red rounded-button">
             {{ session('error') }}
                </div>
            @endif

            <x-card class="p-8">
                <!-- Order Summary -->
              <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">{{ __('Order Summary') }}</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>{{ __('Order Number') }}</span>
                        <span class="font-semibold">{{ $order->order_number }}</span>
                        </div>
                   <div class="flex justify-between">
                <span>{{ __('Total Amount') }}</span>
               <span class="font-bold text-2xl text-accent">${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                    </div>
                </div>

          <!-- Stripe Payment Form -->
                @if($clientSecret)
                    <div id="payment-element" class="mb-6">
                        <!-- Stripe Elements will be inserted here -->
                    </div>

                    <x-button
               variant="primary"
                class="w-full"
                        id="submit-payment"
                 wire:loading.attr="disabled">
                 <span wire:loading.remove>{{ __('Pay Now') }}</span>
                   <span wire:loading>{{ __('Processing...') }}</span>
            </x-button>

                    <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-4 text-center">
                        {{ __('Secure payment powered by Stripe') }}
                </p>
                @else
         <div class="text-center py-8">
                     <x-loading>{{ __('Initializing payment...') }}</x-loading>
              </div>
          @endif
            </x-card>
        </div>

        @if($clientSecret)
            @push('scripts')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
            const stripe = Stripe('{{ config('services.stripe.key') }}');
                const options = {
               clientSecret: '{{ $clientSecret }}',
              appearance: {
                        theme: 'stripe',
          },
              };

          const elements = stripe.elements(options);
          const paymentElement = elements.create('payment');
                paymentElement.mount('#payment-element');

              document.getElementById('submit-payment').addEventListener('click', async (e) => {
                    e.preventDefault();

               const {error} = await stripe.confirmPayment({
                      elements,
                confirmParams: {
                return_url: '{{ route('account.orders') }}',
                    },
                    });

                if (error) {
                  @this.set('paymentStatus', 'failed');
                        alert(error.message);
           }
             });
            </script>
            @endpush
        @endif
    </x-layouts.storefront>
</div>
