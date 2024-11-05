<template>
  <button type="button" class="btn btn-primary w-100" @click="openModal()">
    {{ button_title }}
  </button>

  <GDialog v-model="simpleDialog">
    <div
      class="bg-white big_modal"
      :class="modal_type ? modal_type : ''"
      tabindex="-1"
    >
      <div class="">
        <div class="modal-header">
          <h1 class="modal-title fw-bolder">{{ title }}</h1>
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
          <div class="d-flex h-100 align-items-start">
            <div class="col-lg-10">
              <div class="file-upload-label">
                Dosyalarınızı Sürükleyip Bırakın veya
                <span
                  class="filepond--label-action"
                  ref="filepond-browser-button"
                  @click="clickBrowser()"
                >
                  Dosya Seçin
                </span>
              </div>
              <div class="d-flex flex-wrap ms-5 me-5">
                <div class="list-item mb-4" :class="visible">
                  <file-pond
                    @uploadFiles="uploadFiles($event)"
                    :multiple="true"
                    fileType="image"
                    :reload="true"
                    :refference="this.modal_type"
                  ></file-pond>
                </div>
                <div
                  class="list-item mb-4"
                  @click="itemSelect(item)"
                  v-for="(item, index) in files.data"
                  :key="'library_' + index"
                >
                  <div
                    class="cursor-pointer not-selected"
                    :class="{
                      selected: selectedItem && selectedItem.id == item.id,
                    }"
                  >
                    <div class="data-video" v-if="item.resolution == 'video'">
                      <video class="thumb-img" :src="item.full_path" />
                      <span class="play-icon"></span>
                    </div>
                    <img class="thumb-img" v-else :src="item.imagex_modal_image" />
                  </div>
                </div>
              </div>
            </div>
            <div
              class="
                col-lg-2
                bg-light
                p-3
                ps-5
                selected-wrapper
                align-self-stretch
              "
            >
              <div v-if="selectedItem">
                <video
                  class="mb-3 w-100"
                  autoplay
                  controls
                  v-if="selectedItem.resolution == 'video'"
                  :src="selectedItem.full_path"
                />
                <img class="mb-3" v-else :src="selectedItem.imagex_modal_image" alt="" />
                <span class="fw-bold d-block">{{
                  selectedItem.full_name
                }}</span>
                <span v-if="selectedItem.resolution !== 'video'"
                  >{{ selectedItem.created_at }}; {{ selectedItem.size }} KB;
                  {{ selectedItem.resolution }} piksel</span
                >
                <div class="mb-3">
                  <span class="text-danger cursor-pointer" @click="deleteData()"
                    >Kalıcı Olarak Sil</span
                  >
                </div>
                <form-alert :success="success" />
                <form @submit.prevent="submit" class="mt-5">
                  <div class="mb-6 d-flex flex-wrap">
                    <div class="d-flex align-items-center w-100">
                      <label
                        for="title"
                        class="form-label col-lg-3 text-right mb-0 pe-2"
                        >Başlık</label
                      >
                      <div class="col-lg-9">
                        <input
                          type="text"
                          id="title"
                          name="title"
                          v-model="form.title"
                          :class="{ 'is-invalid': form.errors.title }"
                          class="form-control"
                          placeholder="Başlık giriniz."
                        />
                      </div>
                    </div>
                    <input-error :message="form.errors.title" class="mt-2" />
                  </div>
                  <div class="mb-6 d-flex flex-wrap">
                    <div class="d-flex align-items-center w-100">
                      <label
                        for="alt"
                        class="form-label col-lg-3 text-right mb-0 pe-2"
                        >Alternatif Metin</label
                      >
                      <div class="col-lg-9">
                        <input
                          type="text"
                          id="alt"
                          name="alt"
                          v-model="form.alt"
                          :class="{ 'is-invalid': form.errors.alt }"
                          class="form-control"
                          placeholder="Alternatif metin giriniz."
                        />
                      </div>
                    </div>
                    <input-error :message="form.errors.alt" class="mt-2" />
                    <div class="fs-7 fw-bold text-muted mt-2 col-lg-9 ms-auto">
                      <a
                        target="_blank"
                        href="https://www.w3.org/WAI/tutorials/images/decision-tree/"
                        >Görselin amacını açıklayın</a
                      >. Görsel tamamen dekoratif amaçlı ise boş bırakın.
                    </div>
                  </div>
                  <div class="mb-6 d-flex align-items-center flex-wrap">
                    <label class="form-label col-lg-3 text-right mb-0 pe-2"
                      >Dosya Adresi</label
                    >
                    <div class="col-lg-9">
                      <input
                        class="form-control form-control-transparent"
                        :value="selectedItem.full_path"
                        disabled
                      />
                    </div>
                    <div class="col-lg-9 ms-auto mt-3">
                      <a
                        href="javascript:;"
                        @click="copyText(selectedItem.full_path)"
                        class="btn btn-sm btn-light-success"
                        ><i class="bi bi-files"></i> Kopyala</a
                      >
                      <span
                        class="copy-success ms-3"
                        v-if="coppied_text == selectedItem.full_path"
                        ><i class="bi bi-check2-all me-1 text-success"></i
                        >Kopyalandı</span
                      >
                    </div>
                  </div>
                  <div class="mb-3 text-end mt-20">
                      <image-editor :selectedItem="selectedItem" type="upload" :editorButton="selectedItem.resolution != 'video'"></image-editor>


                      <button type="submit" class="btn btn-success btn-sm mt-3">
                      <i class="bi bi-check2"></i> Değişiklikleri Kaydet
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <div class="d-inline-flex justify-content-center">
            <button
              @click="updateList(link.url)"
              v-for="(link, index) in files.links"
              :key="index"
              type="button"
              :class="{
                'btn-hover-primary active': link.active,
                'w-100px': index === 0 || files.links.length === index + 1,
              }"
              class="btn btn-icon btn-sm btn-light mr-2 my-1"
              v-html="link.label"
            ></button>
          </div>
          <button @click="setEmit" type="button" class="btn btn-primary">
            {{ button_title }}
          </button>
        </div>
      </div>
    </div>
  </GDialog>

