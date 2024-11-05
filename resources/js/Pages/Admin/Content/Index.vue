<template>
    <div>
        <!-- Form Gösterimi -->
        <form @submit.prevent="submitForm">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Hakkımızda') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.about_us_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.about_us_en" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Servislerimiz') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.our_services_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.our_services_en" :config="editorConfig"></ckeditor>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Ana Sliderlar') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">Türkçe slider eklemek için:</p>
                            <input class="form-control" type="file" @change="previewSlider($event, 'tr')" multiple>

                            <div v-if="imageUrls.tr.length">
                                <div v-for="(url, index) in imageUrls.tr" :key="index" class="mt-2">
                                    <img :src="getImageSrc(url, 'tr')" alt="Preview" class="img-thumbnail" />
                                    <div @click="deleteImage('tr', index, url)" class="btn btn-danger mt-1">Sil</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-3 font-weight-bold">İngilizce slider eklemek için:</p>
                            <input class="form-control" type="file" @change="previewSlider($event, 'en')" multiple>
                            <div v-if="imageUrls.en.length">
                                <div v-for="(url, index) in imageUrls.en" :key="index" class="mt-2">
                                    <img :src="getImageSrc(url, 'en')" alt="Preview" class="img-thumbnail" />
                                    <div @click="deleteImage('en', index, url)" class="btn btn-danger mt-1">Sil</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Alt Slider Alanı') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 form-group">
                            <label class="mb-3 font-weight-bold">Türkçe Kampanya giriniz:</label>
                            <input class="form-control" type="text" v-model="form.tr_campaign"
                                placeholder="Türkçe Kampanya Giriniz" />
                        </div>
                        <div class="col-lg-4 form-group">
                            <label class="mb-3 font-weight-bold">İngilizce Kampanya giriniz:</label>
                            <input class="form-control" type="text" v-model="form.en_campaign"
                                placeholder="İngilizce Kampanya Giriniz" />
                        </div>
                    </div>
                    <div v-for="(item, index) in form.carouselItems" :key="`carousel-item-${index}`" class="mb-4">
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <p class="mb-3 font-weight-bold">Resim:</p>
                                <input class="form-control" type="file" @change="onFileChange($event, index)" />
                                <img v-if="item.previewUrl" :src="item.previewUrl" alt="Preview"
                                    class="img-thumbnail mt-2" />
                            </div>
                            <div class="row">

                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">Türkçe için başlık giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeTitleTR"
                                        placeholder="Türkçe Başlık" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">İngilizce için başlık giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeTitleEN"
                                        placeholder="İngilizce Başlık" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">Türkçe için açıklama giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeDescTR"
                                        placeholder="Türkçe Açıklama" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">İngilizce için açıklama giriniz:</label>
                                    <textarea class="form-control" v-model="item.badgeDescEN"
                                        placeholder="İngilizce Açıklama"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">Türkçe için Fiyat açıklaması giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgePriceTR"
                                        placeholder="Türkçe Fiyat Açıklaması" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label class="mb-3 font-weight-bold">İngilizce için Fiyat açıklaması giriniz:</label>
                                    <textarea class="form-control" v-model="item.badgePriceEN"
                                        placeholder="İngilizce Fiyat Açıklaması"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <div class="btn btn-danger mt-2" @click="removeCarouselItem(index)">
                                {{ __('Sil') }}
                            </div>
                        </div>

                        <hr />
                    </div>

                    <div class="btn btn-primary" @click="addCarouselItem">
                        {{ __('Yeni Alan Ekle') }}
                    </div>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Referanslar') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="mb-3 font-weight-bold">Referans Eklemek için:</p>
                            <input class="form-control" type="file" @change="previewReferance($event, 'tr')" multiple>
                        </div>



                        <div v-if="refURL.length" class="row">
                            <div class="col-lg-3 mt-2" v-for="(url, index) in refURL" :key="index">
                                <img :src="getRefSrc(url, 'tr')" alt="Preview" class="img-thumbnail" />
                                <div @click="deleteRefImage(index, url)" class="btn btn-danger mt-1">Sil</div>
                            </div>

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
    props: ["contents"],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                plugins: [Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List],
                toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'heading', 'link', 'bulletedList', 'numberedList'],
            },
            imageUrls: {
                tr: [],
                en: []
            },
            refURL: [],
            form: useForm({
                id: null,
                about_us_tr: "",
                about_us_en: "",
                our_services_tr: "",
                our_services_en: "",
                slider_tr: [],
                slider_en: [],
                ref: [],
                en_campaign: "",
                tr_campaign: "",
                carouselItems: [{ slide: null, previewUrl: '' }],
                references: [{ reference: null, previewReferences: '' }],
            }),

            existingContent: null,
        };
    },
    created() {
        if (this.contents && this.contents.data.length > 0) {
            this.existingContent = JSON.parse(this.contents.data[0].about_us);
            this.existingContentOurServices = JSON.parse(this.contents.data[0].our_services);
            this.existingContentMainSlider = JSON.parse(this.contents.data[0].main_slider);
            this.existingContentSlider = JSON.parse(this.contents.data[0].slider);
            this.existingContentReference = JSON.parse(this.contents.data[0].reference);
            console.log(this.existingContentReference)
            this.form.en_campaign = this.existingContentSlider.campaign.en;
            this.form.tr_campaign = this.existingContentSlider.campaign.tr;
            this.form.carouselItems = this.existingContentSlider.data.map(item => ({
                ...item,
                previewUrl: item.slide ? `/uploads/${item.slide}` : '', // Set preview URL if image exists
                badgeTitleTR: item.tr.title,
                badgePriceTR: item.tr.price,
                badgeDescTR: item.tr.desc,
                badgeTitleEN: item.en.title,
                badgePriceEN: item.en.price,
                badgeDescEN: item.en.desc
            }));


            this.form.about_us_tr = this.existingContent.tr || "";
            this.form.about_us_en = this.existingContent.en || "";
            this.form.our_services_tr = this.existingContentOurServices.tr || "";
            this.form.our_services_en = this.existingContentOurServices.en || "";
            this.imageUrls.tr = this.existingContentMainSlider.tr || [];
            this.imageUrls.en = this.existingContentMainSlider.en || [];
            this.refURL = this.existingContentReference || [];
            this.form.ref = this.existingContentReference || [];
            this.form.slider_tr = this.existingContentMainSlider.tr || [];
            this.form.slider_en = this.existingContentMainSlider.en || [];
            this.form.id = this.contents.data[0].id;
        }
    },
    methods: {
        async deleteImage(language, index, url) {
            // Remove image locally for immediate feedback
            this.imageUrls[language].splice(index, 1);

            try {
                await this.$inertia.delete(route("backend.contents.delete", { id: this.form.id }), {
                    preserveState: true,
                    data: {
                        language: language,
                        imageUrl: url
                    },
                    onSuccess: () => {
                        console.log("Image deleted successfully");
                    },
                    onError: () => {
                        console.error("Delete failed");
                    },
                });
            } catch (error) {
                console.error("Delete request error:", error);
            }
        },
        async deleteRefImage(index, url) {
            // Remove image locally for immediate feedback
            this.refURL.splice(index, 1);

            try {
                await this.$inertia.delete(route("backend.contents.refdelete", { id: this.form.id }), {
                    preserveState: true,
                    data: {

                        imageUrl: url
                    },
                    onSuccess: () => {
                        console.log("Image deleted successfully");
                    },
                    onError: () => {
                        console.error("Delete failed");
                    },
                });
            } catch (error) {
                console.error("Delete request error:", error);
            }
        },
        previewSlider(event, lang) {
            const files = event.target.files;
            this.form[`slider_${lang}`] = event.target.files;
            this.imageUrls[lang] = []; // Reset previous image URLs
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageUrls[lang].push(e.target.result); // Add the base64 URL
                };
                reader.readAsDataURL(file);
            }
        },
        previewReferance(event, lang) {
            const files = event.target.files;
            this.form[`ref`] = event.target.files;
            this.refURL = []; // Reset previous image URLs
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.refURL.push(e.target.result); // Add the base64 URL
                };
                reader.readAsDataURL(file);
            }
        },
        getRefSrc(url, lang) {

            return url.startsWith('data:image') ? url : '/uploads/' + url;
        },
        getImageSrc(url, lang) {

            return url.startsWith('data:image') ? url : '/uploads/' + url;
        },

        async onFileChange(event, index) {
            const file = event.target.files[0]; // Get the first file
            if (file) {
                // Create preview URL for new upload
                this.form.carouselItems[index].previewUrl = URL.createObjectURL(file);
                this.form.carouselItems[index].slide = file;
            } else {
                // If no new file, keep the existing preview URL
                this.form.carouselItems[index].previewUrl = `/uploads/${this.form.carouselItems[index].slide}`;
            }
        },


        addCarouselItem() {
            this.form.carouselItems = [...this.form.carouselItems, { slide: null, badgeTitleTR: "", badgePriceTR: "", badgeTitleEN: "", badgePriceEN: "", badgeDescTR: "", badgeDescEN: "" }];
        },
        removeCarouselItem(index) {
            this.form.carouselItems.splice(index, 1);
        },

        // resetForm() {
        //     this.form.reset();
        //     this.imageUrls = { tr: [], en: [] };
        // },
        async convertFileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
            });
        },
        async submitForm() {
            console.log(this.form)
            try {


                if (this.form.id) {
                    await this.form.post(route("backend.contents.update", this.form.id));
                } else {
                    await this.form.post(route("backend.contents.create"));
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
