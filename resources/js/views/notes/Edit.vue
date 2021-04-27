<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3><strong>Edit Note</strong></h3>
                <hr>
                <p>This is a form to edit the selected Note</p>
                <div class="card">
                    <div class="card-header">Edit Note</div>
                    <div class="card-body">
                        <form action="#" method="post" @submit.prevent="update">
                            <div class="form-group">
                                <label for="title">Title :</label>
                                <input type="text" v-model="form.title" id="title" class="form-control">
                                <div v-if="theErrors.title" class="mt-2 text-danger">{{ theErrors.title[0] }}</div>
                            </div>

                            <div class="form-group">
                                <label for="subject_id">Subject :</label>
                                <select @change="selectedSubject" id="subject_id" class="form-control">
                                    <option :value="form.subject_id" v-text="form.subject"></option>
                                    <template v-for="subject in subjects">
                                        <option v-if="form.subject_id !== subject.id" :key="subject.id" :value="subject.id">
                                            {{ subject.name }}
                                        </option>
                                    </template>
                                </select>
                                <div v-if="theErrors.subject_id" class="mt-2 text-danger">{{ theErrors.subject_id[0] }}</div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea v-model="form.description" id="description" rows="5" class="form-control"></textarea>
                                <div v-if="theErrors.description" class="mt-2 text-danger">{{ theErrors.description[0] }}</div>
                            </div>

                            <button type="submit" class="btn btn-success d-flex align-items-center">
                                Save
                                <template v-if="loading">
                                    <svg style="margin: auto; background: none; display: block; shape-rendering: auto;" width="25px" height="25px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"> <rect x="17.5" y="30" width="15" height="40" fill="#ffffff"> <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="18;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate> <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="64;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate> </rect> <rect x="42.5" y="30" width="15" height="40" fill="#f8fff5"> <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="20.999999999999996;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate> <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="58.00000000000001;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate> </rect> <rect x="67.5" y="30" width="15" height="40" fill="#ecffe7"> <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="20.999999999999996;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate> <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="58.00000000000001;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate> </rect> </svg>
                                </template>
                            </button>
                        </form>
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
                form: [],
                subjects: [],
                theErrors: [],
                selected: '',
                loading: false,
            }
        },

        mounted() {
            this.getSubjects();
            this.getNote();
        },

        methods: {
            async getSubjects() {
                let response = await axios.get('/api/subjects');
                if (response.status === 200) {
                    this.subjects = response.data;
                }
            },

            async getNote() {
                let response = await axios.get(`/api/notes/${this.$route.params.noteSlug}`);
                this.form = response.data.data;
            },

            async selectedSubject(e) {
                this.selected = e.target.value;
            },

            async update() {
                this.loading = true;
                try {
                    this.form['subject_id'] = this.selected || this.form.subject_id;
                    let response = await axios.patch(`/api/notes/${this.$route.params.noteSlug}/edit`, this.form);
                    if (response.status == 200) {
                        this.loading = false;
                        this.$router.push({ name: 'notes.table', params: { successEdit: true } });
                    }
                } catch (e) {
                    this.loading = false;
                    this.theErrors =  e.response.data.errors;
                }
            }
        }
    }
</script>