</template>
<script>
import axios from "axios";
import FilePondComponent from "@/Components/FilePond";
import { Link } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";
import InputError from "@/Components/InputError";
import ImageEditor from "@/Components/ImageEditor";
import "gitart-vue-dialog/dist/style.css";
import { GDialog } from "gitart-vue-dialog";

export default {
  name: "FileUpload",
  components: {
    ImageEditor,
    "file-pond": FilePondComponent,
    Link,
    FormAlert,
    InputError,
    GDialog,
  },
  props: {
    button_title: String,
    title: String,
    multiple: Boolean,
    fileType: String,
    modal_type: String,
  },
  emits: ["end"],
  data() {
    return {
      simpleDialog: false,
      selectedItem: null,
      visible: "d-none",
      files: {},
      coppied_text: "",
      success: "",
      form: this.$inertia.form({
        title: "",
        alt: "",
      }),
    };
  },

  methods: {
    clickBrowser() {
      if (this.modal_type) {
        $("." + this.modal_type + " .filepond--browser").trigger("click");
      }
    },
    setEmit() {
      this.$emit("end", this.selectedItem);
      this.selectedItem = null;
      $("#file_upload_modal_" + this.modal_type).modal("hide");
    },
    copyText(text) {
      this.coppied_text = text;
      const clipboardData = window.clipboardData || navigator.clipboard;
      clipboardData.writeText(text);
    },
    itemSelect(item) {
      this.selectedItem = item;
      this.form.title = item.title;
      this.form.alt = item.alt;
    },
    openModal() {
      this.getFiles()
      this.simpleDialog = true;
    },
    updateList(link) {
      let self = this;
      axios.get(link, {}).then(function (response) {
        self.files = response.data;
      });
    },
    uploadFiles(data) {
      (this.visible = data), this.getFiles();
    },
    submit(e) {
      let self = this;
      axios
        .put(route("backend.files.update_modal", self.selectedItem.id), {
          data: {
            title: self.form.title,
            alt: self.form.alt,
          },
        })
        .then(function (response) {
          self.success = self.$page.props.flash.success;
          self.init();
          self.selectedItem.title = self.form.title;
          self.selectedItem.alt = self.form.alt;
          self.$swal({
            title: "Güncellendi!",
            text: "Kayıt başarıyla güncellendi.",
            icon: "success",
            confirmButtonText: "Kapat",
          });
        });
    },
    getFiles() {
      let self = this;
      axios
        .get(route("backend.files.get_modal_files"), {})
        .then(function (response) {
          self.files = response.data;
          if (self.files.data.length) {
            self.itemSelect(self.files.data[0]);
          }
        });
    },
    deleteData() {
      this.form.id = this.selectedItem.id;
      let self = this;
      this.$swal({
        title: "Emin misiniz?",
        text: "Bu işlem geri alınamaz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eminim, sil!",
        cancelButtonText: "İptal",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(route("backend.files.destroy", self.form.id), {
              data: {
                modal: true,
              },
            })
            .then(function (response) {
              self.$swal({
                title: "Silindi!",
                text: "Kayıt başarıyla silindi.",
                icon: "success",
                confirmButtonText: "Kapat",
              });
              self.init();
              self.selectedItem = null;
            });
        }
      });
    },
    handleFilePondAddFile: function (error, file) {
      this.file = file.serverId;
    },
  },
  mounted() {
    let self = this;

      self.emitter.on("update_file_modal_list",function (){
          self.getFiles()
      });

      if (self.modal_type.includes("model_header_type")) {
      $("#file_upload_modal_" + self.modal_type).on(
        "shown.bs.modal",
        function () {
          self.emitter.emit("open_upload_modal");
        }
      );
    }
  },
};
</script>

<style scoped>
.not-selected {
  border: 5px solid transparent;
}
.selected {
  border: 5px solid #cc0000;
}
</style>
