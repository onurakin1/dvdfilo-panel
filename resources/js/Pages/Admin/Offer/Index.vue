<template>

    <QuickTable title="Tekliflerim" data-name="getOffers" :data="offers" :filter="{ role: false, search: false }">
        <template #toolbar></template>
        <template #header>
            <tr class="fw-bolder text-muted">
                <th class="min-w-120px text-start w-25px">
                    {{ __("No") }}
                </th>
                <th class="">{{ __("Adı") }}</th>
                <th class="min-w-140px">{{ __("Soyadı") }}</th>
                <th class="">{{ __("Telefon Numarası") }}</th>
                <th class="">{{ __("E-Mail") }}</th>
                <th class="">{{ __("İstenilen Marka") }}</th>
                <th class="">{{ __("İstenilen Model") }}</th>
                <th class="">{{ __("Teklif Tipi") }}</th>
                <th class="">{{ __("Kiralama Süresi") }}</th>
                <th class="">{{ __("Yapılacak KM") }}</th>
                <th class="">{{ __("Tarih") }}</th>
            </tr>
        </template>
        <template #rows>
            <template v-for="(offer, index) in offers.data" :key="offer">
                <transition name="list">
                    <tr>
                        <td class="text-start">#{{ offer.id }}</td>
                        <td class="text-start">{{ offer.firstname }}</td>
                        <td class="text-start">
                            {{ offer.lastname }}
                        </td>
                        <td class="text-start">
                            {{ offer.phone_number }}
                        </td>
                        <td class="text-start">
                            {{ offer.email }}
                        </td>
                        <td class="text-start">
                            {{ offer.brand.brand_name }}
                        </td>
                        <td class="text-start">
                            {{ offer.carname }}
                        </td>
                        <td class="text-start">
                            {{ offer.offer_type }}
                        </td>
                        <td class="text-start">
                            {{ offer.rental_period }}
                        </td>
                        <td class="text-start">
                            {{ offer.km_time }}
                        </td>
                        <td class="text-start">
                            {{ offer.created_at }}
                        </td>
                    </tr>
                </transition>
            </template>
        </template>
    </QuickTable>

</template>

<script>
import AdminLayoutMaster from "@/Layouts/AdminLayouts/Master";
import Breadcrumb from "@/Layouts/AdminLayouts/Breadcrumb";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import FormAlert from "@/Components/FormAlert";
import QuickTable from "@/Components/QuickTable";

export default {
    name: "Index",
    components: { QuickTable, Breadcrumb, Link, FormAlert},
    layout: AdminLayoutMaster,
    props: ["offers"],
    data() {
        return {
            isModalOpen: false,
           
        };
    },
    methods: {
    },
    created() {
        window.Echo.channel("replicate-channel").listen(
            ".App\\Events\\ReplicateEvent",
            (e) => {
                Inertia.reload();
                console.log("ReplicateEvent", e);
            }
        );
    },
    mounted() {},
};
</script>

<style scoped>
/* Modal stil kodları */
</style>
