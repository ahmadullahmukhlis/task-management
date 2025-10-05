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

this.$echo
  .channel('add-task')              // ✅ matches Channel('add-task')
  .listen('.TaskEvent', e => {      // ✅ matches broadcastAs() = TaskEvent
    console.log('Got TaskEvent:', e);
  });

  },
}
</script>
