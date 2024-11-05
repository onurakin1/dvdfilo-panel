<template>
    <div  class="card mb-4 shadow-sm  mb-5 bg-white rounded">
    
            <img :src="imgSrc" class="card-img-top img-fluid" @load="setCardBackground" alt="Car Image" />
 
        <div :style="{ backgroundColor: cardBackgroundColor }" class="card-body flex-grow-1">
            <h2 class="card-title h2">{{ title }}</h2>
            <p class="card-text mb-3 h4 font-weight-light text-dark">{{ desc }}</p>
            <p class="card-text mb-3">{{ brand }}</p>
            <span class="badge badge-primary" style="    color: #DF010D;
    border: 1px solid;
    background-color: #fff;">Teklif sayısı: {{ totalOffers }}</span>
        </div>
    </div>
</template>

<script>
import ColorThief from 'colorthief';

export default {
    props: ['imgSrc', 'title', 'brand', 'desc', 'totalOffers'],
    data() {
        return {
            cardBackgroundColor: '#fff',
        };
    },
    methods: {
        setCardBackground(event) {
            const colorThief = new ColorThief();
            const img = event.target;
            if (img.complete) {
                const dominantColor = colorThief.getColor(img);
                const softenFactor = 0.4;
                const softColor = dominantColor.map(color => 
                    Math.round(color + (255 - color) * softenFactor)
                );
                this.cardBackgroundColor = `rgb(${softColor[0]}, ${softColor[1]}, ${softColor[2]})`;
            }
        }
    }
};
</script>

<style scoped>

.card-img-top {
    height: 100%;
    max-height: 270px;
     width:100%;
    object-fit: contain;
}

</style>
