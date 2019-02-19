<template>
    <form v-on:submit="save">
        <div class="col-xs-12 form-group">
            <label class="control-label">Company name</label>
            <input v-validate="{ required: true }" type="text" name="name" class="form-control" v-model="company.name">
            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
        </div>
        <div class="col-xs-12 form-group">
            <label class="control-label">Company address</label>
            <input v-validate="{ required: true, min: 6 }" type="text" name="address" class="form-control" v-model="company.address">
            <span v-show="errors.has('address')" class="text-danger">{{ errors.first('address') }}</span>
        </div>
        <div class="col-xs-12 form-group">
            <label class="control-label">Company website</label>
            <input type="text" class="form-control" v-model="company.website">
        </div>
        <div class="col-xs-12 form-group">
            <label class="control-label">Company email</label>
            <input v-validate="{ required: true, email: true }" type="text" name="email" class="form-control" v-model="company.email">
            <span v-show="errors.has('email')" class="text-danger">{{ errors.first('email') }}</span>
        </div>
        <div class="col-xs-12 form-group">
            <button class="btn btn-success">Create</button>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            company: this.company,
            validator: this.validator
        },
        methods: {
            save() {
                this.$emit('save')
            }
        },
        created() {
            if (this.validator) {
                console.log(this.$validator ,this.validator);
                this.$validator = this.validator
            }
        },
    }
</script>