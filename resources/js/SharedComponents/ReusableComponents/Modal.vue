<template>
    <div class="modal" @click.self="closeModal">
        <button type="button" class="btn-close" @click.self="closeModal" disabled aria-label="Close"></button>
        <main class="p-2 main_content">
            <slot/>
        </main>
    </div>
</template>

<script>
export default {
    name: "Modal",
    methods:{
        closeModal(){
            this.$emit('close')
        }
    }
}
</script>

<style scoped>
.modal{
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999999999;
    background-color: #6c757d;
}
.btn-close{
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 9999999999999;
}
.main_content{
    z-index: 99999999999999999;
    background-color: #f1f3f4;
    width: 80%;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 8px;
}
</style>
