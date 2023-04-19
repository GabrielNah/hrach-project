<template>
    <notifications position="top right" classes="my-notification" width="400px"/>
<router-view/>
</template>

<script>

export default {
    name: "App",
}
</script>

<style lang="scss">
.container{
    @media (max-width: 770px) {
        max-width: 100%;
    }
}
.my-notification {
    /*...*/

    // style for title line
    .notification-title {
        /*...*/
    }

    // style for content
    .notification-content {
        /*...*/
    }

    // additional styling hook when using`type` parameter, i.e. this.$notify({ type: 'success', message: 'Yay!' })
    &.success {
        background-color: #47bd9a;
        color: white;
        text-align: center;
        padding: 5px;
    }
    &.info {
        background-color: #4eb5f1;
        color: white;
        text-align: center;
        padding: 5px;
    }
    &.error {
        background-color: #e74c5e;
        color: white;
        text-align: center;
    }
}
</style>
