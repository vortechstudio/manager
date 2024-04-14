<div>
    <form wire:submit="submit">
        <livewire:dropzone
            wire:model="images"
            :rules="['image','mimes:png,jpeg','max:10420']"
            :multiple="$multiple" />
    </form>
</div>
