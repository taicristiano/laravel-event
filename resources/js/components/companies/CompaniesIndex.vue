<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Create new company</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" v-model="searchQuery">
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th v-for="column, index in sortOrders"
                            @click="sortBy(index)"
                            :class="{ active: sortKey == index || sortKey == '' && index == 'name'} ">
                            {{ index | capitalize }}
                            <span v-if="sortKey == index || sortKey == '' && index == 'name'">
                                <span v-if="sortOrders[index] > 0">
                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                </span>
                                <span v-else>
                                    <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                                </span>
                            </span>
                        </th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="company, index in filteredData">
                        <td>{{ company.name }}</td>
                        <td>{{ company.address }}</td>
                        <td>{{ company.website }}</td>
                        <td>{{ company.email }}</td>
                        <td class="text-center">
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="text-info">
                                <i class="fa fa-edit fa-lg"></i>
                            </router-link>
                            <a href="#"
                               class="text-danger"
                               v-on:click="deleteEntry(company.id, index)">
                                <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <companies-pagination
                    :pagination="companies"
                    @paginate="getCompanies()"
                    :offset="offset">
                </companies-pagination>
                <!-- @paginate="getCompanies()" -->
                <!-- v-on:paginate=getCompanies() -->
            </div>
        </div>
    </div>
</template>

<script>
    import CompaniesPagination from './CompaniesPagination.vue';

    export default {
        data: function () {
            var columns = ['name', 'address', 'website', 'email']
            var sortOrders = {}
            columns.forEach(function (key) {
                sortOrders[key] = 1
            })
            return {
                sortKey: '',
                sortOrders: sortOrders,
                searchQuery: '',
                companies: {
                    current_page: 1
                },
                offset: 2
            }
        },
        mounted() {
            this.getCompanies()
        },
        components: {
            CompaniesPagination
        },
        computed: {
            filteredData: function () {
                var sortKey = this.sortKey;
                var filterKey = this.searchQuery && this.searchQuery.toLowerCase();
                var order = this.sortOrders[sortKey] || 1
                var data = this.companies.data
                if (filterKey) {
                    data = data.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                        })
                    })
                }
                if (sortKey) {
                    data = data.slice().sort(function (a, b) {
                        a = a[sortKey]
                        b = b[sortKey]
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return data
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            getCompanies() {
                var app = this;
                var url = '/api/v1/companies?page=' + this.companies.current_page
                axios.get(url)
                    .then(function (resp) {
                        app.companies = resp.data;
                    })
                    .catch(function (resp) {
                        alert("Could not load companies");
                    });
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/companies/' + id)
                        .then(function (resp) {
                            app.companies.data.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                        });
                }
            },
            sortBy: function (key) {
                this.sortKey = key
                this.sortOrders[key] = this.sortOrders[key] * -1
            }
        }
    }
</script>