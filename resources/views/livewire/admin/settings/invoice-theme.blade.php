<div>
    <h2>{{__('Select Invoice Template')}}</h2>

    {{-- Template Selection --}}
    <div class="mb-4">
        <label for="template">Select Template:</label>
        <select wire:model="selectedTemplate" id="template" class="form-control">
            <option value="">Select a template</option>
            @foreach ($templates as $key => $template)
                <option value="{{ $key }}">{{ $template['name'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Template Preview --}}
    @if ($selectedTemplate)
        <h3>Template Preview</h3>
        @include('admin.sale.print')
    @endif
  
</div>
