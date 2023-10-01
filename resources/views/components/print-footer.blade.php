@php
    $footerStyle = config("invoice.templates.$style.footer.style");
@endphp

<div class="row">
    <div class="col">
        <table>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
