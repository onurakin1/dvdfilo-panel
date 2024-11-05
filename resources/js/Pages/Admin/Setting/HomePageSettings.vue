<template>
    <div class="tab-pane fade  " id="homepage" role="tabpanel">
        <form @submit.prevent="update" class="form">
            <!--begin::Card body-->
            <div class="card-body  p-50">

{{ homepage }}
                <!--begin::Input group-->
                <div class="row mb-6" v-for="(item,index) in homepage" :key='index'>
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-bold fs-6 " :class="item.rules.search('required')"
                           :for="item.key">
                        {{ item.trans_label }}
                    </label>
                    <!--end::Label-->
                    <div class="col-lg-3 fv-row" v-if="item.type === 'select'">
                         <v-select
                                class="form-control form-control-solid"
                                :options="$page.props.menus"
                                :reduce='(item) => item.id'
                                label="trans_title"
                                v-model="homepageForm[item.key]"
                                :placeholder="__('pages.menu.choose_menu')"
                            >
                                <template v-slot:no-options>{{__('no_match_record')}}</template>
                            </v-select>
                        <input-error :message="homepageForm.errors[item.key]" class="mt-2"/>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary btn-sm" :disabled="homepageForm.processing">
                    <span class="indicator-label" v-if="!homepageForm.processing">{{__('button.save_changes')}}</span>
                    <span class="indicator-label" v-else> <span
                        class="spinner-border spinner-border-sm align-middle ms-2"></span> {{__('button.saving')}}
                    </span>
                </button>
            </div>
            <!--end::Actions-->
        </form>

    </div>
</template>


<script>
import {useForm} from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError'
import vSelect from "vue-select";


export default {
    name: "HomepageSettings",
    props: ['homepage'],
    components:{InputError,"v-select": vSelect},
    data() {
        return {
            homepageForm: this.$inertia.form({})
        }
    },
    mounted() {
        this.setFormData();
    },
    methods: {
        setFormData() {
            let formData = {};
            this.homepage.forEach(r => {
                formData[r.key] = parseInt(r.value);
            })
            this.homepageForm = useForm('homepageForm', formData)

        },
        update() {
            this.homepageForm.post(route('backend.settings.update'));
        }
    }
}
</script>

<style scoped>

</style>
