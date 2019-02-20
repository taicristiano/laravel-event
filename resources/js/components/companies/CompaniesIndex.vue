<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Create new company</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <companies-filter
                    v-model="filter"
                    @filter="getCompanies()"
                    :value="filter">
                </companies-filter>
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
    import CompaniesFilter from './CompaniesFilter.vue';

    export default {
        components: {
            CompaniesPagination,
            CompaniesFilter
        },
        data: function () {
            var columns = ['name', 'address', 'website', 'email']
            return {
                sortKey: localStorage.getItem("sorkKey") ? localStorage.getItem("sorkKey") : 'name',
                sortValue: localStorage.getItem("sortValue") ? localStorage.getItem("sortValue") : 'asc',
                companies: {
                    current_page: localStorage.getItem("current_page") ? localStorage.getItem("current_page") : 1
                },
                offset: 2,
                columns: columns,
                filter: {
                    numberRecord: localStorage.getItem("numberRecord") ? localStorage.getItem("numberRecord") : 10,
                    searchQuery: localStorage.getItem("searchQuery") ? localStorage.getItem("searchQuery") : '',
                }
            }
        },
        mounted() {
            this.getCompanies()
        },
        computed: {
            filteredData: function () {
                return this.companies.data;
            }
        },
        filters: {
            capitalizeFirstLetter: function(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
        },
        methods: {
            getCompanies() {
                var app = this;
                var url = '/api/v1/companies?page=' + this.companies.current_page + '&field=' + this.sortKey + '&order=' + this.sortValue + '&search=' + this.filter.searchQuery + '&limit=' + this.filter.numberRecord;

                localStorage.removeItem("sorkKey");
                localStorage.removeItem("sortValue");
                localStorage.removeItem("numberRecord");
                localStorage.removeItem("searchQuery");
                localStorage.removeItem("current_page");

                localStorage.setItem("sorkKey", this.sortKey ? this.sortKey : '');
                localStorage.setItem("sortValue", this.sortValue ? this.sortValue : '');
                localStorage.setItem("numberRecord", this.filter.numberRecord ? this.filter.numberRecord : 10);
                localStorage.setItem("searchQuery", this.filter.searchQuery ? this.filter.searchQuery : '');
                localStorage.setItem("current_page", this.companies.current_page);

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