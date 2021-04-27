
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h4><strong>Table Of Notes</strong></h4>
                <hr>
                <p>This is the table of all notes from database</p>
                <div class="card overflow-auto">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Published</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(note, index) in notes" :key="note.id">
                                    <th>{{ index + 1 }}</th>
                                    <td><router-link :to="{ name: 'notes.show', params: { noteSlug: note.slug } }">{{ note.title }}</router-link></td>
                                    <td>{{ note.subject }}</td>
                                    <td>{{ note.description }}</td>
                                    <td>{{ note.published }}</td>
                                    <td style="min-width:170px;">
                                        <router-link :to="{ name: 'notes.edit', params: { noteSlug: note.slug } }">
                                            <div class="btn btn-primary">Edit</div>
                                        </router-link>
                                        <DeleteNote :endpoint="note.slug"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DeleteNote from './Delete';
export default {
    components: {
        DeleteNote,
    },

    data() {
        return {
            notes: [],
        }
    },

    mounted() {
        this.checkSuccesAlert();
        this.getNotes();
    },

    methods: {
        async getNotes() {
            let { data } = await axios.get('/api/notes');
            this.notes = data.data;
        },

        async checkSuccesAlert() {
            if (this.$route.params.successEdit) {
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                    buttons: false,
                    timer: 1500
                });
            }
        },
    }
}
</script>

<style>
    thead tr th {
        border-top: 0px !important;
    }
</style>