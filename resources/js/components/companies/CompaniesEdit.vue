<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit company</div>
            <div class="panel-body">
                <companies-form
                    @save="saveForm()"
                    v-bind:company="company"
                    :validator="$validator">
                </companies-form>
            </div>
        </div>
    </div>
</template>

<script>
    import CompaniesForm from './CompaniesForm.vue';

    export default {
        components: {
            CompaniesForm
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.companyId = id;
            axios.get('/api/v1/companies/' + id)
                .then(function (resp) {
                    app.company = resp.data;
                })
                .catch(function () {
                    alert("Could not load your company")
                });
        },
        data: function () {
            return {
                companyId: null,
                company: {
                    name: '',
                    address: '',
                    website: '',
                    email: '',
                },
                submitted: false
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                this.submitted = true;
                this.$validator.validate().then(valid => {
                    if (valid) {
                        var app = this;
                        var newCompany = app.company;
                        axios.patch('/api/v1/companies/' + app.companyId, newCompany)
                            .then(function (resp) {
                                app.$router.replace('/');
                            })
                            .catch(function (resp) {
                                this.submitted = false;
                                console.log(resp);
                                alert("Could not update your company");
                            });
                    }
                })
            }
        }
    }
</script>