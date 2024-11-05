<template>
    <form-alert :success="flash.success" />
    <QuickTable
        :title="__('Anlık Loglar')"
        data-name="logs"
        :data="logs"
        :filter="{ search: true, branch: true}"
    >

    <template #toolbar>
        <a href="javascript:void(0)" class="btn btn-active-light-dark"><i class="la la-wifi text-warning fs-2x me-1"></i> Anlık Kayıt Sayısı : {{ active_connection_count }} </a>
    </template>

        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-140px">{{ __("Şube") }}</th>
                <th class="min-w-140px">{{ __("İsim Soyisim") }}</th>
                <th class="min-w-140px">{{ __("Telefon No") }}</th>
                <th class="min-w-140px">{{ __("Mac ID") }}</th>
                <th class="min-w-140px">{{ __("Lokal IP") }}</th>
                <th class="min-w-140px">{{ __("Başlangıç Zamanı") }}</th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(log, index) in logs.data" :key="log">
                <transition name="list">
                    <tr>
                        <td>
                            {{ log.branch ? log.branch.name : "-" }}
                        </td>
                        <td>
                            {{ log.user ? log.user.name : "-" }}
                        </td>
                        <td>
                            {{ log.username}}
                        </td>
                        <td>
                            {{ log.callingstationid }}
                        </td>
                        <td>
                            {{ log.framedipaddress }}
                        </td>
                        <td>
                            {{ log.date_time }}
                        </td>

                    </tr>
                </transition>
            </template>
        </template>
    </QuickTable>
    <!--end::Row-->
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import QuickTable from "@/Components/QuickTable";
import { Head, Link } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";
import InputError from "@/Components/InputError";

export default {
    name: "Index",
    components: { Head, Link, QuickTable, FormAlert, InputError },
    layout: AdminLayoutMaster,
    props: ["logs", "flash","active_connection_count"],
    data() {
    },

};
</script>

<style scoped></style>
