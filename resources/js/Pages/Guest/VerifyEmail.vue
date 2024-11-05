<template>
    <Head title="Email Verification" />

    <!--begin::Wrapper-->
    <div class="pt-lg-10 mb-10">
        <!--begin::Logo-->
        <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Your Email</h1>
        <!--end::Logo-->
        <!--begin::Message-->
        <div class="fs-3 fw-bold text-muted mb-10">We have sent an email to
            <a href="#" class="link-primary fw-bolder">max@keenthemes.com</a>
            <br />pelase follow a link to verify your email.</div>
        <!--end::Message-->
        <!--begin::Action-->
        <div class="text-center mb-10">
            <a href="../../demo1/dist/authentication/flows/basic/sign-in.html" class="btn btn-lg btn-primary fw-bolder">Skip for now</a>
        </div>
        <!--end::Action-->
        <!--begin::Action-->
        <div class="fs-5">
            <span class="fw-bold text-gray-700">Did’t receive an email?</span>
            <a href="../../demo1/dist/authentication/flows/basic/sign-up.html" class="link-primary fw-bolder">Resend</a>
        </div>
        <!--end::Action-->
    </div>
    <!--end::Wrapper-->
    <!--begin::Illustration-->
    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/illustrations/sketchy-1/17.png"></div>
    <!--end::Illustration-->

    <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
        A new verification link has been sent to the email address you provided during registration.
    </div>

    <form @submit.prevent="submit">
        <div class="mt-4 flex items-center justify-between">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Resend Verification Email
            </BreezeButton>

            <Link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Log Out</Link>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/GuestLayouts/Master.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,
    components: {
        BreezeButton,
        Head,
        Link,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
}
</script>
