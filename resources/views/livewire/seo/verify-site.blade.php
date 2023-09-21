<x-modal wire:model="verifySiteModal">
    <x-slot name="title">{{ __('Website Verification') }}</x-slot>
    <x-slot name="content">
        <!-- Display the verification token -->
        <p>Verification Token: {{ $verificationToken }}</p>

        <!-- Button to generate a verification token -->
        <button wire:click.once="generateVerificationToken">Generate Verification Token</button>

        @if ($verificationStatus === '')
            <!-- No verification status, show initial message or loading indicator -->
            <p>You're just a few simple clicks away from verifying this website!</p>
            <button wire:click.throttle="verifyWebsite">Verify Website</button>
       
            @elseif (strpos($verificationStatus, 'Verification successful') !== false)
            <!-- Verification is successful, show success message -->
            <h4>Verification Successful</h4>
            <p>Congratulations! Your website is now verified!</p>
            <p>You can now use verified Google services like <a href="http://www.google.com/webmasters/">Webmaster
                    Tools</a>.</p>
            <!-- Add other success-related information here -->
        @else
            <!-- Verification failed, show error message -->
            <h4>Oops, something went wrong during verification.</h4>
            <p class="error">Error details:<br /><tt>{!! htmlspecialchars($verificationStatus) !!}</tt></p>
            <button wire:click="verifyWebsite">Try Again</button>
        @endif
        <!-- Display the list of web resources -->
        <h3>Web Resources</h3>
        <ul>
            @foreach ($webResources as $webResource)
                <li>
                    <strong>ID:</strong> {{ $webResource->id }}<br>
                    <strong>Owners:</strong>
                    <ul>
                        @foreach ($webResource->owners as $owner)
                            <li>{{ $owner }}</li>
                        @endforeach
                    </ul>
                    <strong>Site URL:</strong> {{ $webResource->site->identifier }}<br>
                    <strong>Site Type:</strong> {{ $webResource->site->type }}
                </li>
            @endforeach
        </ul>
    </x-slot>
</x-modal>
