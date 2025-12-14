<x-layout>
    @guest
        <x-unauth></x-unauth>
    @endguest

    @auth
        <div class="container1 w-full">
            <x-response.success></x-response.success>
            <x-response.error :errors="$errors"></x-response.error>

            <h1 class="title mb-5 text-center">Account Information</h1>

            <p class="m-2"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="m-2"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="m-2"><strong>Created in:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

            <div class="mt-5 text-center">
                <a href="{{ route('dashboard') }}" class="inline-block btn-blue">
                    Back to Dashboard
                </a>
            </div>

            @if($user->id === Auth::user()->id)
                <flux:separator class="m-5" />

                <div class="text-center flex flex-row justify-center-safe gap-2">
                    <flux:modal.trigger name="change_password">
                        <a href="#" class="inline-block btn-red">
                            Change password
                        </a>
                    </flux:modal.trigger>

                    <flux:modal.trigger name="delete_account">
                        <a href="#" class="inline-block btn-red">
                            Delete account
                        </a>
                    </flux:modal.trigger>
                </div>
            @endif
        </div>

        <flux:modal :dismissible="false" name="delete_account" class="min-w-88 text-center">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete account?</flux:heading>
                    <flux:text class="mt-2">
                        You're about to delete your account and all your projects.<br>
                        This action cannot be reversed.
                    </flux:text>
                </div>
                <div class="flex gap-2 items-center justify-center">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <form action="{{ route('account.delete', Auth::user()) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <flux:button variant="danger" type="submit">Confirm</flux:button>
                    </form>
                </div>
            </div>
        </flux:modal>

        <flux:modal :dismissible="false" name="change_password">
            <div class="max-w-md mx-auto space-y-6">
                <flux:heading size="lg" class="text-center">
                    Change password
                </flux:heading>

                <form action="{{ route('account.updatePassword', Auth::user()) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <flux:input type="hidden" name="email" value="{{ Auth::user()->email }}" />
                    <flux:input label="Current password" name="current_password" type="password" required />
                    <flux:input label="New password" name="password" type="password" required />
                    <flux:input label="Confirm password" name="password_confirmation" type="password" required />

                    <div class="flex justify-end pt-4">
                        <button class="btn-blue">
                            Update password
                        </button>
                    </div>
                </form>
            </div>
        </flux:modal>

    @endauth
</x-layout>