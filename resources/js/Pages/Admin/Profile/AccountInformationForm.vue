<template>
    <div class="tab-pane px-7 active" id="accountUpdate" role="tabpanel">

        <form @submit.prevent="updateProfileInformation" class="form">
            <!--begin::Card body-->
            <div class="card-body  p-50">
                <!--begin::Input group-->
                <div class="row mb-6" style="display:none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">{{__('pages.profile.avatar')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true"
                             :style="'background-image: url('+user.profile_photo_url ?? '/backend/media/avatars/blank.png'+')'">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px" :style="photoPreview ? 'background-image:url('+photoPreview+')':''"></div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                   data-kt-image-input-action="change" data-bs-toggle="tooltip" title="">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" name="avatar" ref="photo"  @change="updatePhotoPreview" accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="avatar_remove" value="1">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->

                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                  :data-bs-original-title="__('delete')">
																<i class="bi bi-x fs-2"></i>
															</span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->

                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label  fw-bold fs-6">{{__('pages.profile.username')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="username" readonly v-model="form.username"
                               class="form-control form-control-lg form-control-solid"
                               :placeholder="__('pages.profile.username')">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        {{__('İsim')}}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" v-model="form.name"
                               :class="{ 'is-invalid': form.errors.name }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.name" class="mt-2"/>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6"> {{__('pages.profile.surname')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="last_name" v-model="form.last_name"
                               :class="{'is-invalid': form.errors.last_name }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.last_name" class="mt-2"/>

                    </div>
                    <!--end::Col-->
                </div>

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6"> {{__('E-posta')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="email" v-model="form.email"
                               :class="{ 'is-invalid': form.errors.email }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.email" class="mt-2"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6"> {{__('pages.profile.nickname')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="nick_name" v-model="form.nick_name"
                               :class="{'is-invalid': form.errors.nick_name }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.nick_name" class="mt-2"/>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6"> {{__('pages.profile.displayname')}}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                       <select class="form-control form-control-select form-control-solid" v-model="form.display_name">
                           <option v-if="form.username" :value="form.username">{{form.username}}</option>
                           <option v-if="form.first_name" :value="form.first_name">{{form.first_name}}</option>
                           <option v-if="form.last_name" :value="form.last_name">{{form.last_name}}</option>
                           <option v-if="form.first_name && form.last_name" :value="form.first_name+' '+form.last_name">{{form.first_name+' '+form.last_name}}</option>
                           <option v-if="form.nick_name" :value="form.nick_name">{{form.nick_name}}</option>
                       </select>
                        <input-error :message="form.errors.display_name" class="mt-2"/>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary btn-sm" :disabled="form.processing">
                    <span class="indicator-label" v-if="!form.processing">{{__('button.save_changes')}}</span>
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

import InputError from '@/Components/InputError';
import FormAlert from "@/Components/FormAlert";

export default {
    props: ['user'],
    components: {
        InputError
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.user.name,
                email: this.user.email,
            }),
            photoPreview: null,
        }
    },
    methods: {
        updateProfileInformation() {

            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0];
            }

            this.form.post(route('backend.profile.account.update'));

        },
        selectNewPhoto() {
            this.$refs.photo.click();
        },
        updatePhotoPreview() {

            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },
        async deletePhoto() {
           await this.$inertia.delete(route('backend.profile.photo.destroy'), {
                preserveScroll: true,
            })
            this.photoPreview = null
        },
    },
}
</script>
