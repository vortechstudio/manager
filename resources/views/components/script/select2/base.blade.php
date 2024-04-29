<script type="text/javascript">
    document.addEventListener('livewire:init', () => {
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })
    })
</script>
