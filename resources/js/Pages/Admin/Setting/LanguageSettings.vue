<template>
    <div class="tab-pane fade" id="lang" role="tabpanel">
        <form @submit.prevent="update" class="form">
            <!--begin::Card body-->
            <div class="card-body p-50">

                <!--begin::Input group-->
                <div class="row mb-6" v-for="item in lang">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-bold fs-6 " :class="item.rules.search('required')"
                           :for="item.key">
                        {{ item.trans_label }}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9 fv-row" v-if="item.type === 'multiple'">
                           <v-select
                                class="form-control form-control-solid"
                                :options="$page.props.setting_languages"
                                label="name"
                                multiple
                                v-model="langForm[item.key]"
                                placeholder="Dil Seçiniz"
                            >
                                <template v-slot:no-options>Kayıt bulunamadı.</template>
                            </v-select>
                        <input-error :message="langForm.errors[item.key]" class="mt-2"/>
                        <input-error :message="langForm.errors[item.key+'.0']" class="mt-2"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary btn-sm" :disabled="langForm.processing">
                    <span class="indicator-label" v-if="!langForm.processing">Değişiklikleri Kaydet</span>
                    <span class="indicator-label" v-else> <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span> Kaydediliyor
                    </span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
    </div>
</template>

<script>
import {useForm} from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError'
import vSelect from "vue-select";

export default {
    name: "LanguageSettings",
    props: ['lang'],
    components:{InputError,"v-select": vSelect},
    data() {
        return {
            langForm: this.$inertia.form({})
        }
    },
    mounted() {
        this.setFormData();
    },
    methods: {
        setFormData() {
            let formData = {};
            this.lang.forEach(r => {
                formData[r.key] = r.value;
            })

            this.langForm = useForm('langForm', formData)

        },
        update() {
            this.langForm.post(route('backend.settings.update'));
        }
    }
}
</script>

<style scope>
.vs__selected:first-child{
    background: #f9d003 !important;
    color:#fff;
}
</style>
