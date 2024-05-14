<script type="text/javascript">
    document.addEventListener('livewire:init', () => {
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
            $(select).on('change', e => {
                console.log(e)
                let data = $(select).select2("val")
                @this.set(select, data)
            })
        })
    })
</script>
