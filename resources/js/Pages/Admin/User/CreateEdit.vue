<template>
    <div class="row">
        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ title }}</span>
                    </h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div class="card-body py-3">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <label for="username"
                                       class="required form-label">{{ __('pages.user.username') }}</label>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    v-model="form.username"
                                    :class="{'is-invalid':form.errors.username}"
                                    class="form-control form-control-solid"
                                    :placeholder="__('pages.user.username_placeholder')"
                                />
                                <input-error :message="form.errors.username" class="mt-2"/>
                            </div>
                            <div class="mb-6">
                                <label for="email" class="required form-label">{{ __('pages.user.email') }}</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    v-model="form.email"
                                    :class="{'is-invalid':form.errors.email}"
                                    class="form-control form-control-solid"
                                    :placeholder="__('pages.user.email_placeholder')"
                                />
                                <input-error :message="form.errors.email" class="mt-2"/>
                            </div>

                            <div class="mb-6">
                                <label for="first_name" class="form-label">{{ __('pages.user.name') }}</label>
                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    v-model="form.first_name"
                                    :class="{'is-invalid':form.errors.first_name}"
                                    class="form-control form-control-solid"
                                    :placeholder="__('pages.user.name_placeholder')"
                                />
                                <input-error :message="form.errors.first_name" class="mt-2"/>
                            </div>

                            <div class="mb-6">
                                <label for="last_name" class="form-label">{{ __('pages.user.surname') }}</label>
                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    v-model="form.last_name"
                                    :class="{'is-invalid':form.errors.last_name}"
                                    class="form-control form-control-solid"
                                    :placeholder="__('pages.user.surname_placeholder')"
                                />
                                <input-error :message="form.errors.last_name" class="mt-2"/>
                            </div>

                            <div class="mb-6">
                                <label for="password" class="form-label">{{ __('pages.user.password') }}</label>
                                <div class="input-group input-group-solid mb-2">
                                    <input :type="password_show ? 'text':'password'" id="password"
                                           v-model="form.password"
                                           class="form-control" :placeholder="__('pages.user.password_placeholder')"
                                           autocomplete="new-password">
                                    <span class="btn btn-light" @click="password_show=true" v-if="!password_show"><i
                                        class="far fa-eye"/></span>
                                    <span class="btn btn-light" @click="password_show=false" v-else><i
                                        class="far fa-eye-slash"/></span>
                                    <span class="btn btn-light"
                                          @click="generatePassword()">{{ __('pages.user.password_create') }}</span>
                                </div>
                                <div class="fs-7 fw-bold text-muted mb-5" v-if="user">
                                    <i class="fa fa-info-circle"/> {{ __('pages.user.password_description') }}
                                </div>
                                <input-error :message="form.errors.password" class="mt-2"/>
                            </div>
                            <div class="mb-6 d-flex flex-wrap" >
                                <div class="form-check form-check-custom form-check-solid mb-4 col-6" v-for="role in roles">
                                    <input class="form-check-input" type="checkbox" v-model="form.roles" :value="role.name" :id="role.id"/>
                                    <label class="form-check-label" :for="role.id">
                                        {{ role.name }}
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 text-right">
                                <Link :href="route('backend.users.index')" class="btn btn-light btn-sm me-3">
                                    <i class="bi bi-arrow-left"></i> {{ __('button.cancel') }}
                                </Link>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check2"></i> {{ __('button.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <!--begin::Body-->
            </div>
        </div>
    </div>

</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import GeneralHelper from '@/Helper/General';
import InputError from "@/Components/InputError";
import {Link} from '@inertiajs/inertia-vue3'

export default {
    name: "CreateEdit",
    components: {InputError, Link},
    layout: AdminLayoutMaster,
    props: ['user', 'roles'],
    data() {
        return {
            title: this.user ? this.user.username + ' ' + this.__('pages.user.edit_user') : this.__('pages.user.new_user'),
            password_show: false,
            form: this.$inertia.form({
                username: "",
                email: "",
                first_name: "",
                last_name: "",
                password: "",
                roles: [],
                level: 3
            }),
        }
    },
    methods: {
        generatePassword() {
            this.password_show = true;
            this.form.password = GeneralHelper.generatePassword(3, 3, 3, 3);
        },
        submit() {
            let method = this.user ? 'put' : 'post'
            let routeUrl = this.user ? route('backend.users.update', this.user) : route('backend.users.store');

            this.form.submit(method, routeUrl);
        },
        role(level) {
            return this.__(GeneralHelper.role(level));
        },
        getUser() {
            let self = this;
            if (!this.user) {
                return false;
            }
            this.form.username = this.user.username;
            this.form.email = this.user.email;
            this.form.first_name = this.user.first_name;
            this.form.last_name = this.user.last_name;
            this.form.level = parseInt(this.user.level);
            this.user.roles.forEach(function(r){
                self.form.roles.push(r.name);
            })
        },
    },
    mounted() {
        this.getUser();

    }

}
</script>

<style scoped>

</style>
