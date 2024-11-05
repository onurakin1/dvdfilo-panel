<template>
    <form-alert :success="flash.success" />
    <QuickTable
        :title="__('Geçmiş Kayıtlar Raporu')"
        data-name="history-list"
        :data="logs"
        :filter="{ search: true, branch: true,between:true}"
    >
        <template #toolbar> </template>

        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-140px">{{ __("Şube") }}</th>
                <th class="min-w-140px">{{ __("İsim Soyisim") }}</th>
                <th class="min-w-140px">{{ __("Telefon No") }}</th>
                <th class="min-w-140px">{{ __("Mac ID") }}</th>
                <th class="min-w-140px">{{ __("Lokal IP") }}</th>
                <th class="min-w-140px">{{ __("Başlangıç Zamanı") }}</th>
                <th class="min-w-140px">{{ __("Bitiş Zamanı") }}</th>
                <th class="min-w-140px">{{ __("Bağlantı Süresi") }}</th>
                <th class="min-w-140px">{{ __("Kullanım Miktarı") }}</th>
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
                            {{ log.username }}
                        </td>
                        <td>
                            {{ log.callingstationid }}
                        </td>
                        <td>
                            {{ log.framedipaddress }}
                        </td>
                        <td>
                            {{ log.start_time }}
                        </td>
                        <td>
                            {{ log.stop_time }}
                        </td>
                        <td>
                            {{ log.session_time }}
                        </td>
                        <td>
                            {{ log.used_size }}
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
    props: ["logs", "flash", "active_connection_count", "branches"],
    data() {},
    mounted() {},
};
</script>

<style scoped></style>
