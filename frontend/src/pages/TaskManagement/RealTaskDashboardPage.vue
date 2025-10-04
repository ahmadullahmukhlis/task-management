<template>
  <div>
    <h1>Real Time Data</h1>
    <div v-if="lastEvent">
      <p><strong>Last Event:</strong></p>
      <pre>{{ lastEvent }}</pre>
    </div>
  </div>
</template>

<script>
export default {
  name: "RealTaskDashboardPage",
  data() {
    return {
      lastEvent: null,
    }
  },
  mounted() {
    this.$echo.channel('add-task')
      .listen('.TaskEvent', (event) => {
        alert(event.id)
        console.log('New task event:', event)
        this.lastEvent = event
      })
  },
  beforeUnmount() {
    this.$echo.leave('add-task')
  }
}
</script>
