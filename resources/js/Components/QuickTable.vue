<template>
    <div>
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">{{
                        title
                    }}</span>
                    <!--Comment Status-->

                    <!--User Status-->
                    <span
                        class="text-muted mt-1 fw-bold fs-7"
                        v-if="filter.role"
                    >
                        <span
                            class="cursor-pointer"
                            :class="{ 'text-primary': role_id === '' }"
                            @click="setRole('')"
                        >
                            {{ __("all") }}
                        </span>
                        |
                        <span
                            class="cursor-pointer"
                            :class="{ 'text-primary': role_id === 2 }"
                            @click="setRole(2)"
                        >
                            {{ __("table.manager") }}
                        </span>
                        |
                        <span
                            class="cursor-pointer"
                            :class="{ 'text-primary': role_id === 3 }"
                            @click="setRole(3)"
                        >
                            {{ __("table.author") }}
                        </span>
                    </span>

                    <div class="row">
                        <div class="col-md-6 my-2 mb-3" v-if="filter.branch">
                            <div class="d-flex align-items-center"></div>
                        </div>
                    </div>

                    <slot name="description"></slot>
                </h3>
                <div class="card-toolbar">
                    <slot name="toolbar"></slot>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <div class="d-flex bd-highlight mb-3">
                    <div class="me-auto w-300px" v-if="filter.search">
                        <div class="input-group input-group-solid mb-5">
                            <input
                                type="text"
                                class="form-control"
                                :placeholder="__('table.search_word')"
                                v-model="query"
                                v-on:keyup.enter="setQuery"
                                :data="{ limit, status, query }"
                            />
                            <span class="btn btn-light" @click="setQuery">{{
                                __("table.search_button")
                            }}</span>
                        </div>
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="me-auto w-450px" v-if="filter.between">
                            <VDatePicker v-model="startDate">
                                <template #default="{ togglePopover }">
                                    <span
                                        @click="togglePopover"
                                        class="cursor-pointer"
                                    >
                                        <a
                                            href="#"
                                            class="btn btn-outline btn-outline-dashed me-2 mb-2"
                                            v-if="!startDate"
                                            >Başlangıç Tarihi</a
                                        >
                                        <a
                                            href="#"
                                            class="btn btn-outline btn-outline-dashed me-2 mb-2"
                                            v-if="startDate"
                                            >Başlangıç :
                                            {{ startDateFormatted }}</a
                                        >
                                    </span>
                                </template>
                            </VDatePicker>
                            <VDatePicker v-model="endDate">
                                <template #default="{ togglePopover }">
                                    <span
                                        @click="togglePopover"
                                        class="cursor-pointer"
                                    >
                                        <a
                                            href="#"
                                            class="btn btn-outline btn-outline-dashed me-2 mb-2"
                                            v-if="!endDate"
                                            >Bitiş Tarihi</a
                                        >
                                        <a
                                            href="#"
                                            class="btn btn-outline btn-outline-dashed me-2 mb-2"
                                            v-if="endDate"
                                            >Bitiş : {{ endDateFormatted }}</a
                                        >
                                    </span>
                                </template>
                            </VDatePicker>
                        </div>
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="me-auto w-400px" v-if="filter.branch">
                            <v-select
                                :options="$page.props.branches"

                                v-model="branch"
                                label="name"
                                :reduce="(branch) => branch.id"
                                placeholder="Şube Seçimi"
                                class="form-control form-control-solid compress-p"
                            >
                                <template slot="no-options">
                                    Şube adını yazarak arama yapabilirsiniz.
                                </template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="text-dark-75 font-weight-bolder font-size-lg mb-0"
                                        >
                                            {{ option }}
                                        </div>
                                    </div>
                                </template>
                            </v-select>
                        </div>
                    </div>
                </div>

                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                    >
                        <!--begin::Table head-->
                        <thead>
                            <slot name="header"></slot>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <slot name="rows"></slot>
                        </tbody>
                    </table>
                    <table v-if="!data.data.length">
                        <tr>
                            <td>{{ __("table.no_match_record") }}</td>
                        </tr>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
                <!--begin::Pagination-->
                <div
                    class="d-flex justify-content-between align-items-center flex-wrap mt-3"
                >
                    <div class="d-flex flex-wrap py-2 mr-3">
                        <Link
                            preserve-scroll
                            preserve-state
                            :only="[dataName]"
                            :href="link.url === null ? dataName : link.url"
                            :data="{ ...params }"
                            v-for="(link, index) in data.links"
                            :key="index"
                            type="button"
                            :class="{
                                'btn-hover-primary active': link.active,
                                'w-100px':
                                    index === 0 ||
                                    data.links.length === index + 1,
                            }"
                            class="btn btn-icon btn-sm btn-light me-2 my-1"
                            v-html="link.label"
                        >
                        </Link>
                    </div>
                    <div class="d-flex align-items-center py-3">
                        <select
                            v-model="limit"
                            @change="setLimit"
                            class="form-select form-select-sm form-select-solid font-weight-bold me-4 border-0"
                            style="width: 75px"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="text-muted">{{
                            __("table.results", {
                                total: data.total,
                                from: data.from ? data.from : 0,
                                to: data.to ? data.to : 0,
                            })
                        }}</span>
                    </div>
                </div>
            </div>
            <!--begin::Body-->
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import vSelect from "vue-select";

