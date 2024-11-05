<template>
    <div class="aside-menu flex-column-fluid">
        <div
            class="hover-scroll-overlay-y my-5 my-lg-5"
            id="kt_aside_menu_wrapper"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0"
        >
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.dashboard')"
                        :class="{
                            active: current_route === 'backend.dashboard',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{ __("Anasayfa") }}</span>
                    </Link>
                </div>
            </div>
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.brands')"
                        :class="{
                            active: current_route === 'backend.brands',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("Markalar")
                        }}</span>
                    </Link>
                </div>
            </div>
       
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.carModels')"
                        :class="{
                            active:
                                current_route ===
                                'backend.carModels',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("Araba Modelleri")
                        }}</span>
                    </Link>
                </div>
            </div>
            
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.getOffers')"
                        :class="{
                            active:
                                current_route ===
                                'backend.getOffers',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("Tekliflerim")
                        }}</span>
                    </Link>
                </div>
            </div>
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.contents')"
                        :class="{
                            active:
                                current_route ===
                                'backend.contents',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("İçerikler")
                        }}</span>
                    </Link>
                </div>
            </div>
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.institutional')"
                        :class="{
                            active:
                                current_route ===
                                'backend.institutional',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("Kurumsal Kiralama")
                        }}</span>
                    </Link>
                </div>
            </div>
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu"
                data-kt-menu="true"
            >
                <div class="menu-item">
                    <Link
                        class="menu-link"
                        :href="route('backend.contract')"
                        :class="{
                            active:
                                current_route ===
                                'backend.contract',
                        }"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <rect
                                        x="2"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="2"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="13"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                    <rect
                                        opacity="0.3"
                                        x="2"
                                        y="13"
                                        width="9"
                                        height="9"
                                        rx="2"
                                        fill="black"
                                    />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">{{
                            __("Sözleşmeler")
                        }}</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <div
        class="aside-footer flex-column-auto pt-5 pb-7 px-5"
        id="kt_aside_footer"
    >
        <div class="d-flex justify-content-center">
            <Link
                class="me-3"
                style="text-align: center"
                method="post"
                :href="route('logout')"
            >
                <span class="text-white">
                    <i class="la la-power-off fs-3x cursor-pointer"></i>
                    <br /><span class="fs-7">Cıkış Yap</span>
                </span>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Menu from "@/Helper/Menu";

const SVGInjector = require("svg-injector-2");

export default {
    name: "Sidebar",
    components: { Link },
    data() {
        return {
            current_route: "",
        };
    },
    computed: {
        list() {
            // console.log(Menu.list)
            // return Menu.list ?? [];
        },
    },
    mounted() {
        this.current_route = this.route().current();
        let self = this;
        Inertia.on("finish", (event) => {
            if (event.detail.visit.completed) {
                self.current_route = self.route().current();
            }
        });
        new SVGInjector().inject(document.querySelectorAll("svg[data-src]"));
    },
};
</script>

<style scoped></style>
