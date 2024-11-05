<template>

    <!--begin::Entry-->
    <div class="d-flex  flex-column-fluid justify-content-center ">
        <div class="col-lg-8">
            <form-alert :success="flash.success"/>
            <!--begin::Container-->
            <div class="container">
                <div class="card ">
                    <div class="card-header card-header-stretch">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#general">Genel Ayarlar</a>
                                </li>




                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="profileContent">
                            <general-settings :general="general"/>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
    </div>
    <!--end::Entry-->
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import FormAlert from "@/Components/FormAlert";
import GeneralSettings from "@/Pages/Admin/Setting/GeneralSettings";
import SocialSettings from "@/Pages/Admin/Setting/SocialSettings";
import SeoSettings from "@/Pages/Admin/Setting/SeoSettings";
import SmtpSettings from "@/Pages/Admin/Setting/SmtpSettings";
import TemplateSettings from "@/Pages/Admin/Setting/TemplateSettings";
import LanguageSettings from "@/Pages/Admin/Setting/LanguageSettings";
import HomepageSettings from "@/Pages/Admin/Setting/HomePageSettings";

export default {
    name: "Edit",
    components: {SmtpSettings, SeoSettings, SocialSettings, GeneralSettings,LanguageSettings,FormAlert,TemplateSettings,HomepageSettings},
    layout: AdminLayoutMaster,
    props: ['user', 'flash', 'general', 'seo', 'social', 'smtp','lang','template','homepage','formpage'],
}
</script>

<style scoped>

</style>
