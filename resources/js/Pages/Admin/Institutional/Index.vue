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
                        <div class="col-lg-6">
                            <p>Türkçe içerikli resim eklemek için:</p>
                            <input class="form-control form-control-lg" type="file" @change="previewImage($event, 'tr')"
                                accept="image/*" />
                            <span class="badge badge-info mt-2">Yüklenen resim formatı .jpg, .png, .tif, .bmp
                                olabilir.</span>
                            <img :src="imageUrl_tr ? getImageSrc(imageUrl_tr, 'tr') : ''" alt="Preview"
                                class="img-thumbnail" />
                            <input-error :message="form.errors.file_tr" class="mt-2" />
                        </div>
                        <div class="col-lg-6">
                            <p>İngilizce içerikli resim eklemek için:</p>
                            <input class="form-control form-control-lg" type="file" @change="previewImage($event, 'en')"
                                accept="image/*" />
                            <span class="badge badge-info mt-2">Yüklenen resim formatı .jpg, .png, .tif, .bmp
                                olabilir.</span>
                            <img :src="imageUrl_en ? getImageSrc(imageUrl_en, 'en') : ''" alt="Preview"
                                class="img-thumbnail" />
                            <input-error :message="form.errors.file_en" class="mt-2" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <p>Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.content_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p>İngilizce içerik eklemek için:</p>
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
        <Modal :isOpen="isModalOpen" @close="closeModal">
            <div>{{ textMessage }}</div>
        </Modal>
    </div>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import { useForm } from "@inertiajs/inertia-vue3";
import { ClassicEditor, Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List } from 'ckeditor5';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import 'ckeditor5/ckeditor5.css';
import Modal from "@/Components/Modal";

export default {
    name: "Index",
    components: { Ckeditor, Modal },
    layout: AdminLayoutMaster,
    props: ["institutional"],
    data() {
        return {
            editor: ClassicEditor,
            textMessage: "",
            isModalOpen: false,
            editorConfig: {
                plugins: [Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List],
                toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'heading', 'link', 'bulletedList', 'numberedList'],
            },
            imageUrl_tr: null,
            imageUrl_en: null,
            form: useForm({
                id: null,
                content_tr: "",
                content_en: "",
                file_tr: null,
                file_en: null,
            }),
            existingContent: null,
        };
    },
    created() {
        if (this.institutional && this.institutional.data.length > 0) {
            this.existingContent = JSON.parse(this.institutional.data[0].content);
            const imageData = JSON.parse(this.institutional.data[0].image || "{}");
            this.imageUrl_tr = imageData.tr || "";  // For Turkish image
            this.imageUrl_en = imageData.en || "";
            this.form.content_tr = this.existingContent.tr || "";
            this.form.content_en = this.existingContent.en || "";
            this.form.file_tr = this.imageUrl_tr;
            this.form.file_en = this.imageUrl_en;
            this.form.id = this.institutional.data[0].id;
        }
    },
    methods: {
        closeModal() {
            this.isModalOpen = false;
        },
        getImageSrc(url, lang) {
            return url.startsWith('blob') ? url : '/uploads/' + url;
        },
        previewImage(event, lang) {
            const file = event.target.files[0];
            if (lang === 'tr') {
                this.imageUrl_tr = URL.createObjectURL(file);
                this.form.file_tr = file;
            } else if (lang === 'en') {
                this.imageUrl_en = URL.createObjectURL(file);
                this.form.file_en = file;
            }
        },
        async submitForm() {
            try {


                if (this.form.id) {
                    await this.form.post(route("backend.institutional.update", this.form.id)
                        , {


                            onSuccess: () => {
                                this.textMessage = "Bilgileriniz başarı ile değiştirildi!",
                                    this.isModalOpen = true;

                            },
                            onError: () => {
                                console.error("Update failed");
                            },
                        });
                } else {
                    await this.form.post(route("backend.institutional.create"), {


                        onSuccess: () => {
                            this.textMessage = "Bilgileriniz başarı ile kaydedildi!",
                                this.isModalOpen = true;

                        },
                        onError: () => {
                            console.error("Update failed");
                        },
                    });
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

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modals {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 500px;
    max-width: 100%;
}
</style>
