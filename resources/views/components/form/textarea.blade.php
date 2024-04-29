@if($type == 'simple')
    <div class="mb-10">
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <textarea
            class="form-control {{ $class }} @error("$name") is-invalid @enderror"
            wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
            value="{{ $value }}">{{ $value }}</textarea>
            @error("$name")
            <span class="text-danger error">{{ $message }}</span>
            @enderror

    </div>
@endif

@if($type == 'quill')
    @push("styles")
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endpush
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <div id="{{ $name }}"></div>
            @error("$name")
            <span class="text-danger error">{{ $message }}</span>
            @enderror
    </div>
    @push("scripts")
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script type="text/javascript">
            const quill = new Quill('#{{ $name }}', {
                theme: 'snow'
            });
            quill.on('text-change', function () {
                let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
                @this.set('value', value)
            })
        </script>
    @endpush
@endif

@if($type == 'ckeditor')
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model="{{ $isModel ? $model.'.'.$name : $name }}"
                id="ckeditor"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}">{{ $value }}</textarea>
            @error("$name")
            <span class="text-danger error">{{ $message }}</span>
            @enderror
    </div>
    @push('scripts')
        <script src="{{ asset('/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
        <script type="text/javascript">
            ClassicEditor
                .create(document.querySelector('#ckeditor'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('{{ $name }}', editor.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
@endif

@if($type == 'tinymce')
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <div wire:ignore>
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}">{{ $value }}</textarea>
            @error("$name")
            <span class="text-danger error">{{ $message }}</span>
            @enderror
        </div>

    </div>

    @push("scripts")
        <script src="{{ asset('/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
        <script type="text/javascript">
            let options = {
                selector: "#{{ $name }}",
                height: "480",
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor advlist lists wordcount textpattern noneditable help charmap quickbars',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap | fullscreen preview save print | insertfile image media template link anchor codesample',
                language: 'fr_FR',
                setup: function (editor) {
                    editor.on('init change', function () {
                        editor.save();
                    });
                }
            }

            if ( KTThemeMode.getMode() === "dark" ) {
                options["skin"] = "oxide-dark";
                options["content_css"] = "dark";
            }
            tinymce.init(options);
        </script>
    @endpush
@endif

@if($type == 'trix')
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
    </div>
@endif

@if($type == 'laraberg')
    @push("styles")
        <link rel="stylesheet" href="{{asset('/vendor/laraberg/css/laraberg.css')}}">
    @endpush
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
            <div wire:ignore>
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}">{{ $value }}</textarea>
                @error("$name")
                <span class="text-danger error">{{ $message }}</span>
                @enderror
            </div>
    </div>
    @push("scripts")
        <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
        <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
        <script src="{{ asset('/vendor/laraberg/js/laraberg.js') }}"></script>
        <script type="text/javascript">
            Laraberg.init('{{ $name }}')

        </script>
    @endpush
@endif
