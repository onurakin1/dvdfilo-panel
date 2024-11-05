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
                            <p>Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.about_us_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p>İngilizce içerik eklemek için:</p>
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
                            <p>Türkçe içerik eklemek için:</p>
                            <ckeditor :editor="editor" v-model="form.our_services_tr" :config="editorConfig"></ckeditor>
                        </div>
                        <div class="col-lg-6">
                            <p>İngilizce içerik eklemek için:</p>
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

                            <p>Türkçe içerikli slider eklemek için:</p>
                            <input class="form-control" type="file" @change="previewSlider($event, 'tr')" multiple>

                            <div v-if="imageUrls.tr.length" class="mnb">
                                <div v-for="(url, index) in imageUrls.tr" :key="index" class="mt-2 first">
                                    <div class="d-flex" style="flex-direction: column;">
                                        <img :src="getImageSrc(url, 'tr')" alt="Preview" class="img-thumbnail" />
                                        <div @click="deleteImage('tr', index, url)" style="color: #000;"><span
                                                class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Deleted-file.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <title>Stockholm-icons / Files / Deleted-file</title>
                                                    <desc>Created with Sketch.</desc>
                                                    <defs />
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>Sil</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p>İngilizce içerikli slider eklemek için:</p>
                            <input class="form-control" type="file" @change="previewSlider($event, 'en')" multiple>
                            <div v-if="imageUrls.en.length" class="mnb">
                                <div v-for="(url, index) in imageUrls.en" :key="index" class="mt-2 first">
                                    <div class="d-flex" style="flex-direction: column;">
                                        <img :src="getImageSrc(url, 'en')" alt="Preview" class="img-thumbnail" />
                                        <div @click="deleteImage('en', index, url)" style="color: #000;"><span
                                                class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Deleted-file.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <title>Stockholm-icons / Files / Deleted-file</title>
                                                    <desc>Created with Sketch.</desc>
                                                    <defs />
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon--></span>Sil</div>
                                    </div>
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
                            <label>Türkçe Kampanya giriniz:</label>
                            <input class="form-control" type="text" v-model="form.tr_campaign"
                                placeholder="Türkçe Kampanya Giriniz" />
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>İngilizce Kampanya giriniz:</label>
                            <input class="form-control" type="text" v-model="form.en_campaign"
                                placeholder="İngilizce Kampanya Giriniz" />
                        </div>
                    </div>
                    <div v-for="(item, index) in form.carouselItems" :key="`carousel-item-${index}`" class="mb-4">
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <p>Resim:</p>
                                <input class="form-control" type="file" @change="onFileChange($event, index)" />
                                <div class="mnb">
                                    <div>
                                        <img v-if="item.previewUrl" :src="item.previewUrl" alt="Preview"
                                            class="img-thumbnail mt-2" />
                                    </div>

                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-4 form-group">
                                    <label>Türkçe için başlık giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeTitleTR"
                                        placeholder="Türkçe Başlık" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>İngilizce için başlık giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeTitleEN"
                                        placeholder="İngilizce Başlık" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label>Türkçe için açıklama giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgeDescTR"
                                        placeholder="Türkçe Açıklama" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>İngilizce için açıklama giriniz:</label>
                                    <textarea class="form-control" v-model="item.badgeDescEN"
                                        placeholder="İngilizce Açıklama"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 form-group">
                                    <label>Türkçe için Fiyat açıklaması giriniz:</label>
                                    <input class="form-control" type="text" v-model="item.badgePriceTR"
                                        placeholder="Türkçe Fiyat Açıklaması" />
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>İngilizce için Fiyat açıklaması giriniz:</label>
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
                            <p>Referans Eklemek için:</p>
                            <input class="form-control" type="file" @change="previewReferance($event, 'tr')" multiple>
                        </div>



                        <div v-if="refURL.length" class="mnb">
                            <div class="mt-2" v-for="(url, index) in refURL" :key="index">
                                <div class="d-flex" style="flex-direction: column;">
                                    <img :src="getRefSrc(url, 'tr')" alt="Preview" class="img-thumbnail" />
                                    <div @click="deleteRefImage(index, url)" style="color: #000;"><span
                                            class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Deleted-file.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <title>Stockholm-icons / Files / Deleted-file</title>
                                                <desc>Created with Sketch.</desc>
                                                <defs />
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path
                                                        d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path
                                                        d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z"
                                                        fill="#000000" />
                                                </g>
                                            </svg><!--end::Svg Icon--></span>Sil</div>
                                </div>

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
    props: ["contents"],
    data() {
        return {
            editor: ClassicEditor,
            textMessage: "",
            isModalOpen: false,
            editorConfig: {
                plugins: [Bold, Essentials, Italic, Mention, Paragraph, Undo, Underline, Heading, Link, List],
                toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'heading', 'link', 'bulletedList', 'numberedList'],
            },
            imageUrls: {
                tr: [],
                en: []
            },
            modalVisible: false,
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
        closeModal() {
            this.isModalOpen = false;
        },
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
                        this.textMessage = "Silme İşleminiz Başarılı!",
                            this.isModalOpen = true;
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
                        this.textMessage = "Silme İşleminiz Başarılı!",
                            this.isModalOpen = true;

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

            try {


                if (this.form.id) {
                    await this.form.post(route("backend.contents.update", this.form.id)
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
                    await this.form.post(route("backend.contents.create"), {


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

.mnb {
    display: flex;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 10px 20px;
    margin: 20px 0;
}

.mnb div {
    height: 130px;
    width: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    border-radius: 5px;
}




.second {
    background-color: blue;
}

.third {
    background-color: yellow;
    color: black;
}

@media screen and (max-width: 500px) {
    .mnb div {
        width: 70%;
        font-size: 20px;
    }
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
