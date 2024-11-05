<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >Baskı Deseni Oluştur</span
                        >
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3 pb-10">
                    <form class="form" @submit.prevent="uploadFile">
                        <div>
                            <div class="from-group mt-3">
                                <div v-if="!url">
                                    <input
                                        v-if="!project"
                                        class="form-control form-control-lg"
                                        type="file"
                                        @change="previewImage"
                                        accept="image/*"
                                    />
                                    <span v-if="!project" class="badge badge-info mt-2">Yüklenen resim formatı .jpg, .png, .tif, .bmp olabilir.</span>
                                </div>
                                <img
                                    v-if="imageUrl"
                                    :src="imageUrl"
                                    alt="Preview"
                                />

                                <img
                                    v-if="project"
                                    :src="project.main_image"
                                    alt="Preview"
                                />
                                <input-error
                                    :message="form.errors.file"
                                    class="mt-2"
                                />
                            </div>
                            <div class="form-group row mt-3 curso-pointer"  v-if="false">
                                <div class="col-12 col-form-label">
                                    <div class="checkbox-inline" >
                                        <label
                                            class="checkbox checkbox-success cursor-pointer"
                                        >
                                            <input
                                                type="checkbox"
                                                name="Checkboxes5"
                                                v-model="form.is_human"
                                                :checked="form.is_human"
                                                :disabled="project"
                                            />
                                            <span></span>
                                            Sadece boyutlandır
                                        </label>
                                    </div>
                                    <span class="form-text text-muted"
                                        >Bu seçenek model üretimi yapmaz.</span
                                    >
                                </div>
                            </div>
                            <div v-if="form.is_human == false">
                                <div class="form-group me-5 mt-3" v-if="false">
                                    <label>Tarak / Atkı</label>
                                    <select
                                        :disabled="project"
                                        class="form-control selectpicker"
                                        v-model="form.comboWeft"
                                        style="width: 170px"
                                    >
                                        <template
                                            v-for="combo in comboWefts"
                                            :key="combo"
                                        >
                                            <option
                                                :value="combo.id"
                                                :disabled="combo.disable"
                                            >
                                                {{ combo.name }}
                                            </option>
                                        </template>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Açıklama</label>
                                    <textarea
                                        :disabled="project"
                                        v-model="form.prompt"
                                        rows="4"
                                        class="form-control form-control-textarea"
                                        placeholder="Generate rug design, change design, use differents colors"
                                    />
                                    <input-error
                                        :message="form.errors.prompt"
                                        class="mt-2"
                                    />
                                </div>
                                <div class="form-group mt-3">
                                    <label>Pozitif Açıklama</label>
                                    <textarea
                                        :disabled="project"
                                        v-model="form.a_prompt"
                                        rows="3"
                                        class="form-control form-control-textarea"
                                        placeholder="Symmetrical shapes, symmetrical rug, symmetrical geometric motif, middle rug's flower  motif shapes"
                                    />
                                    <input-error
                                        :message="form.errors.a_prompt"
                                        class="mt-2"
                                    />
                                </div>
                                <div class="form-group mt-3">
                                    <label>Negatif Açıklama</label>
                                    <textarea
                                        :disabled="project"
                                        v-model="form.n_prompt"
                                        rows="3"
                                        class="form-control form-control-textarea"
                                        placeholder=" Bad symmetrical, bad Symmetrical Geometric carpet shapes, bad pixel,bad edge"
                                    />
                                    <input-error
                                        :message="form.errors.n_prompt"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button
                                v-if="!project"
                                type="submit"
                                class="btn btn-primary mr-2"
                                :disabled="form.processing"
                            >
                                Kaydet
                            </button>
                            <button
                                v-if="project && !project.is_human"
                                type="submit"
                                class="btn btn-primary mr-2"
                                :disabled="
                                    !project.full_status || form.processing
                                "
                            >
                                Daha fazla getir
                            </button>
                        </div>
                    </form>
                </div>
                <!--begin::Body-->
            </div>
        </div>
        <div class="col-lg-8" v-if="project && !project.is_human">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >Üretilen Halı Modelleri</span
                        >
                        <span
                            class="text-gray-500 mt-1 fw-semibold fs-6 saving"
                            v-if="project.full_status == false"
                        >
                            {{ project.product_count }}
                            adet model üretildi. Modeller getiriliyor lütfen
                            bekleyiniz.<span>.</span><span>.</span
                            ><span>.</span></span
                        >
                        <span
                            class="text-gray-500 mt-1 fw-semibold fs-6 saving"
                            v-if="
                                project.full_images.length > 0 &&
                                project.full_status == false
                            "
                        >
                            {{ project.full_images.length }} adet model
                            getirildi. Bekleyin işleminiz devam ediyor<span
                                >.</span
                            ><span>.</span><span>.</span></span
                        >
                        <span
                            class="text-gray-500 mt-1 fw-semibold fs-6"
                            v-if="project.full_status == true"
                        >
                            {{ project.full_images.length }} adet model
                            getirildi. Modelleme tamamlandı.</span
                        >
                    </h3>
                    <div class="card-toolbar">
                        <span
                            v-if="!project.full_status"
                            class="badge badge-light-primary flex-shrink-0 align-self-center py-3 px-4 fs-7"
                            >İşlemde
                        </span>
                        <span
                            v-else
                            class="badge badge-light-success flex-shrink-0 align-self-center py-3 px-4 fs-7"
                            >Tamamlandı
                        </span>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3 pb-10">
                    <!--begin::Col-->
                    <div>
                        <!--begin::Card widget 14-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Body-->
                            <div class="row">
                                <span
                                    v-if="
                                        project.full_images.length == 0 &&
                                        project.full_status == true
                                    "
                                    class="fw-semibold text-gray-600 fs-6 mb-8 d-block"
                                >
                                    Bu işlem için model üretilemedi. Lütfen
                                    tekrar deneyiniz.
                                </span>
                                <!--begin::Overlay-->
                                <div
                                    class="d-flex align-items-center flex-wrap mb-8"
                                >
                                    <div
                                        class="symbol mr-5 mb-5 pt-1"
                                        v-if="
                                            project &&
                                            project.full_status == false
                                        "
                                    >
                                        <div
                                            class="symbol-label min-w-100px min-h-150px"
                                            :style="{
                                                backgroundImage:
                                                    'url(/backend/media/loading.gif)',
                                                backgroundSize: 'contain',
                                                backgroundRepeat: 'no-repeat',
                                                backgroundColor: '#e5eff1',
                                            }"
                                        ></div>
                                    </div>
                                    <div
                                        class="symbol mr-5 mb-5 pt-1 cursor-pointer"
                                        v-for="image in project.full_images"
                                        :key="image"
                                        @click="
                                            (simpleDialog = true),
                                                (output_form.selectedItem =
                                                    image),
                                                (output_form.selectOutput =
                                                    dimensions[0])
                                        "
                                    >
                                        <div
                                            class="symbol-label min-w-100px min-h-150px"
                                            :style="{
                                                backgroundImage:
                                                    'url(' + image + ')',
                                                backgroundSize: 'contain',
                                                backgroundRepeat: 'no-repeat',
                                            }"
                                        ></div>
                                    </div>
                                </div>

                                <!--end::Overlay-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 14-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
        <div class="col-lg-8" v-if="project && project.is_human">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"
                            >Ebatlandır</span
                        >
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3 pb-10">
                    <!--begin::Col-->
                    <div>
                        <!--begin::Card widget 14-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Body-->
                            <div class="row">
                                <!--begin::Overlay-->
                                <div
                                    class="d-flex align-items-center flex-wrap mb-8"
                                >
                                    <div
                                        class="symbol mr-5 mb-5 pt-1 cursor-pointer"
                                        v-for="image in project.full_images"
                                        :key="image"
                                        @click="
                                            (simpleDialog = true),
                                                (output_form.selectedItem =
                                                    image),
                                                (output_form.selectOutput =
                                                    dimensions[0])
                                        "
                                    >
                                        <div
                                            class="symbol-label min-w-100px min-h-150px"
                                            :style="{
                                                backgroundImage:
                                                    'url(' + image + ')',
                                                backgroundSize: 'contain',
                                                backgroundRepeat: 'no-repeat',
                                            }"
                                        ></div>
                                    </div>
                                </div>

                                <!--end::Overlay-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card widget 14-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
    </div>

    <GDialog v-model="simpleDialog">
        <div class="bg-white big_modal" tabindex="-1">
            <div class="">
                <div class="modal-header">
                    <h1 class="modal-title fw-bolder">Model Çıktı Oluştur</h1>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        @click="simpleDialog = false"
                        aria-label="Close"
                    >
                        <span class="svg-icon svg-icon-2x">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body library_modal p-0">
                    <div
                        class="d-flex h-100 align-items-start"
                        style="background: #f6f8fa"
                    >
                        <div
                            v-if="false"
                            class="col-lg-3 bg-light p-3 ps-5 selected-wrapper align-self-stretch"
                            style="overflow-x: scroll; height: 700px"
                        >
                            <div
                                class="row g-5 g-xl-9 mb-5 mb-xl-9 d-flex justify-content-center"
                            >
                                <div
                                    v-for="dimension in dimensions"
                                    :key="dimension"
                                    class="d-flex flex-column border border-1 border-gray-300 text-center pt-2 pb-4 mb-0 mr-5 mt-10 cursor-pointer"
                                    :class="{
                                        'selected-border':
                                            dimension ==
                                            output_form.selectOutput,
                                    }"
                                    style="width: 170px"
                                    @click="
                                        output_form.selectOutput = dimension
                                    "
                                >
                                    <div
                                        class="card-rounded position-relative mb-5"
                                    >
                                        <!--begin::Img-->
                                        <div
                                            class="d-flex justify-content-center"
                                        >
                                            <img
                                                :class="{
                                                    selected:
                                                        dimension ==
                                                        output_form.selectOutput,

                                                    'cursor-pointer': true,
                                                }"
                                                :style="
                                                    'height:' +
                                                    dimension.pixel_length /
                                                        20 +
                                                    'px; width:' +
                                                    dimension.pixel_width / 20 +
                                                    'px;object-fit:fill;'
                                                "
                                                :src="output_form.selectedItem"
                                            />
                                        </div>
                                        <!--end::Img-->
                                    </div>
                                    <!--end::User pic-->

                                    <!--begin::Info-->
                                    <div class="m-0">
                                        <span
                                            class="fw-bold fs-6 text-gray-500 d-block lh-1"
                                        >
                                            {{ dimension.dimension_width }}
                                            x
                                            {{
                                                dimension.dimension_length
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 bg-light d-flex justify-content-center"
                        >
                            <img
                                class="cursor-pointer selected m-10"
                                @click="visible = true"
                                :src="output_form.selectedItem"
                                :style="
                                    'height:' +
                                    output_form.selectOutput.pixel_length / 3 +
                                    'px; width:' +
                                    output_form.selectOutput.pixel_width / 3 +
                                    'px;object-fit:fill;'
                                "
                            />
                            <vue-easy-lightbox
                                :visible="visible"
                                :imgs="
                                    output_form.selectedItem +
                                    '_' +
                                    output_form.selectOutput.pixel_width +
                                    'x' +
                                    output_form.selectOutput.pixel_length +
                                    '.png'
                                "
                                :index="indexRef"
                                @hide="visible = false"
                            ></vue-easy-lightbox>
                        </div>
                    </div>
                </div>
                <div class="modal-footersd p-5">
                    <div class="d-flex">
                        <div class="mr-auto">
                            <Link
                                :href="route('backend.projects')"
                                :data="{
                                    url: output_form.selectedItem
                                        ? decode(output_form.selectedItem)
                                        : '',
                                }"
                                class="btn btn-success ml-auto"
                            >
                                Bu Modelden Üretim Yap
                            </Link>
                        </div>

                        <div class="form-group me-5">
                            <div class="flex">
                                <div class="input-group mb-5 mr-5">
                                    <span class="input-group-text" id="basic-addon1">Genişlik</span>
                                    <input type="text" class="form-control" v-model="output_form.manuel_width" placeholder="1920" aria-label="Yükseklik" aria-describedby="basic-addon1"/>
                                </div>
                                <div class="input-group mb-5 mr-5">
                                    <span class="input-group-text" id="basic-addon1">Yükseklik</span>
                                    <input type="text" class="form-control" v-model="output_form.manuel_height" placeholder="1080" aria-label="Yükseklik" aria-describedby="basic-addon1"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group me-5">
                            <select
                                class="form-control selectpicker"
                                v-model="output_form.type"
                                style="width: 170px"
                            >
                                <!-- <option value="bmp">BMP</option> -->
                                <option value="tiff">TIF</option>
                            </select>
                        </div>
                        <div class="form-group me-5">
                            <select
                                class="form-control selectpicker"
                                v-model="output_form.color"
                                style="width: 170px"
                                v-if="output_form.type == 'bmp'"
                            >
                                <option :value="4">4 Colors</option>
                                <option :value="5">5 Colors</option>
                                <option :value="6">6 Colors</option>
                                <option :value="7">7 Colors</option>
                                <option :value="8" selected>8 Colors</option>
                                <option :value="9">9 Colors</option>
                                <option :value="10">10 Colors</option>
                            </select>
                            <select
                                class="form-control selectpicker"
                                v-model="output_form.color"
                                style="width: 170px"
                                v-if="output_form.type == 'tiff'"
                            >
                                <option :value="1" selected>CMYK</option>
                            </select>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="btn btn-primary"
                                :disabled="output_form.processing"
                                @click="downloadModel"
                            >
                                <!-- <span v-if="output_form.selectOutput"
                                    >{{
                                        output_form.selectOutput
                                            .dimension_width
                                    }}x{{
                                        output_form.selectOutput
                                            .dimension_length
                                    }}</span
                                > -->
                                Kaydet ve İndir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GDialog>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import InputError from "@/Components/InputError";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import vSelect from "vue-select";
import { Inertia } from "@inertiajs/inertia";
import "gitart-vue-dialog/dist/style.css";
import VueEasyLightbox from "vue-easy-lightbox";

import "vue-easy-lightbox/dist/external-css/vue-easy-lightbox.css";
import { GDialog } from "gitart-vue-dialog";

export default {
    name: "Index",
    components: { InputError, Link, vSelect, GDialog, VueEasyLightbox },
    props: {
        project: Array,
        dimensions: Array,
        comboWefts: Array,
        flash: Object,
        url: String,
    },
    layout: AdminLayoutMaster,
    data: () => ({
        visible: false,
        selectOutput: null,
        imageUrl: null,
        simpleDialog: false,
        selectedItem: {},
        update_form: useForm({}),
        output_form: useForm({
            color: 1,
            selectOutput: null,
            type: "tiff",
            selectedItem: null,
            manuel_width: null,
            manuel_height: null,
        }),
        form: useForm({
            comboWeft: 2,
            file: null,
            url: null,
            prompt: "This is a rug . Generate this rug with geometric shapes . Use input colors",
            a_prompt: null,
            n_prompt: null,
            is_human: false,
        }),
    }),
    mounted() {
        if (this.project) {
            this.form.is_human = this.project.is_human;
            console.log(this.project.is_human);
            this.form.prompt = this.project.prompt;
            this.form.a_prompt = this.project.a_prompt;
            this.form.n_prompt = this.project.n_prompt;
        }

        if (this.url) {
            this.imageUrl = this.url;
            this.form.url = this.url;
        }
    },
    created() {
        window.Echo.channel("replicate-channel").listen(
            ".App\\Events\\ReplicateEvent",
            (e) => {
                Inertia.reload();
                // this.$inertia.visit(
                //     route("backend.projects.id", this.project.id),
                //     {
                //         only: ["project"],
                //     }
                // );
                console.log("ReplicateEvent", e);
            }
        );
    },
    methods: {
        decode(str) {
            return btoa(str);
        },
        previewImage(event) {
            this.imageUrl = URL.createObjectURL(event.target.files[0]);
            this.form.file = event.target.files[0];
        },
        async downloadModel() {
            try {
                this.output_form.post(route("backend.projects.download"), {
                    onFinish: async () => {
                        console.log(this.flash);
                        if (this.flash.image) {
                            const response = await fetch(this.flash.image);
                            const blob = await response.blob();

                            // Dosya adını URL'den çıkar
                            const urlParts = this.flash.image.split("/");
                            const filename = urlParts[urlParts.length - 1];

                            // Blob'dan dosya adını çıkarmak için bir a elementi oluştur
                            const link = document.createElement("a");
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;

                            // Bağlantıyı tıkla ve indirme işlemi başlat
                            link.click();

                            // Bağlantıyı kaldır (opsiyonel)
                            document.body.removeChild(link);
                        }
                    },
                });
            } catch (error) {
                console.error("File download failed:", error);
            }
        },
        async uploadFile(event) {
            try {
                if (this.project) {
                    this.form.post(
                        route("backend.projects.update", this.project.id),
                        {
                            onFinish: () => {
                                this.imageUrl = null;
                                this.form.file = null;
                            },
                            onSuccess: () => {
                                this.imageUrl = null;
                                this.form.file = null;
                            },
                        }
                    );
                } else {
                    this.form.post(route("backend.projects.create"), {
                        onFinish: () => {
                            this.imageUrl = null;
                            this.form.file = null;
                        },
                        onSuccess: () => {
                            this.imageUrl = null;
                            this.form.file = null;
                        },
                    });
                }
            } catch (error) {
                console.error("File upload failed:", error);
            }
        },
    },
};
</script>

<style scoped>
@keyframes blink {
    /**
     * At the start of the animation the dot
     * has an opacity of .2
     */
    0% {
        opacity: 0.2;
    }
    /**
     * At 20% the dot is fully visible and
     * then fades out slowly
     */
    20% {
        opacity: 1;
    }
    /**
     * Until it reaches an opacity of .2 and
     * the animation can start again
     */
    100% {
        opacity: 0.2;
    }
}

.saving span {
    /**
     * Use the blink animation, which is defined above
     */
    animation-name: blink;
    /**
     * The animation should take 1.4 seconds
     */
    animation-duration: 1.4s;
    /**
     * It will repeat itself forever
     */
    animation-iteration-count: infinite;
    /**
     * This makes sure that the starting style (opacity: .2)
     * of the animation is applied before the animation starts.
     * Otherwise we would see a short flash or would have
     * to set the default styling of the dots to the same
     * as the animation. Same applies for the ending styles.
     */
    animation-fill-mode: both;
}

.saving span:nth-child(2) {
    /**
     * Starts the animation of the third dot
     * with a delay of .2s, otherwise all dots
     * would animate at the same time
     */
    animation-delay: 0.2s;
}

.saving span:nth-child(3) {
    /**
     * Starts the animation of the third dot
     * with a delay of .4s, otherwise all dots
     * would animate at the same time
     */
    animation-delay: 0.4s;
}

[type="file"] {
    padding: 0.825rem 1.5rem !important;
}

.selected {
    box-shadow: 7px 7px 9px 3px #333;
}

.selected-border {
    border: 1px #b2b2b2 solid !important;
}
</style>
