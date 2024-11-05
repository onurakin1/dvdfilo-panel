<template>
    <div @click="openModal" class="btn btn-light-primary font-weight-bold mr-2 mb-2" >
        {{ __("Marka Oluştur") }}
    </div>
    <QuickTable title="Markalar" data-name="brands" :data="brands" :filter="{ role: false, search: false }">
        <template #toolbar></template>
        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-120px text-start w-25px">
                    {{ __("No") }}
                </th>
                <th class="">{{ __("Model") }}</th>
                <th class="min-w-140px">{{ __("Marka Tipi") }}</th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(project, index) in brands.data" :key="project.id">
                <transition name="list">
                    <tr>
                        <td class="text-start">#{{ project.id }}</td>
                        <td class="text-start">{{ project.brand_name }}</td>
                        <td class="text-start">
                            {{ project.brand_type }}
                        </td>
                    </tr>
                </transition>
            </template>
        </template>
    </QuickTable>
    <Modal :isOpen="isModalOpen" @close="closeModal" >
        <form @submit.prevent="submitForm">
            <!-- Form alanları -->
            <div>
                <label>{{ __('Marka Adı') }}</label>
                <input type="text" v-model="form.brand_name" class="form-control text-input" />
            </div>
            <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-3">{{ form.id ? __('Güncelle') : __('Kaydet')
                    }}</button>
                </div>
        </form>
    </Modal>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import Breadcrumb from "@/Layouts/AdminLayouts/Breadcrumb";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";
import QuickTable from "@/Components/QuickTable";
import Modal from "@/Components/Modal";

export default {
    name: "Index",
    components: { QuickTable, Breadcrumb, Link, FormAlert, Modal },
    layout: AdminLayoutMaster,
    props: ["brands"],
    data() {
        return {
            isModalOpen: false,
            form: useForm({
                brand_name: "",
            }),
        };
    },
    methods: {
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        async submitForm() {
            try {
                this.form.post(route("backend.brands.create"), {
                    onFinish: () => {
                        this.closeModal();
                    },
                    onSuccess: () => {
                        this.closeModal();
                        this.form.reset();
                    },
                    onError: () => {
                        console.error("Form submission failed");
                    },
                });
            } catch (error) {
                console.error("Form submission failed:", error);
            }
        },
    },
    created() {
        window.Echo.channel("replicate-channel").listen(
            ".App\\Events\\ReplicateEvent",
            (e) => {
                Inertia.reload();
                console.log("ReplicateEvent", e);
            }
        );
    },
    mounted() {},
};
</script>

<style scoped>
.text-input{
    border-radius: 4px;
    border: 1px solid #E4E6EF;
    padding: 9px
}
</style>
