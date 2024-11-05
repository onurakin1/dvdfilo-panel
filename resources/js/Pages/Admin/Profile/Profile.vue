<template>
    <!--begin::Entry-->
    <div class="d-flex  flex-column-fluid justify-content-center ">
            <div class="col-lg-6">
                <form-alert :success="flash.success"/>

                <!--begin::Container-->
                <div class="container">
                    <div class="card ">
                        <div class="card-header card-header-stretch">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#account">{{__('Profil Bilgileri')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#password">{{__('Şifre Değiştir')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="profileContent">
                                <div class="tab-pane fade show active" id="account" role="tabpanel">
                                    <account-information-form :user="user"/>
                                </div>

                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <PasswordChange/>
                                </div>
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
import UpdateAccountForm from "@/Pages/Admin/Profile/AccountInformationForm";
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import AccountInformationForm from "@/Pages/Admin/Profile/AccountInformationForm";
import FormAlert from "@/Components/FormAlert";
import PasswordChange from "@/Pages/Admin/Profile/PasswordChange";

export default {
    name: "Edit",
    layout: AdminLayoutMaster,
    props: ['user','flash'],
    components: {
        PasswordChange,
        FormAlert,
        AccountInformationForm,
        UpdateAccountForm,
        // UpdatePasswordForm,
    },
}
</script>

<style scoped>

</style>
