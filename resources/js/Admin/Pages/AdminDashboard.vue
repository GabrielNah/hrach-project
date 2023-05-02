<template>
    <currency-rates/>
    <project-state/>
    <site-appearance/>
</template>

<script>
import CurrencyRates from "./Settings/CurrencyRates.vue";
import ProjectState from "./Settings/ProjectState.vue";
import SiteAppearance from "./SiteAppearance.vue";
export default {
    name: "AdminDashboard",
    components: {SiteAppearance, ProjectState, CurrencyRates}
}
</script>

<style scoped>

</style>
