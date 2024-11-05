<template>
    <div>
        <div @click="openModal" class="btn btn-light-primary font-weight-bold mr-2 mb-2">
            {{ __("Araba Modeli Oluştur") }}
        </div>
        <QuickTable title="Araba Modelleri" data-name="car-models" :data="models"
            :filter="{ role: false, search: false }">
            <template #toolbar></template>
            <template #header>
                <tr class="fw-bolder text-muted">
                    <th class="min-w-120px text-start w-25px">
                        {{ __("No") }}
                    </th>
                    <th class="">{{ __("Resim") }}</th>
                    <th class="">{{ __("İngilizce Model İsmi") }}</th>
                    <th class="">{{ __("Türkçe Model İsmi") }}</th>
                    <th class="">{{ __("İngilizce Marka Tipi") }}</th>
                    <th class="min-w-140px">{{ __("Türkçe Marka Tipi") }}</th>
                    <th class="">{{ __("Türkçe Fiyat Açıklaması") }}</th>
                    <th class="min-w-140px">{{ __("Türkçe Fiyat Açıklaması") }}</th>
                    <th class="text-center">{{ __("İşlemler") }}</th>
                </tr>
            </template>
            <template #rows>
                <template v-for="(project, index) in parsedModels" :key="project.id">
                    <transition name="list">
                        <tr>
                            <td class="text-start">#{{ project.id }}</td>
                            <td class="text-start" style="width: 120px">
                                <img :src="`http://127.0.0.1:8000/uploads/${project.image}`" width="120" />
                            </td>
                            <td class="text-start">{{ project.name.en }}</td>
                            <td class="text-start">{{ project.name.tr }}</td>
                            <td class="text-start">{{ project.desc.en }}</td>
                            <td class="text-start">{{ project.desc.tr }}</td>
                            <td class="text-start">{{ project.price.en }}</td>
                            <td class="text-start">{{ project.price.tr }}</td>
                            <td class="text-center">
                                <button @click="openEditModal(project)" class="btn btn-sm btn-primary">
                                    {{ __('Düzenle') }}
                                </button>
                                <button @click="deleteModel(project.id)" class="btn btn-sm btn-danger ml-3">
                                    {{ __('Sil') }}
                                </button>
                            </td>
                        </tr>
                    </transition>
                </template>
            </template>
        </QuickTable>

        <Modal :isOpen="isModalOpen" @close="closeModal">
            <form @submit.prevent="submitForm">
                <div class="mt-2">
                    <label class="mb-1">{{ __('Türkçe Model Adı') }}</label>
                    <input type="text" v-model="form.name_tr" class="form-control text-input" />
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('İngilizce Model Adı') }}</label>
                    <input type="text" v-model="form.name_en" class="form-control text-input" />
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('Türkçe Marka Açıklaması') }}</label>
                    <input type="text" v-model="form.desc_tr" class="form-control text-input" />
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('İngilizce Marka Açıklaması') }}</label>
                    <input type="text" v-model="form.desc_en" class="form-control text-input" />
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('Marka Seçiniz') }}</label>
                    <select v-model="form.brand_id" class="form-control">
                        <option v-for="brand in brands.data" :key="brand.id" :value="brand.id">
                            {{ brand.brand_name }}
                        </option>
                    </select>
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('Türkçe Fiyat Açıklaması Giriniz') }}</label>
                    <input type="text" v-model="form.price_tr" class="form-control text-input" />
                </div>
                <div class="mt-2">
                    <label class="mb-1">{{ __('İngilizce Fiyat Açıklaması Giriniz') }}</label>
                    <input type="text" v-model="form.price_en" class="form-control text-input" />
                </div>
                <div class="from-group mt-2">
                    <div v-if="!form.image || imageUrl">
                        <input class="form-control form-control-lg" type="file" @change="previewImage"
                            accept="image/*" />
                        <span class="badge badge-info mt-2">Yüklenen resim formatı .jpg, .png, .tif, .bmp
                            olabilir.</span>
                    </div>
                    <img v-if="imageUrl" :src="imageUrl" alt="Preview" />
                    <img v-else-if="form.image" :src="'/uploads/' + form.image" alt="Preview" />
                    <input-error :message="form.errors.file" class="mt-2" />
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-3">{{ form.id ? __('Güncelle') : __('Kaydet')
                        }}</button>
                </div>

            </form>
        </Modal>
    </div>
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
    props: ["models", "brands"],
    data() {
        return {
            isModalOpen: false,
            imageUrl: null,
            form: useForm({
                id: null,
                name_tr: "",
                name_en: "",
                desc_tr: "",
                desc_en: "",
                file: null,
                brand_id: null,
                image: null,
                price_tr: "",
                price_en: ""
            }),
        };
    },

    methods: {
        previewImage(event) {
            this.imageUrl = URL.createObjectURL(event.target.files[0]);
            this.form.file = event.target.files[0];
        },
        openModal() {
            this.resetForm();
            this.isModalOpen = true;
        },
        openEditModal(project) {
            this.form.id = project.id;
            this.existingContentName = JSON.parse(project.name);
            this.existingContentDesc = JSON.parse(project.desc);
            this.existingContentPrice = JSON.parse(project.price);
            console.log(this.existingContentName)
            this.form.name_tr = this.existingContentName.tr;

            this.form.name_en = this.existingContentName.en;
            this.form.desc_tr = this.existingContentDesc.tr;
            this.form.desc_en = this.existingContentDesc.en;
            this.form.price_tr = this.existingContentPrice.tr;
            this.form.price_en = this.existingContentPrice.en;
            this.form.brand_id = project.brand_id;
            this.form.image = project.image;
            this.imageUrl = '/uploads/' + project.image;
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        resetForm() {
            this.form.reset();
            this.imageUrl = null;
        },
        async deleteModel(id) {
            if (!confirm("Kaydı silmek istediğinize emin misiniz?")) return;

            try {
                await this.$inertia.delete(route("backend.models.delete", id), {
                    onSuccess: () => {
                        console.log("Record soft deleted");
                    },
                    onError: () => {
                        console.error("Delete failed");
                    },
                });
            } catch (error) {
                console.error("Delete request error:", error);
            }
        },
        async submitForm() {
            try {
                if (this.form.id) {
                    this.form.post(route("backend.models.update", this.form.id), {
                        onFinish: () => {
                            this.closeModal();
                        },
                        onSuccess: () => {
                            this.closeModal();
                            this.resetForm();
                        },
                        onError: () => {
                            console.error("Form submission failed");
                        },
                    });
                } else {
                    this.form.post(route("backend.models.create"), {
                        onFinish: () => {
                            this.closeModal();
                        },
                        onSuccess: () => {
                            this.closeModal();
                            this.resetForm();
                        },
                        onError: () => {
                            console.error("Form submission failed");
                        },
                    });
                }
            } catch (error) {
                console.error("Form submission failed:", error);
            }
        },
    },
    computed: {
        parsedModels() {
            return this.models.data.map(project => {
                let name = {};
                let desc = {};
                let price = {};

                // Safely parse name
                try {
                    name = JSON.parse(project.name) || {};
                } catch (e) {
                    console.error("Failed to parse name:", e);
                }

                // Safely parse desc
                try {
                    desc = JSON.parse(project.desc) || {};
                } catch (e) {
                    console.error("Failed to parse desc:", e);
                }

                // Safely parse price
                try {
                    price = JSON.parse(project.price) || {};
                } catch (e) {
                    console.error("Failed to parse price:", e);
                }

                return {
                    ...project,
                    name,
                    desc,
                    price,
                };
            });
        }
    }
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modals {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 500px;
    max-width: 100%;
}

.text-input {
    border-radius: 4px;
    border: 1px solid #E4E6EF;
    padding: 9px
}
</style>
