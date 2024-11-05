<template>
    <div class="tab-pane fade  " id="seo" role="tabpanel">
        <form @submit.prevent="update" class="form">
            <!--begin::Card body-->
            <div class="card-body  p-50">

                <!--begin::Input group-->
                <div class="row mb-6" v-for="item in seo">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-bold fs-6 " :class="item.rules.search('required')"
                           :for="item.key">
                        {{ item.trans_label }}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9 fv-row" v-if="item.type === 'text'">
                        <input type="text" :id="item.key" :name="item.key" v-model="seoForm[item.key]"
                               :class="{ 'is-invalid': seoForm.errors[item.key] }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="seoForm.errors[item.key]" class="mt-2"/>
                    </div>
                    <!--end::Col-->

                    <div class="col-lg-9 fv-row" v-if="item.type === 'textarea'">
                        <textarea rows="4" :id="item.key" :name="item.key" v-model="seoForm[item.key]"
                                  :class="{ 'is-invalid': seoForm.errors[item.key] }"
                                  class="form-control form-control-lg form-control-solid">{{item.value}}</textarea>
                        <input-error :message="seoForm.errors[item.key]" class="mt-2"/>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary btn-sm" :disabled="seoForm.processing">
                    <span class="indicator-label" v-if="!seoForm.processing">Değişiklikleri Kaydet</span>
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
export default {
    name: "SeoSettings",
    props: ['seo'],
    components:{InputError},
    data() {
        return {
            seoForm: this.$inertia.form({})
        }
    },
    mounted() {
        this.setFormData();
    },
    methods: {
        setFormData() {
            let formData = {};
            this.seo.forEach(r => {
                formData[r.key] = r.value;
            })
            this.seoForm = useForm('seoForm', formData)

        },
        update() {
            this.seoForm.post(route('backend.settings.update'));
        }
    }
}
</script>

<style scoped>

</style>
