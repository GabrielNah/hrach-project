<template>
    <div class="modal">
        <main class="p-2">
            <slot/>
        </main>
    </div>
</template>

<script>
export default {
    name: "Modal"
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
    z-index: 99999999999999;
    background-color: #6c757d;
}
</style>
