<template>
    <div>
        <!--begin::Content-->
        <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
            <!--begin::Logo-->

            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="pt-lg-10 mb-10">
                <!--begin::Logo-->
                <h1 class="fw-bolder fs-2qx text-gray-800 mb-10">{{title}}</h1>
                <!--end::Logo-->
                <!--begin::Message-->
                <div class="fw-bold fs-3 text-muted mb-15">{{description}}</div>
                <!--end::Message-->
                <!--begin::Action-->
                <div class="text-center">
                    <button @click="goBack()" class="btn btn-lg btn-primary fw-bolder">Geri dön</button>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Illustration-->
            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(/backend/media/illustrations/sketchy-1/4.png"></div>
            <!--end::Illustration-->
        </div>


    </div>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";

export default {
    name:'Error',
    layout: AdminLayoutMaster,
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: '503: Service Unavailable',
                500: '500: Server Error',
                404: '404: Page Not Found',
                403: 'Erişim izni yok',
            }[this.status]
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, you are forbidden from accessing this page.',
                403: 'Üzgünüm bu işlemi yapabilmek için izniniz bulunmuyor.',
            }[this.status]
        },
    },
    methods:{
        goBack(){
            return window.history.back();
        }
    }

}
</script>
