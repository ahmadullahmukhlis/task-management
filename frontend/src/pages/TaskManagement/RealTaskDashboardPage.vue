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
              <q-avatar
                size="80px"
                class="mr-4"
                :style="{ backgroundColor: getUserColor(user.name) }"
              >
                <template v-if="user.image">
                  <img :src="user.image" :alt="user.name" @error="user.image = null" />
                </template>
                <template v-else>
                  <span class="text-2xl font-bold text-white">
                    {{ user.icon }}
                  </span>
                </template>
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
                      <q-badge color="green" :label="task.project" />
                    </div>
                  </div>

                  <div class="flex items-center mb-2">
                    <div class="flex-1 text-lg font-semibold">
                      <q-badge color="info" :label="task.status" />
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
                            <q-item clickable v-close-popup @click="openDetail(task)">
                              <q-item-section >view</q-item-section>
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
      <TaskDetails
      v-if="taskDetailModel"
      :handle-modal="taskDetailModel"
      :handleModelClose="closeDetail"
      :task="taskinfo"
    />
</template>

<script>
import ServerData from 'src/components/ServerData.vue';
import { useGeneralStore } from 'src/stores/generalStore';
import TaskDetails from './TaskDetails.vue';

export default {
  name: "RealTaskDashboardPage",
  components: { ServerData ,TaskDetails },
  data (){
     const generalStore = useGeneralStore()
    return {
      generalStore,
       taskDetailModel: false,taskinfo:null
    }
  },
  mounted() {
    this.$echo.channel('add-task').listen('.TaskEvent', e => {
      const audio = new Audio('/notification.wav');
audio.play();
       this.generalStore.revalidate('tasks');
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
    },
    getIcon(priority) {
      switch (priority) {
        case 'Low': return 'sentiment_satisfied';
        case 'Medium': return 'warning';
        case 'High': return 'priority_high';
        case 'Urgent': return 'error';
        default: return 'help_outline';
      }
    },
    getPriorityMeta(priority) {
      switch (priority) {
        case 'Low': return 'green';
        case 'Medium': return 'yellow';
        case 'High': return 'orange';
        case 'Urgent': return 'red';
        default: return 'grey';
      }
    },
    getUserColor(name) {
      if (!name) return '#888888';
      let hash = 0;
      for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
      }
      const color = `hsl(${hash % 360}, 70%, 50%)`;
      return color;
    },    openDetail(task) {
      this.taskDetailModel = true;
      this.taskinfo = task;
    },
    closeDetail() {
      this.taskDetailModel = false;
      this.taskinfo = null;
    },
  }
};
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
