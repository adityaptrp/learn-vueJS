
<template>
    <button ref="deleteNote" @click.prevent="destroyNote" class="btn btn-danger">Delete</button>
</template>

<script>
export default {
    props: ['endpoint'],
    methods: {
        async destroyNote() {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(async (willDelete) => {
                if (willDelete) {
                    let response = await axios.delete(`/api/notes/${this.endpoint}/delete`);
                    if (response.status == 200) {
                        $(this.$refs.deleteNote).parent().parent().remove();
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                            buttons: false,
                            timer: 1500
                        });
                    }
                }
            });
        }
    }
}
</script>

<style>

</style>