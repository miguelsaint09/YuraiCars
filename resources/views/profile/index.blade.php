<x-layouts.app title="Profile">
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('profile-completed', ({ redirectUrl }) => {
                window.location.href = redirectUrl;
            });
        });
    </script>
    <livewire:profile-page />
</x-layouts.app>