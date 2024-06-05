<a href="/">
    <img id="themeLogo" src="{{ asset('logo/mouse_light.png') }}" alt="Logo" {{ $attributes }} />
</a>

<script>
    // Function to change the logo based on system theme
    function changeLogo() {
        const prefersDarkTheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const logoImage = document.getElementById('themeLogo');

        if (prefersDarkTheme) {
            logoImage.src = "{{ asset('logo/mouse_dark.png') }}";
        } else {
            logoImage.src = "{{ asset('logo/mouse_light.png') }}";
        }
    }

    changeLogo();

    // Listen for changes in the system theme
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        changeLogo();
    });
</script>
