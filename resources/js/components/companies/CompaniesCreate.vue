<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create new company</div>
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
        data: function () {
            return {
                company: {
                    name: null,
                    address: null,
                    website: null,
                    email: null,
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
                        axios.post('/api/v1/companies', newCompany)
                            .then(function (resp) {
                                app.$router.push({path: '/'});
                            })
                            .catch(function (resp) {
                                console.log(resp);
                                this.submitted = false;
                                alert("Could not create your company");
                            });
                    }
                })
            }
        }
    }
</script>