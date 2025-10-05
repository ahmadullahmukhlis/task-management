<template>
  <div class="p-12">
    <server-data :url="`tasks/load-real-time`" v-slot="{ data }" id="tasks">
      <!-- Users Grid -->
      <div
        :class="`grid gap-6`"
        :style="{ gridTemplateColumns: `repeat(${data.length || 1}, minmax(0, 1fr))` }"
      >
        <div v-for="user in data" :key="user.id">
          <q-card class="p-4 user-card" flat bordered>
            <div class="flex items-center">
              <q-avatar size="80px" class="mr-4">
                <img :src="user.name" :alt="user.name" />
              </q-avatar>
              <div class="flex-1">
                <div class="text-xl font-bold">{{ user.name }}</div>
                <div class="text-gray-500">{{ user.position }}</div>
                <div class="flex items-center mt-1 text-sm text-gray-400">
                  <q-icon name="email" size="16px" class="mr-1" />
                  {{ user.email }}
                </div>
                <div class="flex items-center text-sm text-gray-400">
                  <q-icon name="work" size="16px" class="mr-1" />
                  {{ user.department }}
                </div>
              </div>
              <div>
                <q-badge color="orange" :label="user.taskCount + ' tasks'" />
              </div>
            </div>

            <!-- User's Tasks Grid -->
            <div class="my-5">
              <div v-for="task in user.tasks" :key="task.id" class="my-2">
                <q-card
                  class="p-4 task-card"
                  flat
                  bordered
                  :class="`status-${task.status}`"
                >
                  <div class="flex items-center mb-2">
                    <div class="flex-1 text-lg font-semibold">{{ task.title }}</div>
                    <div>
                      <q-badge
                        color="green"
                        :label="task.project"
                      />
                    </div>
                  </div>
                       <div class="flex items-center mb-2">
                    <div class="flex-1 text-lg font-semibold">
                        <q-badge
                        color="info"
                        :label="task.status"
                      />
                    </div>
                    <div>
                <q-badge :color="getPriorityMeta(task.type)" class="flex items-center">
  <q-icon :name="getIcon(task.type)" size="16px" class="mr-1" />
  {{ task.type }}
</q-badge>

                    </div>
                  </div>
                  <div class="mb-3 text-sm text-gray-600 line-clamp-3">
                    {{ task.description }}
                  </div>
                  <div class="flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                      <q-icon name="event" size="14px" class="mr-1" />
                      Due: {{ task.dueDate }}
                    </div>
                    <div>
                      <q-btn flat round icon="more_vert" size="sm" color="gray-6">
                        <q-menu>
                          <q-list style="min-width: 100px">
                            <q-item clickable v-close-popup>
                              <q-item-section>Edit</q-item-section>
                            </q-item>
                            <q-item clickable v-close-popup>
                              <q-item-section>Delete</q-item-section>
                            </q-item>
                          </q-list>
                        </q-menu>
                      </q-btn>
                    </div>
                  </div>
                </q-card>
              </div>
            </div>
          </q-card>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="data.length === 0" class="p-12 text-center">
        <q-icon name="check_circle" size="80px" color="gray-400" />
        <div class="mt-4 text-xl text-gray-400">No tasks found</div>
        <div class="text-gray-500">Try changing your filters</div>
      </div>
    </server-data>
  </div>
</template>

<script>
import ServerData from 'src/components/ServerData.vue';
import { useGeneralStore } from 'src/stores/generalStore';

export default {
  name: "RealTaskDashboardPage",
  components: { ServerData },
  data() {
    return {};
  },
  mounted() {
    this.$echo.channel('add-task').listen('.TaskEvent', e => {
      console.log('Got TaskEvent:', e);
    });
  },
  methods: {
    getStatusColor(status) {
      const colors = {
        'pending': 'orange',
        'in-progress': 'blue',
        'completed': 'green'
      };
      return colors[status] || 'gray';
    },
    formatStatus(status) {
      const statusMap = {
        'pending': 'Pending',
        'in-progress': 'In Progress',
        'completed': 'Completed'
      };
      return statusMap[status] || status;
    },getIcon(priority) {
    switch (priority) {
      case 'Low':
        return 'sentiment_satisfied'; // green / relaxed icon
      case 'Medium':
        return 'warning'; // yellow / alert icon
      case 'High':
        return 'priority_high'; // orange / important icon
      case 'Urgent':
        return 'error'; // red / urgent icon
      default:
        return 'help_outline'; // fallback icon
    }
  }, getPriorityMeta(priority) {
    switch (priority) {
      case 'Low':
        return   'green' ;
      case 'Medium':
        return 'yellow' ;
      case 'High':
        return 'orange'
      case 'Urgent':
        return 'red'
      default:
        return 'grey'
    }
  }
  }
  ,
}
</script>

<style scoped>
.user-card {
  transition: all 0.3s ease;
  border-left: 4px solid #1976D2;
}
.user-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.task-card {
  transition: all 0.3s ease;
  border-left: 4px solid;
  height: 100%;
}
.task-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.status-pending { border-left-color: #FF9800; }
.status-in-progress { border-left-color: #2196F3; }
.status-completed { border-left-color: #4CAF50; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.q-badge { font-size: 12px; padding: 4px 8px; }
</style>
