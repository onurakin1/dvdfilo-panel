<template>
    <Head title="Giriş Yap"/>

    <!--begin::Wrapper-->
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <!--begin::Form-->
        <form class="form w-100" @submit.prevent="submit">
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label fs-6 fw-bolder text-dark">Kullanıcı adı yada e-posta adresi</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input class="form-control form-control-lg form-control-solid"
                       type="text"
                       name="email"
                       v-model="form.email"
                       :class="{'is-invalid':form.errors.email}"
                       autocomplete="off"/>
                <input-error :message="form.errors.email" class="mt-2"/>

                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-2">
                    <!--begin::Label-->
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Parola</label>
                    <!--end::Label-->

                </div>
                <!--end::Wrapper-->
                <!--begin::Input-->
                <input class="form-control form-control-lg form-control-solid" type="password"
                       name="password"
                       v-model="form.password"
                       :class="{'is-invalid':form.errors.password}"
                       autocomplete="off"/>
                <input-error :message="form.errors.password" class="mt-2"/>
                <!--begin::Link-->
                <Link :href="route('password.request')"
                      class="link-primary fs-6 fw-bolder mt-2" style="float:right">Parolanızı mı unuttunuz ?
                </Link>
                <!--end::Link-->
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="remember_me" :value="true"
                           v-model="form.remember"
                    >
                    <span class="form-check-label fw-bold text-gray-700 fs-6"> Beni hatırla</span>
                </label>
            </div>
            <!--begin::Actions-->
            <div class="text-center">
                <!--begin::Submit button-->
                <button type="submit" class="btn btn-lg btn-primary w-100 mb-5"
                        :disabled="form.processing">
                    <span class="indicator-label" v-if="!form.processing">Giriş</span>
                    <span class="indicator-label" v-else> <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span> Giriş yapılıyor...

                    </span>
                </button>


                <!--end::Submit button-->
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayouts/Master.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import InputError from "@/Components/InputError";

export default {
    layout: GuestLayout,
    components: {
        Head,
        Link,
        InputError
    },
    props: {
        canResetPassword: Boolean,
        status: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            }),
            title: window.document.getElementsByTagName('title')[0]?.innerText
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
                onSuccess: () => window.location.href = '/dvdfilo'
            });
        }
    }
}
</script>
