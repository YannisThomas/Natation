<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Vous pouvez modifier votre adresse email et votre numéro de téléphone.<br>
            Le prénom, nom et rôle ne sont pas modifiables.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Prénom -->
        <div>
            <x-input-label for="firstname" value="Prénom" />
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full bg-gray-100"
                :value="old('firstname', $user->firstname)" readonly />
        </div>

        <!-- Nom -->
        <div>
            <x-input-label for="lastname" value="Nom" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full bg-gray-100"
                :value="old('lastname', $user->lastname)" readonly />
        </div>

        <!-- Rôle -->
        <div>
            <x-input-label for="role" value="Rôle" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full bg-gray-100"
                :value="$user->role->name" readonly />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Votre adresse email n’est pas vérifiée.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Cliquez ici pour renvoyer le lien de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Téléphone -->
        <div>
            <x-input-label for="phone" value="Téléphone" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Modifications enregistrées.') }}</p>
            @endif
        </div>
    </form>
</section>
