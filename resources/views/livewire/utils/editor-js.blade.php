<div>
    <div wire:ignore x-data="editorInstance('data', '{{ $editorId }}', {{ $readOnly ? 'true' : 'false' }}, '{{ $placeholder }}', '{{ $logLevel }}')" x-init="initEditor()" class="{{ $class }}"
        style="{{ $style }}">
        <div id="{{ $editorId }}"></div>
    </div>
</div>
