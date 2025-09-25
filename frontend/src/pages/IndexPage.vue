<template>
  <DashboardTaskComponent/>
</template>

<script>
import { useGeneralStore } from 'src/stores/generalStore'
import DashboardTaskComponent from './TaskManagement/dashboardTaskComponent.vue'

export default {
  name: 'DashboardMain',

  components : {DashboardTaskComponent},

  mounted () {
    const generalStore = useGeneralStore()
    generalStore.setActivePage('home')
    generalStore.setPageTitle('Home page')
  }
}
</script>

<style scoped>
.q-badge.rounded-full {
  border-radius: 12px;
  padding: 4px 8px;
  font-size: 11px;
}
.q-card {
  transition: box-shadow 0.2s ease-in-out;
}
</style>
