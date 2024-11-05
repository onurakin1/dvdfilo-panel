<template>
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1"></span>
            </h3>
            <div class="card-toolbar">
                <div class="d-flex bd-highlight mb-3">
                <div class="me-auto w-300px"></div>
                <div class="p-2 bd-highlight">
                    <div class="me-auto w-400px">
                        <v-select
                            :options="$page.props.branches"
                            v-model="branch"
                            label="name"
                            :reduce="(branch) => branch.id"
                            placeholder="Şube Seçimi"
                            class="form-control"
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
                <div class="p-2 bd-highlight"></div>
            </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 pb-10">
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div
                        class="card card-xl-stretch mb-xl-8 card-rounded border border-warning shadow"
                    >
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <!--begin::Header-->
                            <div class="px-9 pt-2 h-170px w-100">
                                <div class="calendar text-warning">
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="decreaseDate"
                                    >
                                        &#9664;
                                    </div>
                                    <div class="day text-gray-700">
                                        <VDatePicker v-model="currentDate">
                                            <template
                                                #default="{ togglePopover }"
                                            >
                                                <span
                                                    @click="togglePopover"
                                                    class="cursor-pointer"
                                                >
                                                    <i
                                                        class="la la-calendar text-warning fs-2x"
                                                    >
                                                    </i>
                                                    {{ formattedDate }}
                                                </span>
                                            </template>
                                        </VDatePicker>
                                    </div>
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="increaseDate"
                                    >
                                        &#9654;
                                    </div>
                                </div>
                                <Link
                                    :href="
                                        route('backend.logs.history-list', {
                                            date: currentDate,
                                            branch:branch
                                        })
                                    "
                                >
                                    <!--begin::Heading-->
                                    <div
                                        class="d-flex flex-stack justify-content-center"
                                    >
                                        <h1
                                            class="m-0 text-warning fw-bold fs-1"
                                        >
                                            Toplam Kayıt Sayısı
                                        </h1>
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Balance-->
                                    <div
                                        class="d-flex text-center flex-column text-white"
                                    >
                                        <span
                                            class="fw-bold text-gray-700 fs-4x pt-1"
                                            >{{ daily }}</span
                                        >
                                    </div>
                                    <!--end::Balance-->
                                </Link>
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div
                        class="card card-xl-stretch mb-xl-8 card-rounded border border-warning"
                    >
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <!--begin::Header-->
                            <div class="px-9 pt-2 h-170px w-100">
                                <div class="calendar text-warning">
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="prevMonth"
                                    >
                                        &#9664;
                                    </div>
                                    <div class="month text-gray-700">
                                        <VDatePicker v-model="currentMonth">
                                            <template
                                                #default="{ togglePopover }"
                                            >
                                                <span
                                                    @click="togglePopover"
                                                    class="cursor-pointer"
                                                >
                                                    <i
                                                        class="la la-calendar text-warning fs-2x"
                                                    >
                                                    </i>
                                                    {{ formattedMonth }}
                                                </span>
                                            </template>
                                        </VDatePicker>
                                    </div>
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="nextMonth"
                                    >
                                        &#9654;
                                    </div>
                                </div>
                                <!--begin::Heading-->
                                <Link
                                    :href="
                                        route('backend.logs.history-list', {
                                            month: currentMonth,
                                            branch:branch
                                        })
                                    "
                                >
                                    <div
                                        class="d-flex flex-stack justify-content-center"
                                    >
                                        <h1
                                            class="m-0 text-warning fw-bold fs-1"
                                        >
                                            Toplam Kayıt Sayısı
                                        </h1>
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Balance-->
                                    <div
                                        class="d-flex text-center flex-column text-white"
                                    >
                                        <span
                                            class="fw-bold text-gray-700 fs-4x pt-1"
                                            >{{ monthly }}</span
                                        >
                                    </div>
                                </Link>
                                <!--end::Balance-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div
                        class="card card-xl-stretch mb-xl-8 card-rounded border border-warning"
                    >
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <!--begin::Header-->
                            <div class="px-9 pt-2 h-170px w-100">
                                <div class="calendar">
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="prevYear"
                                    >
                                        &#9664;
                                    </div>
                                    <div class="year text-gray-700">
                                        <VDatePicker v-model="currentYear">
                                            <template
                                                #default="{ togglePopover }"
                                            >
                                                <span
                                                    @click="togglePopover"
                                                    class="cursor-pointer"
                                                >
                                                    <i
                                                        class="la la-calendar text-warning fs-2x"
                                                    >
                                                    </i>
                                                    {{ formattedYear }}
                                                </span>
                                            </template>
                                        </VDatePicker>
                                    </div>
                                    <div
                                        class="arrow text-warning cursor-pointer"
                                        @click="nextYear"
                                    >
                                        &#9654;
                                    </div>
                                </div>
                                <!--begin::Heading-->
                                <Link
                                    :href="
                                        route('backend.logs.history-list', {
                                            year: currentYear,
                                            branch:branch
                                        })
                                    "
                                >
                                    <div
                                        class="d-flex flex-stack justify-content-center"
                                    >
                                        <h1
                                            class="m-0 text-warning fw-bold fs-1"
                                        >
                                            Toplam Kayıt Sayısı
                                        </h1>
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Balance-->
                                    <div
                                        class="d-flex text-center flex-column text-white"
                                    >
                                        <span
                                            class="fw-bold text-gray-700 fs-4x pt-1"
                                            >{{ yearly }}</span
                                        >
                                    </div>
                                    <!--end::Balance-->
                                </Link>
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Body-->
    </div>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import InputError from "@/Components/InputError";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import vSelect from "vue-select";

