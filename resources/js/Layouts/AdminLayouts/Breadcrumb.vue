<template>
    <Head :title="title"/>
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div
                data-kt-swapper="true"
                data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0"
            >
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                    {{ breadcrumbs.title }}
                </h1>
                <!--end::Title-->
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <!--end::Separator-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <template v-for="bread in breadcrumbs.childs">
                        <!--begin::Item-->
                        <li
                            class="breadcrumb-item"
                            :class="{
                'text-muted': !bread.status,
                'text-dark': bread.status,
              }"
                            v-if="!bread.status"
                        >
                            <Link :href="bread.route" class="text-muted text-hover-primary">{{
                                    bread.name
                                }}
                            </Link>
                        </li>
                        <li
                            class="breadcrumb-item"
                            :class="{
                'text-muted': !bread.status,
                'text-dark': bread.status,
              }"
                            v-else
                        >
                            {{ bread.name }}
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item" v-if="!bread.status">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                    </template>
                </ul>
                <!--end::Breadcrumb-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
</template>

<script>
import {Link, Head} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Breadcrumb",
    components: {Link, Head},
    data() {
        return {
            breadcrumbs: {
                title: "",
                childs: [],
            },
        };
    },
    methods: {
        setBreadcrumb() {
            let self = this;
            let current_route = this.route().current();

            let title = this.__("Anasayfa");
            let breadcrumbs = [
                {
                    name: '',
                    route: route("backend.dashboard"),
                    status: "active",
                },
            ];

            switch (current_route) {
                case "backend.users.create":
                case "backend.users.edit":
                case "backend.users.index":
                    breadcrumbs.forEach((d) => (d.status = ""));
                    title = this.__("bread.users.all_users");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.users.index"),
                        status: "",
                    });

                    if (current_route === "backend.users.create") {
                        title = this.__("bread.users.add_user");

                        breadcrumbs.push({
                            name: title,
                            route: route("backend.users.create"),
                            status: "active",
                        });
                    }

                    if (current_route === "backend.users.edit") {
                        title = this.__("bread.users.edit_user");

                        breadcrumbs.push({
                            name: self.$page.props.user.username,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    break;
                case "backend.pages.create":
                case "backend.pages.edit":
                case "backend.pages.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.pages.all_pages");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.pages.index"),
                        status: current_route === "backend.pages.index" ? "active" : "",
                    });

                    if (current_route === "backend.pages.create") {
                        title = this.__("bread.pages.add_page");

                        breadcrumbs.push({
                            name: title,
                            route: route("backend.pages.create"),
                            status: "active",
                        });
                    }

                    if (current_route === "backend.pages.edit") {
                        title = this.__("bread.pages.edit_page");

                        breadcrumbs.push({
                            name: self.$page.props.page.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    break;
                case "backend.posts.edit":
                case "backend.posts.create":
                case "backend.posts.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.posts.all_posts");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.posts.index"),
                        status: current_route === "backend.posts.index" ? "active" : "",
                    });

                    if (current_route === "backend.posts.create") {
                        title = this.__("bread.posts.add_post");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.posts.edit") {
                        title = this.__("bread.posts.edit_post");

                        breadcrumbs.push({
                            name: self.$page.props.post.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }


                    break;

                case "backend.products.edit":
                case "backend.products.create":
                case "backend.products.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("Ürünler");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.products.index"),
                        status: current_route === "backend.products.index" ? "active" : "",
                    });

                    if (current_route === "backend.products.create") {
                        title = this.__("Yeni Ürün Ekle");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.products.edit") {
                        title = this.__("Ürün Düzenle");

                        breadcrumbs.push({
                            name: self.$page.props.product.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }


                    break;
                case "backend.product-categories.edit":
                case "backend.product-categories.create":
                case "backend.product-categories.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("Ürün Kategorileri");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.product-categories.index"),
                        status: current_route === "backend.product-categories.index" ? "active" : "",
                    });

                    if (current_route === "backend.product-categories.create") {
                        title = this.__("Yeni Ürün Kategorisi Ekle");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.product-categories.edit") {
                        title = this.__("Ürün Kategorisi Düzenle");

                        breadcrumbs.push({
                            name: self.$page.props.category.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }


                    break;

                case "backend.categories.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.posts.categories");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.categories.index"),
                        status: "active",
                    });
                    break;
                case "backend.product-categories.order":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("Ürün Kategorileri Sıralama");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.product-categories.order"),
                        status: "active",
                    });
                    break;

                    case "backend.tv":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("Dijital Ekranlar");

                    breadcrumbs.push({
                        name: 'Anasayfa',
                        route: route("backend.dashboard"),
                        status: "",
                    });

                    breadcrumbs.push({
                        name: title,
                        route: "",
                        status: "active",
                    });
                    break;
                case "backend.logs":
                case "backend.logs.history-dashboard":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    breadcrumbs.push({
                            name: 'Log Kayıtları',
                            route: "",
                            status: "",
                        });

                        if (current_route === "backend.logs") {
                            title = this.__("Anlık Loglar");

                        breadcrumbs.push({
                            name: 'Log Kayıtları',
                            route: "",
                            status: "active",
                        });
                    }

                        if (current_route === "backend.logs.history-dashboard") {
                        title = this.__("Geçmiş Kayıtlar Raporu");

                        breadcrumbs.push({
                            name: 'Geçmiş Kayıtlar Raporu',
                            route: "",
                            status: "active",
                        });


                    }



                    break;


                case "backend.profile.edit":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.profile_info");

                    breadcrumbs.push({
                        name: title,
                        route: '',
                        status: "active",
                    });
                    break;
                case "backend.settings.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.settings.general_settings");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.settings.index"),
                        status: "active",
                    });
                    break;
                case "backend.menus.create":
                case "backend.menus.edit":
                case "backend.menus.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.settings.menu_manager");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.menus.index"),
                        status: current_route === "backend.posts.index" ? "active" : "",
                    });

                    if (current_route === "backend.menus.edit") {
                        title = this.__("bread.settings.menu_edit");

                        breadcrumbs.push({
                            name: self.$page.props.menu.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.menus.create") {
                        title = this.__("bread.menus.add_menu");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    break;
                case "backend.sliders.create":
                case "backend.sliders.edit":
                case "backend.sliders.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.sliders");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.sliders.index"),
                        status: current_route === "backend.sliders.index" ? "active" : "",
                    });

                    if (current_route === "backend.sliders.edit") {
                        title = this.__("bread.sliders.edit_slider");

                        breadcrumbs.push({
                            name: self.$page.props.slider.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.sliders.create") {
                        title = this.__("bread.sliders.add_slider");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    break;
                case "backend.galleries.create":
                case "backend.galleries.edit":
                case "backend.galleries.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("bread.galleries");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.galleries.index"),
                        status: current_route === "backend.galleries.index" ? "active" : "",
                    });

                    if (current_route === "backend.galleries.edit") {
                        title = this.__("bread.galleries.edit_gallery");

                        breadcrumbs.push({
                            name: self.$page.props.gallery.trans_title,
                            route: "",
                            status: "",
                        });

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    if (current_route === "backend.galleries.create") {
                        title = this.__("bread.galleries.add_gallery");

                        breadcrumbs.push({
                            name: title,
                            route: "",
                            status: "active",
                        });
                    }

                    break;

                case "backend.forms.index":
                    breadcrumbs.forEach((d) => (d.status = ""));

                    title = this.__("Formlar");

                    breadcrumbs.push({
                        name: title,
                        route: route("backend.forms.index"),
                        status:
                            current_route === "backend.forms.index" ? "active" : "",
                    });

                    break;
            }

            this.title = title;

            this.breadcrumbs = {title: title, childs: breadcrumbs};
        },
    },
    mounted() {
        let self = this;
        Inertia.on("finish", (event) => {
            if (event.detail.visit.completed) {
                self.setBreadcrumb();
            }
        });
    },
    created() {
        this.setBreadcrumb();
    },
};
</script>

<style scoped>
</style>
