<template>
    <label for="slug" class="form-label" v-if="title">{{ title }}</label>
    <file-pond
        :name="fileType"
        :ref="refference"
        label-idle="Dosyalarınızı Sürükleyip Bırakın veya <span class='filepond--label-action'> Dosya Seçin </span>"
        v-bind:allow-multiple="multiple"
        accepted-file-types="image/*, video/mp4, application/pdf, application/vnd.ms-excel"
        :server="serverSettings"
        @processfile="handleFilePondAddFile"
        @addfilestart="handleStart"
        v-on:init="handleFilePondInit"
        :dropOnPage="true"
        :dropOnElement="false"
    />
</template>
<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginImageCrop from "filepond-plugin-image-crop";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginImageEdit from "filepond-plugin-image-edit";

// import {
//     // Image editor
//     openEditor,
//     processImage,
//     createDefaultImageReader,
//     createDefaultImageWriter,
//     createDefaultImageOrienter,
//
//     // Only needed if loading legacy image editor data
//     legacyDataToImageState,
//
//     // Import the editor default configuration
//     getEditorDefaults,
// } from './node_modules/pintura';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageEdit,
    FilePondPluginImageValidateSize,
    FilePondPluginImageCrop,
    FilePondPluginImageExifOrientation
);

export default {
    name: "FilePondComponent",
    components: { FilePond },
    emits: ["uploadFiles", "uploadedFile"],
    props: {
        refference: String,
        title: String,
        multiple: Boolean,
        reload: Boolean,
        fileType: String,
        item_id: String,
        group_id: String,
        service_type: String,
    },
    data() {
        return {
            file: null,
            pinturaEditorSettings: {}, //     // Maps legacy data objects to new imageState objects (optional)
            //     legacyDataToImageState: legacyDataToImageState,
            //
            //     // Used to create the editor (required)
            //     createEditor: openEditor,
            //
            //     // Used for reading the image data. See JavaScript installation for details on the `imageReader` property (required)
            //     imageReader: [
            //         createDefaultImageReader,
            //         {
            //             // createDefaultImageReader options here
            //         },
            //     ],
            //
            //     // Can leave out when not generating a preview thumbnail and/or output image (required)
            //     imageWriter: [
            //         createDefaultImageWriter,
            //         {
            //             // We'll resize images to fit a 512 × 512 square
            //             targetSize: {
            //                 width: 512,
            //                 height: 512,
            //             },
            //         },
            //     ],
            //
            //     // Used to poster and output images, runs an invisible "headless" editor instance.
            //     imageProcessor: processImage,
            //
            //     // Pintura Image Editor options
            //     editorOptions: {
            //         // Pass the editor default configuration options
            //         ...getEditorDefaults(),
            //
            //         // This will set a square crop aspect ratio
            //         imageCropAspectRatio: 1,
            //     },
            // }
        };
    },
    methods: {
        handleStart: function (error, file) {
            this.$emit("uploadFiles", "d-block");
        },

        handleFilePondAddFile: function (error, file) {
            this.$inertia.reload();
            this.file = file.serverId;
            let id = this.file.split("<link")[0];
            this.$emit("uploadedFile", id);
            this.$emit("uploadFiles", "d-none");

            this.$refs[this.refference].removeFile();
        },
    },
    computed: {
        serverSettings() {
            return {
                url:
                    "/admin/files?item_id=" +
                    this.item_id +
                    "&group_id=" +
                    this.group_id +
                    "&type=" +
                    this.service_type,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                revert: {
                    url: "/" + this.file,
                },
            };
        },
    },
};
</script>
