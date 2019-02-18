<template>
    <div class="row mb-3">
        <div class="col-sm">
            <input type="text" class="form-control" placeholder="Search company" ref="searchQuery" :value="value.searchQuery" @change="filter">
        </div>
        <div class="col-sm offset-6">
            <select class="form-control" ref="numberRecord" :value="value.numberRecord" @change="filter">
                <option v-for="option in options">{{option}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                options: [
                    5,
                    10,
                    15,
                    20,
                    25
                ]
            }
        },
        props: {
            value: {
                type: Object,
                required: true
            }
        },
        methods : {
            filter() {
                this.$emit('input', {
                    numberRecord: this.$refs.numberRecord.value,
                    searchQuery: this.$refs.searchQuery.value ? this.$refs.searchQuery.value : ''
                })
                this.$emit('filter');
            }
        }
    }
</script>