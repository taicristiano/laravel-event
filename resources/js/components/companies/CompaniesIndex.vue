<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Create new company</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-sm">
                        <input type="text" class="form-control" placeholder="Search" v-model="searchQuery" @change="getCompanies">
                    </div>
                    <div class="col-sm offset-6">
                        <select class="form-control" v-model="numberRecord" @change="getCompanies">
                          <option>5</option>
                          <option>10</option>
                          <option>15</option>
                          <option>20</option>
                          <option>25</option>
                        </select>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th v-for="column, index in columns"
                            @click="generateFunctionSort(column, sortKey, sortValue)"
                            :class="{ active: sortKey == column } ">
                            {{ column | capitalizeFirstLetter }}
                            <span v-if="sortKey == column">
                                <span v-if="sortValue == 'asc'">
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
                sortKey: 'name',
                sortValue: 'asc',
                searchQuery: '',
                companies: {
                    current_page: 1
                },
                offset: 2,
                columns: columns,
                numberRecord: 10
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
                return this.companies.data;
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            },
            capitalizeFirstLetter: function(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
        },
        methods: {
            getCompanies() {
                var app = this;
                var url = '/api/v1/companies?page=' + this.companies.current_page + '&field=' + this.sortKey + '&order=' + this.sortValue + '&search=' + this.searchQuery + '&limit=' + this.numberRecord;
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
            sortBy: function (column, order) {
                this.sortKey = column
                this.sortValue = order
                this.getCompanies();
            },
            generateFunctionSort(column, sortKey, sortValue) {
                if (sortKey == column) {
                    if (sortValue == 'asc') {
                        sortValue = 'desc'
                    } else {
                        sortValue = 'asc'
                    }
                    this.sortBy(column, sortValue)
                } else {
                    this.sortBy(column, 'asc')
                }
            }
        }
    }
</script>