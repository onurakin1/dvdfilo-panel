<template>
    <div v-if="isOpen" class="modal-overlay" @click="closeModal">
        <div>

        </div>
        <div class="modals" @click.stop>
            <div class="d-flex justify-content-end">
                <button @click="closeModal">X</button>
            </div>
            
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>

<style scoped>
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
