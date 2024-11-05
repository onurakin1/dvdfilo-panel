<template>
    <div>
        <!-- Form Gösterimi -->
        <form @submit.prevent="submitForm">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Sözleşmeler') }}</h3>
                </div>

                <div class="card-body">

                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe aydınlatma metni eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.clarification_text_tr" :config="editorConfig"></ckeditor>
                        </div>

                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce aydınlatma metni eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.clarification_text_en" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe gizlilik poltikamız eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.our_privacy_policy_tr" :config="editorConfig"></ckeditor>
                        </div>

                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce gizlilik poltikamız eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.our_privacy_policy_en" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold" >Türkçe gizlilik poltikası eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.privacy_policy_tr" :config="editorConfig"></ckeditor>
                        </div>

                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce gizlilik poltikası eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.privacy_policy_en" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3">
                    {{ form.id ? __('Güncelle') : __('Kaydet') }}
                </button>
            </div>
        </form>


    </div>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import { useForm } from "@inertiajs/inertia-vue3";
import { ClassicEditor, Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List } from 'ckeditor5';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import 'ckeditor5/ckeditor5.css';

export default {
    name: "Index",
    components: { Ckeditor },
    layout: AdminLayoutMaster,
    props: ["contract"],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                plugins: [Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List],
                toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'heading', 'link', 'bulletedList', 'numberedList'],
            },
            imageUrl: null,
            form: useForm({
                id: null,
       
                clarification_text_en: '',
                clarification_text_tr: '',
                our_privacy_policy_en: '',
                our_privacy_policy_tr: '',
                privacy_policy_tr: '',
                privacy_policy_en: '',
            }),

            existingContent: null,
        };
    },
    created() {
        if (this.contract && this.contract.data.length > 0) {
            this.existingClarification = JSON.parse(this.contract.data[0].clarification_text);
            this.existingOurPolicy = JSON.parse(this.contract.data[0].our_privacy_policy);
            this.existingPolicy = JSON.parse(this.contract.data[0].privacy_policy);


            this.form.clarification_text_tr = this.existingClarification.tr || "";
            this.form.clarification_text_en = this.existingClarification.en || "";
            this.form.our_privacy_policy_tr = this.existingOurPolicy.tr || "";
            this.form.our_privacy_policy_en = this.existingOurPolicy.en || "";
            this.form.privacy_policy_tr = this.existingPolicy.tr || "";
            this.form.privacy_policy_en = this.existingPolicy.en || "";
            this.form.id = this.contract.data[0].id;
        }
    },
    methods: {
   
        async submitForm() {
            console.log(this.form)
            try {


                if (this.form.id) {
                    await this.form.post(route("backend.contract.update", this.form.id));
                } else {
                    await this.form.post(route("backend.contract.create"));
                }
            } catch (error) {
                console.error("Form submission failed:", error);
            }
        },
    },
};
</script>

<style scoped>
.card-custom {
    margin-bottom: 20px;
}

.img-thumbnail {
    max-width: 100px;
    margin-top: 10px;
}
</style>
