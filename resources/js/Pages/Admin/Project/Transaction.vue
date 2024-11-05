,
<template>
    <form-alert :success="flash.success" />
{{ projects }}
    <QuickTable
        title="Geçmiş Modeller"
        data-name="project-transactions"
        :data="projects"
        :filter="{ role: false, search: false }"
    >
        <template #toolbar> </template>
        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-120px text-start w-25px">
                    {{ __("No") }}
                </th>
                <th class="">{{ __("Model") }}</th>
                <th class="min-w-140px">{{ __("Açıklama") }}</th>
                <th class="min-w-120px">{{ __("Oluşan Model") }}</th>
                <th class="min-w-120px">{{ __("Çekilen Model") }}</th>
                <th class="min-w-120px">{{ __("Durum") }}</th>
                <th class="min-w-120px w-150px text-start">
                    {{ __("İşlemler") }}
                </th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(project, index) in projects.data" :key="project">
                <transition name="list">
                    <tr>
                        <td class="text-start">#{{ project.id }}</td>
                        <td class="text-start" style="width: 120px">
                            <img :src="project.main_image" width="120" />
                        </td>
                        <td class="text-start">{{ project.description }}</td>
                        <td class="text-start">
                            {{ project.product_count }} adet
                        </td>
                        <td class="text-start">
                            {{ project.full_images.length }} adet
                        </td>
                        <td class="text-start">
                            <span
                                v-if="!project.full_status && !project.is_human"
                                class="badge badge-light-primary flex-shrink-0 align-self-center py-3 px-4 fs-7"
                                >İşlemde
                            </span>
                            <span
                                v-else
                                class="badge badge-light-success flex-shrink-0 align-self-center py-3 px-4 fs-7"
                                >Tamamlandı
                            </span>
                        </td>
                        <td class="text-start">
                            <Link
                                :href="route('backend.projects.id', project.id)"
                                class="btn btn-sm btn-light btn-active-light-primary"
                            >
                                {{ __("Detay") }}
                            </Link>
                        </td>
                    </tr>
                </transition>
            </template>
        </template>
    </QuickTable>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import Breadcrumb from "@/Layouts/AdminLayouts/Breadcrumb";
import QuickTable from "@/Components/QuickTable";
import GeneralHelper from "@/Helper/General";
import { Link } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";

export default {
    name: "Index",
    components: { QuickTable, Breadcrumb, Link, FormAlert },
    layout: AdminLayoutMaster,
    props: ["projects", "flash"],
    data() {
        return {
 
        };
    },
    methods: {},
    mounted() {},
};
</script>
