<template>
    <div class="lds-dual-ring"></div>
</template>

<script>
export default {
    name: "MiniLoader"
}
</script>

<style scoped>

.lds-dual-ring {
    display: inline-block;
    width: 40px;
    height: 40px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 35px;
    height: 35px;
    margin: 8px;
    border-radius: 50%;
    border: 4px solid #0A66C2;
    border-color: #0A66C2 transparent #0A66C2 transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
