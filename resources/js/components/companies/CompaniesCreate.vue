<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create new company</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company name</label>
                            <input v-validate="{ required: true }" type="text" v-model="company.name" name="name" class="form-control">
                            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company address</label>
                            <input v-validate="{ required: true, min: 6 }" type="text" v-model="company.address" name="address" class="form-control">
                            <span v-show="errors.has('address')" class="text-danger">{{ errors.first('address') }}</span>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company website</label>
                            <input type="text" v-model="company.website" class="form-control">
                        </div>
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company email</label>
                            <input v-validate="{ required: true, email: true }" type="text" v-model="company.email" name="email" class="form-control">
                            <span v-show="errors.has('email')" class="text-danger">{{ errors.first('email') }}</span>
                        </div>
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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