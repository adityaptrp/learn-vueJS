<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3><strong>Form New Note</strong></h3>
                <hr>
                <p>This is a form to create a new Note</p>
                <div v-if="successMessage" class="alert alert-success d-flex justify-content-between">
                    <span>{{ successMessage }}</span>
                    <span @click="successMessage=''" style="cursor: pointer;"><i class="fas fa-times"></i></span>
                </div>
                <div class="card">
                    <div class="card-header">Create a Note</div>
                    <div class="card-body">
                        <form action="#" method="post" @submit.prevent="store">
                            <div class="form-group">
                                <label for="title">Title :</label>
                                <input type="text" v-model="form.title" id="title" class="form-control">
                                <div v-if="theErrors.title" class="mt-2 text-danger">{{ theErrors.title[0] }}</div>
                            </div>

                            <div class="form-group">
                                <label for="subject_id">Subject :</label>
                                <select v-model="form.subject_id" id="subject_id" class="form-control">
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                        {{ subject.name }}
                                    </option>
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
                form: {
                    title: '',
                    subject_id: '',
                    description: '',
                },
                subjects: [],
                theErrors: [],
                successMessage: '',
                loading: false,
            }
        },

        mounted() {
            this.getSubjects();
        },

        methods: {
            async getSubjects() {
                let response = await axios.get('/api/subjects');
                if (response.status === 200) {
                    this.subjects = response.data;
                }
            },

            async store() {
                this.loading = true;
                try {
                    let response = await axios.post('/api/notes/create-new-note', this.form);
                    if (response.status === 200) {
                        this.form.title = "";
                        this.form.subject_id = "";
                        this.form.description  = "";
                        this.theErrors = [];
                        this.successMessage = response.data.message;
                        this.loading = false;
                    }
                } catch (e) {
                    this.loading = false;
                    this.theErrors =  e.response.data.errors;
                }
            },
        }
    }
</script>