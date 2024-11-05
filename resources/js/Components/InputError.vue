<template>
    <div v-show="message">
        <p class="fv-plugins-message-container invalid-feedback">
            {{ message }}
        </p>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['message']
})
</script>
