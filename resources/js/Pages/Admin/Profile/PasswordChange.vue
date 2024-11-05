<template>
    <div class="tab-pane px-7 active" id="accountUpdate" role="tabpanel">

        <form @submit.prevent="updatePasswordChange" class="form">
            <!--begin::Card body-->
            <div class="card-body  p-50">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                        {{__('Geçerli Şifre')}}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="password" name="current_password" v-model="form.current_password"
                               :class="{ 'is-invalid': form.errors.current_password }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.current_password" class="mt-2"/>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                        {{__('Yeni Şifre')}}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="password" name="password" v-model="form.password"
                               :class="{ 'is-invalid': form.errors.password }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.password" class="mt-2"/>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                        {{__('Yeni Şifre Tekrar')}}
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="password" name="password_confirmation" v-model="form.password_confirmation"
                               :class="{ 'is-invalid': form.errors.password_confirmation }"
                               class="form-control form-control-lg form-control-solid">
                        <input-error :message="form.errors.password_confirmation" class="mt-2"/>

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
import InputError from "@/Components/InputError";

export default {
    name: "PasswordChange",
    components: {InputError},
    data() {
        return {
            form: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            }),

        }
    },
    methods: {
        updatePasswordChange() {
            this.form.put(route('backend.profile.account.password.change'), {
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.reset();
                },
            });

        }
    }
}
</script>

<style scoped>

</style>
