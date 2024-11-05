<template>
    <div>
        <!-- Form Gösterimi -->
        <form @submit.prevent="submitForm">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Kurumsal Kiralama') }}</h3>
                </div>

                <div class="card-body">
                    <div class="row mt-2">
                        <div>
                            <input class="form-control form-control-lg" type="file" @change="previewImage"
                                accept="image/*" />
                            <span class="badge badge-info mt-2">Yüklenen resim formatı .jpg, .png, .tif, .bmp
                                olabilir.</span>
                        </div>
                        <img :src="getImageSrc(imageUrl, 'tr')" alt="Preview" class="img-thumbnail" />
                        <input-error :message="form.errors.file" class="mt-2" />
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.content_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.content_en" :config="editorConfig"></ckeditor>
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
    props: ["institutional"],
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
                content_tr: "",
                content_en: "",
                file: null,
            }),

            existingContent: null,
        };
    },
    created() {
        if (this.institutional && this.institutional.data.length > 0) {
            this.existingContent = JSON.parse(this.institutional.data[0].content);
            this.existingUrl = this.institutional.data[0].image;


            this.form.content_tr = this.existingContent.tr || "";
            this.form.content_en = this.existingContent.en || "";
            this.form.file = this.existingUrl || "";
            this.imageUrl = this.existingUrl || "";
            this.form.id = this.institutional.data[0].id;
        }
    },
    methods: {
        getImageSrc(url, lang) {

return url.startsWith('blob') ? url : '/uploads/' + url;
},

        previewImage(event) {
            this.imageUrl = URL.createObjectURL(event.target.files[0]);
            this.form.file = event.target.files[0];
        },

        async submitForm() {
            console.log(this.form)
            try {


                if (this.form.id) {
                    await this.form.post(route("backend.institutional.update", this.form.id));
                } else {
                    await this.form.post(route("backend.institutional.create"));
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
