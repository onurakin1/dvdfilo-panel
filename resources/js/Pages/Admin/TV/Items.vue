<template>
    <div class="row">
        <div class="col-6">
            <h1 style="font-weight: 500; font-size: 22px" class="m-5">
                {{ signa.name }} / {{ signa.screens.name }} - Ekran Resimleri
            </h1>
            <file-pond
                :multiple="true"
                fileType="image"
                :item_id="tv_id"
                :group_id="signa.id"
                :refference="'branch'"
            ></file-pond>
        </div>
        <div class="row">
            <div class="col-6">
                <template
                    v-for="(node, index) in files"
                    :key="node"
                    class="item-row"
                >
                    <!--begin::Radio group-->
                    <!--begin::Radio button-->
                    <label
                        class="btn-outline btn-outline-dashed d-flex ps-0 pt-0 pb-0 flex-stack text-start mb-5"
                        style="background: #f1f0ef"
                    >
                        <!--end::Description-->
                        <div class="d-flex align-items-center me-2">
                            <!--begin::Radio-->
                            <div class="me-6 cursor-move drag-cover-image">
                                <img
                                    class="w-90px h-90px"
                                    style="object-fit: cover"
                                    alt=""
                                    :src="node['image_url']"
                                />
                            </div>

                            <!--end::Radio-->

                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <h2
                                    class="d-flex align-items-center fs-3 fw-bolder flex-wrap"
                                >
                                    {{ index }}
                                </h2>
                                <div class="fw-bold opacity-50"></div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Description-->

                        <!--begin::Price-->
                        <div class="ms-5">
                            <div class="ms-auto me-3">
                                <a
                                    :href="node['image_url']"
                                    target="_blank"
                                    class="cursor-pointer"
                                    >{{ __("Göster") }}</a
                                >
                                |
                                <a
                                    @click="deleteData(index)"
                                    :href="void 0"
                                    class="cursor-pointer"
                                    >{{ __("Kaldır") }}</a
                                >
                            </div>
                        </div>

                        <!--end::Price-->
                    </label>
                    <!--end::Radio button-->

                    <!--end::Radio group-->
                </template>
            </div>
        </div>
    </div>
    <!--end::Row-->
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import QuickTable from "@/Components/QuickTable";
import { Head, Link } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";
import InputError from "@/Components/InputError";
import FilePondComponent from "@/Components/FilePond";
import { Tree, Draggable, Fold } from "he-tree-vue";

export default {
    name: "Index",
    components: {
        Head,
        Link,
        QuickTable,
        FormAlert,
        InputError,
        "file-pond": FilePondComponent,
        Tree: Tree.mixPlugins([Draggable, Fold]),
    },
    layout: AdminLayoutMaster,
    props: ["signa", "files", "flash", "tv_id"],
    data() {
        return {
            filteredResult: {},
            coppied_text: "",
            showModal: false,
            searchData: "",
            success: null,
            form: this.$inertia.form({
                group_id: this.signa.id,
                tv_id: this.tv_id,
                type: "group",
            }),
        };
    },
    methods: {
        onEnd(evt) {
            console.log(evt);
        },
        eachDroppable(node) {
            return node.length <= 0;
        },
        deleteData(id) {
            this.$swal({
                title: "Emin misiniz?",
                text: "Bu işlem geri alınamaz!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eminim, sil!",
                cancelButtonText: "İptal",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.post(route("backend.files.destroy", id), {
                        onSuccess: (response) => {
                            this.$swal({
                                title: "Silindi!",
                                text: "Kayıt başarıyla silindi.",
                                icon: "success",
                                confirmButtonText: "Kapat",
                            });
                            this.form.reset();
                        },
                    });
                }
            });
        },
    },
};
</script>

<style scoped></style>
