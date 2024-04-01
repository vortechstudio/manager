<div class="mb-10" wire:ignore.self>
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    @if($selectType == 'select2')
        <select id="{{ $name }}" data-pharaonic="select2" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" data-component-id="{{ $name }}" class="form-select" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $k => $option)
                <option value="{{ $k }}" {{ $value == $option ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
    @elseif($selectType == 'selectpicker')
        <select id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" class="form-select selectpicker" data-live-search="true" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option['value'] }}" {{ $value == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
            @endforeach
        </select>
    @else
        <select id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" class="form-select">
            <option>{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}</option>
            @foreach($options as $option)
                <option value="{{ $option['value'] }}" {{ $value == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
            @endforeach
        </select>
    @endif
    @error("$name")
        <span class="text-danger error">{{ $message }}</span>
    @enderror
    <span class="text-muted">{{ $hint }}</span>
</div>

@if($selectType == 'selectpicker')
    @push("scripts")
        <script type="text/javascript">
            $("{{ $name }}").selectpicker()
        </script>
    @endpush
@endif

@if($selectType == 'select2')
    @push("scripts")
        <script type="text/javascript">
            $("#{{ $name }}").on('change', e => {
                let data = $("#{{ $name }}").select2("val")
                @this.set('{{ $name }}', data)
            })
        </script>
    @endpush
@endif
