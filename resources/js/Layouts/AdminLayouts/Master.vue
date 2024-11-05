<template>
             <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
                <!--begin::Aside-->
                <div id="kt_aside" class="aside app-bg aside-hoverable" data-kt-drawer="true"
                     data-kt-drawer-name="aside"
                     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                     data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
                     data-kt-drawer-toggle="#kt_aside_mobile_toggle">

                    <aside-logo/>
                    <aside-sidebar/>
                    <aside-footer/>

                </div>
                <!--end::Aside-->
                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <Header :user="auth.user"/>
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <Breadcrumb/>
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <transition name="page">

                                <div id="kt_content_container" v-show="contenttrigger" class="container-xxl">
                                    <slot/>
                                </div>
                            </transition>

                        </div>
                        <!--end::Container-->
                    </div>
                    <Footer/>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
</template>

<script>

import {Link} from '@inertiajs/inertia-vue3';
import AsideSidebar from "@/Layouts/AdminLayouts/Aside/Sidebar";
import Footer from "@/Layouts/AdminLayouts//Footer";
import AsideFooter from "@/Layouts/AdminLayouts/Aside/Footer";
import AsideLogo from "@/Layouts/AdminLayouts/Aside/Logo";
import Header from "@/Layouts/AdminLayouts/Header";
import Breadcrumb from "@/Layouts/AdminLayouts/Breadcrumb";

export default {
    props: ['auth'],
    components: {
        Breadcrumb,
        Header,
        Footer,
        AsideLogo,
        AsideFooter,
        AsideSidebar,
        Link,
    },
    data() {
        return {
            contenttrigger: false,
        }
    },
    mounted() {
        this.contenttrigger = true


        var body = document.body;
        document.body.className = document.body.className.replace("bg-app", "header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed");

    }

}
</script>
<style scope>

.page-enter-active,
.page-leave-active {
    transition: all .3s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}
.list-enter-active, .list-leave-active {
    transition: all .4s;
}

.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */
{
    opacity: 0;
    transform: translateY(50%);
}


.pageTrans-enter, .pageTrans-leave-active {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}

.pageTrans-enter-active, .pageTrans-leave-active {
    -webkit-transition: all .5s;
    transition: all .5s;
}


.nav-line-tabs .nav-item .nav-link.active, .nav-line-tabs .nav-item.show .nav-link, .nav-line-tabs .nav-item .nav-link:hover:not(.disabled){
    font-weight: 400;
    color: #000;
}

.nav-line-tabs .nav-item .nav-link.active{
    border-bottom: 2px solid #f9d003!important;
}

.tox.tox-silver-sink.tox-tinymce-aux{
    z-index:9999;
}

</style>
