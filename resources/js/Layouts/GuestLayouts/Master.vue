<template>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
        >
            <!--begin::Content-->
            <div
                class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
            >
                <!--begin::Logo-->
                <Link href="/dvdfilo" class="mb-12">
                    <img
                        alt="Logo"
                        :src="$page.props.settings.site_logo.value"
                        class="w-375px"
                    />
                </Link>
                <!--end::Logo-->
                <slot />
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Main-->
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    mounted() {
        var body = document.body;
        body.classList.add("bg-app");
        document.body.className = document.body.className.replace(
            "header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed",
            ""
        );
    },
};
</script>
<style>
.bg-dark {
    background: url("/backend/media/login_bg.jpg") no-repeat center center;
    background-size: cover;
}
</style>
