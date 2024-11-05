<template>
    <form-alert :success="flash.success" />
    <div class="row">
        <div class="col-xl-12">
            <!--begin::Tables Widget 9-->
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5 pb-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >Şube Grupları</span
                        >
                    </h3>
                    <div class="card-toolbar" title="">
                        <a
                            @click="filterTypeNewModal()"
                            href="#"
                            class="btn btn-sm btn-light btn-active-primary"
                        >
                            Yeni Grup Ekle</a
                        >
                    </div>
                </div>
                <!--end::Header-->
            </div>
            <!--end::Tables Widget 9-->
        </div>
        <div class="col-xl-4" v-for="group in groups" :key="group">
            <!--begin::Tables Widget 9-->
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >{{ group.name }}

                            <span class="text-muted fw-bold fs-8">
                                ({{ group.screen_type.name }})
                            </span>
                        </span>
                        <span
                            class="text-muted fw-bold fs-7 cursor-pointer"
                            @click="filterTypeEditModal(group)"
                            >Düzenle</span
                        >
                    </h3>
                    <div class="card-toolbar">
                        <Link
                            :href="route('backend.groups.screens', group.id)"
                            class="btn btn-sm btn-light btn-active-primary mr-2"
                        >
                            Ekranlar</Link
                        >
                        <a
                            href="#"
                            class="btn btn-sm btn-light btn-active-primary"
                            @click="filterNewModal(group)"
                        >
                            Şube Ekle</a
                        >
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-hover table-condensed table-row-dashed"
                        >
                            <tbody>
                                <tr
                                    v-for="branch in group.branches"
                                    :key="branch"
                                >
                                    <td>{{ branch.name }}</td>
                                    <td style="text-align: right">
                                        <Link
                                            class="btn btn-xs btn-light btn-active-warning p-1 ps-2 pb-2 mr-2"
                                            :href="
                                                route(
                                                    'backend.groups.branch.screens',
                                                    branch.id
                                                )
                                            "
                                        >
                                            <i class="fa fa-cubes" />
                                        </Link>
                                        <button
                                            class="btn btn-xs btn-light btn-active-danger p-1 ps-2 pb-2"
                                            @click="deleteData(branch.id)"
                                        >
                                            <i class="fa fa-trash" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 9-->
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="type_add_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ form.id ? " Grup Düzenle" : "Yeni Grup Ekle" }}
                    </h5>

                    <!--begin::Close-->
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <span class="svg-icon svg-icon-2x"
                            ><i class="fas fa-times"></i
                        ></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="name" class="required form-label">{{
                            "Grup Adı"
                        }}</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="form.name"
                            :class="{
                                'is-invalid': form.errors.name,
                            }"
                            class="form-control form-control-solid"
                            :placeholder="__('Grup Adı giriniz.')"
                        />
                        <input-error :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <label
                            for="screen_type_id"
                            class="required form-label"
                            >{{ "Ekran Dizilimi" }}</label
                        >
                        <select
                            class="form-control form-control-solid"
                            name="screen_type_id"
                            id="screen_type_id"
                            v-model="form.screen_type_id"
                            :class="{
                                'is-invalid': form.errors.screen_type_id,
                            }"
                        >
                            <option value="">Seçim Yap</option>
                            <option
                                v-for="t in screen_types"
                                :value="t.id"
                                :key="t"
                            >
                                {{ t.name }}
                            </option>
                        </select>

                        <input-error
                            :message="form.errors.screen_type_id"
                            class="mt-2"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Vazgeç
                    </button>
                    <button
                        v-if="form.id"
                        type="button"
                        class="btn btn-danger"
                        @click="deleteGroup(form.id)"
                    >
                        Sil
                    </button>
                    <button
                        :disabled="form.processing"
                        type="button"
                        @click="groupUpdateStore"
                        class="btn btn-primary"
                    >
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="filter_add_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ group.name }} için Şube Ekle</h5>

                    <!--begin::Close-->
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <span class="svg-icon svg-icon-2x"
                            ><i class="fas fa-times"></i
                        ></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="me-auto w-400px">
                        <v-select
                            :options="branches"
                            v-model="branch_form.branch_ids"
                            label="name"
                            :reduce="(branch) => branch.id"
                            placeholder="Şube Seçimi"
                            class="form-control"
                            :multiple="true"
                            :closeOnSelect="false"
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

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Vazgeç
                    </button>
                    <button
                        :disabled="branch_form.processing"
                        type="button"
                        @click="branchStore"
                        class="btn btn-primary"
                    >
                        Ekle
                    </button>
                </div>
            </div>
        </div>
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
    props: ["flash", "groups", "screen_types", "branches"],
    components: { InputError, Link, vSelect },
    layout: AdminLayoutMaster,
    data() {
        return {
            form: this.$inertia.form({
                id: null,
                name: "",
                screen_type_id: "",
            }),
            delete_group_form: this.$inertia.form({}),
            branch_form: this.$inertia.form({
                group_id: "",
                branch_ids: [],
            }),
            group: "",
        };
    },
    methods: {
        filterTypeNewModal() {
            $("#type_add_modal").modal("show");
        },
        filterNewModal(group) {
            this.group = group;
            $("#filter_add_modal").modal("show");
        },
        async branchStore() {
            this.branch_form.group_id = this.group.id;
            this.branch_form.post(route("backend.groups.add_branch"), {
                onSuccess: (response) => {
                    this.branch_form.reset();
                    $("#filter_add_modal").modal("hide");
                },
                preserveScroll: true,
            });
        },
        async groupUpdateStore() {
            let routeData = this.form.id
                ? {
                      submit: "put",
                      url: route("backend.groups.update", this.form.id),
                  }
                : {
                      submit: "post",
                      url: route("backend.groups.store"),
                  };

            this.form.submit(routeData.submit, routeData.url, {
                onSuccess: (response) => {
                    this.form.reset();

                    $("#type_add_modal").modal("hide");
                },
                preserveScroll: true,
            });
        },
        async deleteData(id) {
            this.form.get(route("backend.branch.delete_group", id), {
                onSuccess: () => {
                    this.$swal({
                        title: "İşlem Başarılı",
                        text: "Şube gruptan çıkarıldı.",
                        icon: "success",
                        confirmButtonText: "Kapat",
                    });
                },
                preserveScroll: true,
            });
        },
        async deleteGroup(id) {
            let result = await this.$swal({
                title: "Grup Silme İşlemi",
                text: "Grubu silmek üzeresiniz. Bu işlem geri alınamaz!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Evet, sil!",
                cancelButtonText: "Vazgeç",
            });

            if (result.isConfirmed) {
                this.delete_group_form.delete(
                    route("backend.groups.destroy", id),
                    {
                        onSuccess: () => {
                            this.$swal({
                                title: "İşlem Başarılı",
                                text: "Grup başarıyla silindi.",
                                icon: "success",
                                confirmButtonText: "Kapat",
                            });
                            $("#type_add_modal").modal("hide");
                        },
                        preserveScroll: true,
                    }
                );
            }
        },
        filterTypeEditModal(group) {
            this.form.id = group.id;
            this.form.name = group.name;
            this.form.screen_type_id = group.screen_type_id;

            $("#type_add_modal").modal("show");
        },
    },
};
</script>