export default {
    name: "Index",
    components: { InputError, Link, vSelect },
    layout: AdminLayoutMaster,
    props: ["daily_count", "monthly_count", "yearly_count"],
    data() {
        return {
            currentMonth: new Date(),
            currentYear: new Date(),
            currentDate: new Date(),
            daily: 0,
            monthly: 0,
            yearly: 0,
            branch: null,
            form: this.$inertia.form({
                title: "",
                description: "",
            }),
        };
    },
    mounted() {
        this.daily = this.daily_count;
        this.monthly = this.monthly_count;
        this.yearly = this.yearly_count;
    },
    computed: {
        formattedDate() {
            const options = {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            };
            this.update("date");

            return this.currentDate.toLocaleDateString("tr-TR", options);
        },
        formattedMonth() {
            this.update("month");

            return moment(this.currentMonth).lang("tr").format("MMMM YYYY");
        },
        formattedYear() {
            this.update("year");

            return new Date(this.currentYear).getFullYear();
        },
    },
    watch: {
        branch: function (val) {
                this.update("date");
                this.update("month");
                this.update("year");
        },
    },
    methods: {
        nextMonth() {
            let month = this.currentMonth.setMonth(
                this.currentMonth.getMonth() + 1
            );
            this.currentMonth = new Date(month);

            this.update("month");
        },
        prevMonth() {
            let month = this.currentMonth.setMonth(
                this.currentMonth.getMonth() - 1
            );

            this.currentMonth = new Date(month);
        },
        nextYear() {
            let year = this.currentYear.setFullYear(
                this.currentYear.getFullYear() + 1
            );
            this.currentYear = new Date(year);
        },
        prevYear() {
            let year = (this.currentYear = this.currentYear.setFullYear(
                this.currentYear.getFullYear() - 1
            ));
            this.currentYear = new Date(year);
        },
        increaseDate() {
            let date = this.currentDate.setDate(this.currentDate.getDate() + 1);
            this.currentDate = new Date(date);
        },
        decreaseDate() {
            let date = this.currentDate.setDate(this.currentDate.getDate() - 1);
            this.currentDate = new Date(date);
        },
        async update(type) {
            if (type == "date") {
                let response = await axios.post(
                    route("backend.logs.history-date-update"),
                    {
                        date: this.currentDate,
                        branch:this.branch
                    }
                );

                this.daily = response.data.daily_count;
            } else if (type == "month") {
                let response = await axios.post(
                    route("backend.logs.history-month-update"),
                    {
                        month: this.currentMonth,
                        branch:this.branch
                    }
                );

                this.monthly = response.data.monthly_count;
            } else if (type == "year") {
                let response = await axios.post(
                    route("backend.logs.history-year-update"),
                    {
                        year: this.currentYear,
                        branch:this.branch
                    }
                );
                this.yearly = response.data.yearly_count;
            }
        },
    },
};
</script>

<style scoped>
.calendar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.arrow text-warning {
    cursor: pointer;
    font-size: 24px;
    padding: 8px;
}

.year,
.month,
.day {
    font-size: 24px;
    padding: 8px;
}
</style>
