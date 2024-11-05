<template>
    <form-alert :success="flash.success" />
    <QuickTable
        :title="__('Sistem Logları')"
        data-name="log-activity"
        :data="logs"
        :filter="{ role: false, search: true }"
    >
        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-140px">{{ __("Tipi") }}</th>
                <th class="min-w-140px">{{ __("İşlem") }}</th>
                <th class="min-w-140px">{{ __("Kullanıcı") }}</th>
                <th class="min-w-140px">{{ __("Model") }}</th>
                <th class="min-w-140px">{{ __("Model ID") }}</th>
                <th class="min-w-140px">{{ __("IP") }}</th>
                <th class="min-w-140px">{{ __("Browser/OS") }}</th>
                <th class="min-w-140px">{{ __("Tarih") }}</th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(log, index) in logs.data" :key="log">
                <transition name="list">
                    <tr>
                        <td>
                            {{ log.log_name }}
                        </td>
                        <td>
                            {{ log.description }}
                        </td>
                        <td>
                            {{ log.causer ? log.causer.username : "" }}
                        </td>
                        <td>
                            {{ log.subject_type }}
                        </td>
                        <td>
                            {{ log.subject_id }}
                        </td>
                        <td>
                            {{ log.properties.agent.ip }}
                        </td>
                        <td>
                            {{ log.properties.agent.browser }} /
                            {{ log.properties.agent.os }}
                        </td>
                        <td>
                            {{ moment_helper(log.created_at) }}
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
    props: ["logs", "flash"],
    data() {
        return {
            form: this.$inertia.form({
                id: null,
            }),
        };
    },
    methods: {
        moment_helper(date) {
            return moment(date).format("DD.MM.Y hh:mm");
        },
        async deleteData(index) {
            let item = this.productCategories.data[index];
            let result = await this.$swal({
                title: this.__("alert.delete.title"),
                text: this.__("alert.delete.description"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.__("alert.delete.approve"),
                cancelButtonText: this.__("alert.delete.cancel"),
            });

            if (result.isConfirmed) {
                this.form.delete(
                    route("backend.product-categories.destroy", item.id),
                    {
                        onSuccess: () => {
                            this.$swal({
                                title: this.__("alert.delete.success_title"),
                                text: this.__(
                                    "alert.delete.success_description"
                                ),
                                icon: "success",
                                confirmButtonText:
                                    this.__("alert.delete.close"),
                            });
                            this.form.reset();
                        },
                    }
                );
            }
        },
    },
    mounted() {},
};
</script>

<style scoped></style>
