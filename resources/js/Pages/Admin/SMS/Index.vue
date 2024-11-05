<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >Kullanıcılara SMS Gönder</span
                        >
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3 pb-10">
                    <form class="form">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Şube Seçimi</label>
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
                                <span class="form-text text-muted"
                                    >Şube seçimi yapılmaz ise tüm kullanıcılara
                                    gönderim yapılır.</span
                                >
                            </div>
                            <div class="form-group mt-3">
                                <label>SMS Mesajı</label>
                                <textarea
                                    rows="5"
                                    class="form-control form-control-textarea"
                                    placeholder="Lütfen mesaj metnini giriniz."
                                />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="reset" class="btn btn-primary mr-2">
                                Gönder
                            </button>
                        </div>
                    </form>
                </div>
                <!--begin::Body-->
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
    components: { InputError, Link, vSelect },
    layout: AdminLayoutMaster,
};
</script>
