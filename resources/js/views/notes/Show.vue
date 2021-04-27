<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2><strong>{{ note.title }}</strong></h2>
                        <h6>{{ note.subject }}</h6>
                        <hr>
                        <p>{{ note.description }}</p>
                        <p>{{ note.published }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            note: [],
        }
    },

    mounted() {
        this.getNote();
    },

    methods: {
        async getNote() {
            let response = await axios.get('/api/notes/' + this.$route.params.noteSlug);
            this.note = response.data.data;
        }
    }
}
</script>