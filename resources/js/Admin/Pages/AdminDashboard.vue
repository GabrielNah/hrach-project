<template>
    <project-state/>
    <currency-rates/>
</template>

<script>
import CurrencyRates from "./Settings/CurrencyRates.vue";
import ProjectState from "./Settings/ProjectState.vue";
export default {
    name: "AdminDashboard",
    components: {ProjectState, CurrencyRates}
}
</script>

<style scoped>

</style>
