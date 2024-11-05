<template>
    <Head title="Parolanızı mı unuttunuz ?"/>

    <!--begin::Wrapper-->
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <!--begin::Form-->
        <form class="form w-100" @submit.prevent="submit">
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Link-->
                <div class="text-gray-400 fw-bold fs-4">Parolanızı sıfırlamak için e-posta adresinizi girin.
                </div>
                <!--end::Link-->

                <div v-if="status" class="alert alert-success d-flex align-items-center text-start p-5 mb-10 mt-10">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3"
                                      d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                      fill="black"></path>
                                <path
                                    d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
                                    fill="black"></path>
                            </svg>
					</span>
                    <!--end::Svg Icon-->
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-success">Parola sıfırlama talimatları e-posta adresinize gönderildi.</h4>
                        <span>{{ status }}</span>
                    </div>
                </div>

            </div>
            <!--begin::Heading-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <label class="form-label fw-bolder text-gray-900 fs-6">E-Posta</label>
                <input class="form-control form-control-solid" type="email" placeholder="" name="email"
                       autocomplete="off"
                       :class="{'is-invalid':form.errors.email}"
                       required autofocus
                       v-model="form.email"
                />
                <InputError :message="form.errors.email"/>

            </div>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" class="btn btn-lg btn-primary fw-bolder me-4" :disabled="form.processing">
                    <span class="indicator-label" v-if="!form.processing">Yeni Parola İste</span>
                    <span class="indicator-label" v-else>Gönderiliyor...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <Link :href="route('login')" class="btn btn-lg btn-light-primary fw-bolder" :class="{'disabled':form.processing}">Vazgeç
                </Link>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayouts/Master.vue'
import InputError from "@/Components/InputError";
import {Head,Link} from '@inertiajs/inertia-vue3';

export default {
    layout: GuestLayout,
    components: {
        InputError,
        Head,Link
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
