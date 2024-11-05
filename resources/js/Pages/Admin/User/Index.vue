,<template>
    <form-alert :success="flash.success"/>

    <QuickTable :title="__('pages.user.users')" data-name="users" :data="users" :filter="{role:true,search:true}">
        <template #toolbar>
            <Link :href="route('backend.users.create')" class="btn btn-sm btn-light btn-active-primary">
                {{__('pages.user.new_user')}}
            </Link>
        </template>
        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-120px text-start w-25px">{{__('pages.user.id')}}</th>
                <th class="min-w-150px">{{__('pages.user.username')}}</th>
                <th class="min-w-140px">{{__('pages.user.name')}}</th>
                <th class="min-w-120px">{{__('pages.user.role')}}</th>
                <th class="min-w-120px">{{__('pages.user.posts')}}</th>
                <th class="min-w-120px w-150px text-start">{{__('pages.user.transactions')}}</th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(user,index) in users.data">
                <transition name="list">
                    <tr>
                        <td class="text-start">
                            #{{ user.id }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px me-5">
                                    <img :src="user.profile_photo_url" alt="">
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <Link :href="route('backend.users.edit',user)" class="text-dark fw-bolder text-hover-primary fs-6">{{
                                            user.username
                                        }}</Link>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{ user.email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <Link :href="route('backend.users.edit',user)" class="text-dark fw-bolder text-hover-primary d-block fs-6">
                                {{ user.first_name }} {{ user.last_name }}
                            </Link>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{ user.display_name }}</span>
                        </td>
                        <td>
                            {{ __(role(user.level)) }}
                        </td>
                        <td>
                            0
                        </td>
                        <td>
                            <Link :href="route('backend.users.edit',user)"
                                  class="btn btn-light-primary btn-sm me-3" data-bs-toggle="tooltip"
                                  data-bs-placement="top" title="Düzenle"><i class="fas fa-edit"></i></Link>
                            <button  @click="deleteData(index)" class="btn btn-light-danger btn-sm"
                                  data-bs-toggle="tooltip"
                                  data-bs-placement="top" :title="__('delete')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </transition>
            </template>
        </template>
    </QuickTable>

</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import Breadcrumb from "@/Layouts/AdminLayouts/Breadcrumb";
import QuickTable from "@/Components/QuickTable";
import GeneralHelper from '@/Helper/General';
import {Link} from '@inertiajs/inertia-vue3';
import FormAlert from "@/Components/FormAlert";


export default {
    name: "Index",
    components: {QuickTable, Breadcrumb, Link, FormAlert},
    layout: AdminLayoutMaster,
    props: ['users', 'flash'],
    data() {
        return {
            form: this.$inertia.form(),
        }
    },
    methods: {
        role(level) {
            return GeneralHelper.role(level);
        },
        async deleteData(index) {
            let item = this.users.data[index];
            let result = await this.$swal({
                title: this.__('alert.delete.title'),
                text: this.__('alert.delete.description'),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.__('alert.delete.approve'),
                cancelButtonText: this.__('alert.delete.cancel'),
            });

            if (result.isConfirmed) {
                this.form.delete(route("backend.users.destroy", item.id), {
                    onSuccess: () => {
                        this.$swal({
                            title: this.__('alert.delete.success_title'),
                            text: this.__('alert.delete.success_description'),
                            icon: "success",
                            confirmButtonText: this.__('alert.delete.close')
                        })
                        this.form.reset();
                    }
                })
            }
        },
    },
    mounted() {
    }
}
</script>
