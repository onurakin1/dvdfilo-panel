<template>
    <div class="tab-pane fade show active  " id="general" role="tabpanel">
        <form @submit.prevent="update" class="form">
            <!--begin::Card body-->
            <div class="card-body  p-50">

                <!--begin::Input group-->
                <div class="row mb-6" v-for="item in general">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-bold fs-6 " :class="item.rules.search('required')"
                           :for="item.key">
                        {{ item.trans_label }}
                    </label>
                    <!--end::Label-->
                    <div class="col-lg-9 fv-row" v-if="item.type === 'text'">
                        <input type="text" :id="item.key" :name="item.key" v-model="generalForm[item.key]"
                               :class="{ 'is-invalid': generalForm.errors[item.key] }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="generalForm.errors[item.key]" class="mt-2"/>
                    </div>

                    <div class="col-lg-9 fv-row" v-if="item.type === 'textarea'">
                        <textarea rows="4" :id="item.key" :name="item.key" v-model="generalForm[item.key]"
                                  :class="{ 'is-invalid': generalForm.errors[item.key] }"
                                  class="form-control form-control-lg form-control-solid">{{item.value}}</textarea>
                        <input-error :message="generalForm.errors[item.key]" class="mt-2"/>
                    </div>

                    <div class="col-lg-9 fv-row" v-if="item.type === 'image'">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline image-input-empty d-block">
                            <!--begin::Preview existing avatar-->
                            <img :src="item.value" class="c-image-preview" v-if="!photoPreview[item.key]">
                            <img :src="photoPreview[item.key]" class="c-image-preview" v-else>
                            <!--end::Preview existing avatar-->

                            <!--begin::Label-->
                            <label
                                class="btn btn-sm btn-circle btn-active-color-primary  bg-body shadow d-inline-block mt-3">
                                <i class="bi bi-pencil-fill fs-7"></i> {{__('change')}}
                                <!--begin::Inputs-->
                                <input type="file" name="photo" :ref="'photo-'+item.key" class="d-none"
                                       @change="updatePhotoPreview(item.key)"
                                       accept=".png, .jpg, .jpeg, .svg">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->

                        </div>
                        <!--end::Image input-->
                        <input-error :message="generalForm.errors[item.key]" class="mt-2"/>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary btn-sm" :disabled="generalForm.processing">
                    <span class="indicator-label" v-if="!generalForm.processing">{{__('button.save_changes')}}</span>
                    <span class="indicator-label" v-else> <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span> {{__('button.saving')}}
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
    name: "GeneralSettings",
    props: ['general'],
    components: {InputError},
    data() {
        return {
            generalForm: this.$inertia.form({}),
            photoPreview: []
        }
    },
    mounted() {
        this.setFormData();
    },
    methods: {
        updatePhotoPreview(key_name) {

            const reader = new FileReader();
            reader.onload = (e) => {
                this.photoPreview[key_name] = e.target.result;
            };

            reader.readAsDataURL(this.$refs['photo-' + key_name][0].files[0]);
        },
        setFormData() {
            let formData = {};
            this.general.forEach(r => formData[r.key] = r.value);

            this.generalForm = useForm('generalForm', formData)
        },
        update() {

            let self = this;
            this.general.forEach(r => {
                if (this.$refs['photo-' + r.key]) {
                    self.generalForm[r.key] = this.$refs['photo-' + r.key][0].files[0];
                }
            });

            this.generalForm.post(route('backend.settings.update'));
        }
    }
}
</script>

<style scoped>
.c-image-preview {
    display: block;
    max-width: 500px !important;
    max-height: 300px;
    background: #f5f8fa;
}
</style>