export default {
    name: "QuickTable",
    components: { Link, vSelect },
    props: {
        dataName: String,
        data: Object,
        default_limit: Number,
        title: String,
        filter: {
            type: Object,
            // Object or array defaults must be returned from
            // a factory function
            default: function () {
                return {
                    search: false,
                    role: false,
                    comment_status: false,
                    post_status: false,
                    between: false,
                };
            },
        },
    },
    data() {
        return {
            query: "",
            limit: this.default_limit ?? "50",
            status: null,
            role_id: "",
            branch: null,
            startDate: null,
            endDate: null,
            params: {},
        };
    },
    created() {},
    computed: {
        startDateFormatted() {
            if(this.endDate){
                this.setBetween();
            }
            return moment(this.startDate).lang("tr").format("DD MMMM YYYY");
        },
        endDateFormatted() {
            if(this.startDate){
                this.setBetween();
            }
            return moment(this.endDate).lang("tr").format("DD MMMM YYYY");
        },
    },
    watch: {
        branch: function (val) {
            this.setBranch();
        },
    },
    methods: {
        async start() {
            let queryString = this.searchToObject();

            if (queryString.role) {
                this.params.role = queryString.role;
                this.role_id = parseInt(queryString.role);
            }

            if (queryString.search) {
                this.params.query = queryString.search;
                this.query = queryString.search;
            }

            if (queryString.branch) {
                this.params.branch = queryString.branch;
                this.branch = queryString.branch;
            }

            if (queryString.date) {
                this.params.date = queryString.date;
                this.startDate = queryString.date;
                this.endDate = queryString.date;
            }

            if (queryString.month) {
                const date = new Date(queryString.month); // queryString.date'i bir tarih nesnesine çevir
                if (!isNaN(date.getTime())) {
                    // Geçerli bir tarih mi kontrol et
                    this.startDate = new Date(
                        date.getFullYear(),
                        date.getMonth(),
                        1
                    ); // Ayın ilk gününü belirle
                    this.endDate = new Date(
                        date.getFullYear(),
                        date.getMonth() + 1,
                        0
                    ); // Ayın son gününü belirle

                    this.params.startDate = this.startDate; // this.params.date'i queryString.date ile güncelle
                    this.params.endDate = this.endDate; // this.params.date'i queryString.date ile güncelle
                }
            }

            if (queryString.year) {
                const date = new Date(queryString.year); // queryString.date'i bir tarih nesnesine çevir
                if (!isNaN(date.getTime())) {
                    // Geçerli bir tarih mi kontrol et
                    this.params.date = date; // this.params.date'i queryString.date ile güncelle
                    this.startDate = new Date(date.getFullYear(), 0, 1); // Yılın ilk gününü belirle
                    this.endDate = new Date(date.getFullYear(), 11, 31); // Yılın son gününü belirle
                }
            }
        },
        setBetween(){
            this.params.startDate = this.startDate;
            this.params.endDate = this.endDate;
            this.setVisit();
        },
        setQuery() {
            this.params.search = this.query;
            this.setVisit();
        },
        setBranch() {
            this.params.branch = this.branch;
            this.setVisit();
        },
        setRole(role) {
            this.role_id = role;
            this.params.role = this.role_id;
            this.setVisit();
        },
        setLimit() {
            this.params.limit = this.limit;
            this.setVisit();
        },
        setVisit() {
            this.$inertia.visit(
                this.dataName,
                {
                    data: this.params,
                    replace: false,
                    preserveState: true,
                    preserveScroll: true,
                },
                { replace: true }
            );
        },
        searchToObject() {
            let pairs = window.location.search.substring(1).split("&"),
                obj = {},
                pair,
                i;

            for (i in pairs) {
                if (pairs[i] === "") continue;

                pair = pairs[i].split("=");
                obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
            }

            return obj;
        },
    },
    mounted() {
        this.start();
    },
};
</script>
<style scoped>
.compress-p{
    padding:0.54rem 1rem 0.54rem 1rem!important;
}
</style>
