<template>
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{
                    group.name
                }}</span>
                <span class="text-muted fw-bold fs-7"
                    >Bu ekranlarda yapılacak değişiklikler bu gruba ait tüm
                    şubelerde geçerli olacaktır.</span
                >
            </h3>
            <div class="card-toolbar"></div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 pb-10">
            <div class="row justify-content-center">
                <template v-for="screen in group.screens.screens" :key="screen">
                    <div
                        :class="{
                            'col-lg-3': screen.type == 'dikey',
                            'col-lg-2': screen.type == 'yatay',
                        }"
                        style="text-align: -webkit-center"
                    >
                        <div
                            :id="
                                screen.type == 'dikey'
                                    ? 'monitor-dikey'
                                    : 'monitor'
                            "
                        >
                            <Link
                                :href="
                                    route('backend.tv.items', {
                                        group_id: group.id,
                                        tv_id: screen.id,
                                    })
                                "
                            >
                                <div
                                    :id="
                                        screen.type == 'dikey'
                                            ? 'monitorscreen-dikey'
                                            : 'monitorscreen'
                                    "
                                >
                                    <img />
                                </div>
                            </Link>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ screen.id }}. Ekran
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <!--begin::Body-->
    </div>
</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import InputError from "@/Components/InputError";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import vSelect from "vue-select";

export default {
    name: "Index",
    props: ["digitals", "group"],
    components: {
        InputError,
        Link,
        vSelect,
    },

    layout: AdminLayoutMaster,
    data() {
        return {
            file: "",
        };
    },
    methods: {
        handleFileUpload(digitalId) {
            const fileInput = this.$refs["file" + digitalId][0];
            if (fileInput && fileInput.files[0]) {
                this.file = fileInput.files[0];

                this.uploadFile(digitalId);

                this.digitals.forEach(function (item) {
                    if (item.id == digitalId) {
                        item.image_url = URL.createObjectURL(
                            fileInput.files[0]
                        );
                    }
                });
            }
        },
        submitFile(digitalId) {
            console.log(this.$refs);
            const fileInputRef = this.$refs["file" + digitalId];
            if (fileInputRef && fileInputRef[0]) {
                fileInputRef[0].click();
            } else {
                console.error("Dosya input elemanı bulunamadı.");
            }
        },
        uploadFile(id) {
            let formData = new FormData();
            formData.append("file", this.file);
            formData.append("id", id);

            // API isteği gönder
            axios
                .post(route("backend.tv.upload"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer " + this.$page.props.token,
                    },
                })
                .then((response) => {
                    // İşlem başarılıysa
                    console.log("Dosya başarıyla yüklendi", response);
                })
                .catch((error) => {
                    // Hata oluşursa
                    console.error("Dosya yükleme hatası", error);
                });
        },
    },
};
</script>

<style scoped>
#monitor-dikey {
    background: #000;
    position: relative;
    border-top: 3px solid #888;
    margin: 5%;
    padding: 1.5% 1.5% 3% 1.5%;
    width: 200px;
    height: 355px;
    border-radius: 10px;
    border-bottom-left-radius: 50% 2%;
    border-bottom-right-radius: 50% 2%;
    transition: margin-right 1s;
}

#monitor-dikey:after {
    content: "";
    display: block;
    position: absolute;
    bottom: 3%;
    left: 36%;
    height: 0.5%;
    width: 28%;
    background: #ddd;
    border-radius: 50%;
    box-shadow: 0 0 3px 0 white;
}

#monitorscreen-dikey {
    position: relative;
    background-color: #777;
    background-size: cover;
    background-position: top center;
    height: 326px;
    padding-bottom: 56.25%;
    position: relative;
    overflow: hidden;
}

#monitor {
    background: #000;
    position: relative;
    border-top: 3px solid #888;
    margin: 5%;
    padding: 2% 2% 4% 2%;
    border-radius: 10px;
    border-bottom-left-radius: 50% 2%;
    border-bottom-right-radius: 50% 2%;
    transition: margin-right 1s;
}

#monitor:after {
    content: "";
    display: block;
    position: absolute;
    bottom: 3%;
    left: 36%;
    height: 0.5%;
    width: 28%;
    background: #ddd;
    border-radius: 50%;
    box-shadow: 0 0 3px 0 white;
}

#monitorscreen {
    position: relative;
    background-color: #777;
    background-size: cover;
    background-position: top center;
    height: 0;
    padding-bottom: 56.25%;
    position: relative;
    overflow: hidden;
}

@media all and (min-width: 960px) {
    #monitor {
        -webkit-animation: tvflicker 0.2s infinite alternate;
        -moz-animation: tvflicker 0.5s infinite alternate;
        -o-animation: tvflicker 0.5s infinite alternate;
        animation: tvflicker 0.5s infinite alternate;
    }

    @-webkit-keyframes tvflicker {
        0% {
            box-shadow: 0 0 100px 0 rgba(237, 164, 39, 0.4);
        }
        100% {
            box-shadow: 0 0 95px 0 rgba(237, 164, 39, 0.45);
        }
    }
    @-moz-keyframes tvflicker {
        0% {
            box-shadow: 0 0 100px 0 rgba(225, 235, 255, 0.4);
        }
        100% {
            box-shadow: 0 0 60px 0 rgba(200, 220, 255, 0.6);
        }
    }
    @-o-keyframes tvflicker {
        0% {
            box-shadow: 0 0 100px 0 rgba(225, 235, 255, 0.4);
        }
        100% {
            box-shadow: 0 0 60px 0 rgba(200, 220, 255, 0.6);
        }
    }
    @keyframes tvflicker {
        0% {
            box-shadow: 0 0 100px 0 rgba(225, 235, 255, 0.4);
        }
        100% {
            box-shadow: 0 0 60px 0 rgba(200, 220, 255, 0.6);
        }
    }
}
</style>
