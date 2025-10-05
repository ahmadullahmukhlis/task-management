<template>
  <div class="p-12">
       <server-data :url="`tasks/load-real-time`" v-slot="{ data }" id="tasks">
            <div class="row q-mb-lg">
      <div :class="col-`col-${data.length}`">
        <q-card class="user-card q-pa-md" flat bordered>
          <div class="items-center row">
            <div class="col-auto">
              <q-avatar size="80px" class="q-mr-md">
                <img :src="user.avatar" :alt="user.name">
              </q-avatar>
            </div>
            <div class="col">
              <div class="text-h5 text-weight-bold">{{ user.name }}</div>
              <div class="text-subtitle1 text-grey-7">{{ user.position }}</div>
              <div class="text-caption text-grey-6 q-mt-xs">
                <q-icon name="email" size="16px" class="q-mr-xs" />
                {{ user.email }}
              </div>
              <div class="text-caption text-grey-6">
                <q-icon name="work" size="16px" class="q-mr-xs" />
                {{ user.department }}
              </div>
            </div>
            <div class="col-auto">
              <q-badge color="primary" :label="user.taskCount + ' tasks'" />
            </div>
          </div>
        </q-card>
      </div>
    </div>

    <!-- Tasks Section -->
    <div class="row">
      <div class="col-12">


        <!-- Task Filters -->

        <!-- Tasks List -->
        <div class="row q-col-gutter-md">
          <div
            v-for="task in filteredTasks"
            :key="task.id"
            class="col-12 col-md-6 col-lg-4"
          >
            <q-card
              class="task-card q-pa-md"
              flat
              bordered
              :class="`status-${task.status}`"
            >
              <div class="items-center row q-mb-sm">
                <div class="col">
                  <div class="text-h6 text-weight-bold">{{ task.title }}</div>
                </div>
                <div class="col-auto">
                  <q-badge
                    :color="getStatusColor(task.status)"
                    :label="formatStatus(task.status)"
                  />
                </div>
              </div>

              <div class="text-body2 q-mb-md task-description">
                {{ task.description }}
              </div>

              <div class="items-center row">
                <div class="col">
                  <div class="text-caption text-grey-6">
                    <q-icon name="event" size="14px" class="q-mr-xs" />
                    Due: {{ formatDate(task.dueDate) }}
                  </div>
                </div>
                <div class="col-auto">
                  <q-btn
                    flat
                    round
                    icon="more_vert"
                    size="sm"
                    color="grey-6"
                  >
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

        <!-- Empty State -->
        <div v-if="filteredTasks.length === 0" class="text-center q-pa-xl">
          <q-icon name="check_circle" size="80px" color="grey-4" />
          <div class="text-h6 text-grey-6 q-mt-md">No tasks found</div>
          <div class="text-body2 text-grey-5">Try changing your filters</div>
        </div>
      </div>
    </div>
       </server-data>
     <!-- User Information Section -->

  </div>
</template>

<script>
import ServerData from 'src/components/ServerData.vue';
import { useGeneralStore } from 'src/stores/generalStore';
export default {
  name: "RealTaskDashboardPage",
  components: {ServerData},
data() {
   const generalStore = useGeneralStore()
    return {
      filter: 'all',
      generalStore,
      user: {
        name: 'John Doe',
        position: 'Senior Developer',
        email: 'john.doe@company.com',
        department: 'Engineering',
        avatar: 'https://cdn.quasar.dev/img/avatar.png',
        taskCount: 8
      },
      tasks: [
        {
          id: 1,
          title: 'Design Dashboard UI',
          description: 'Create wireframes and mockups for the new admin dashboard with focus on user experience and modern design principles.',
          status: 'in-progress',
          dueDate: '2023-12-15'
        },
        {
          id: 2,
          title: 'API Integration',
          description: 'Integrate the backend API endpoints with the frontend application and handle error cases.',
          status: 'pending',
          dueDate: '2023-12-20'
        },
        {
          id: 3,
          title: 'User Authentication',
          description: 'Implement secure user authentication system with JWT tokens and refresh token mechanism.',
          status: 'completed',
          dueDate: '2023-12-10'
        },
        {
          id: 4,
          title: 'Mobile Responsive Design',
          description: 'Ensure the application is fully responsive and works perfectly on all device sizes.',
          status: 'in-progress',
          dueDate: '2023-12-18'
        },
        {
          id: 5,
          title: 'Database Optimization',
          description: 'Optimize database queries and add proper indexing for better performance.',
          status: 'pending',
          dueDate: '2023-12-25'
        },
        {
          id: 6,
          title: 'Testing Suite',
          description: 'Write comprehensive unit tests and integration tests for critical components.',
          status: 'pending',
          dueDate: '2023-12-22'
        },
        {
          id: 7,
          title: 'Documentation',
          description: 'Create detailed documentation for the codebase and API endpoints.',
          status: 'completed',
          dueDate: '2023-12-08'
        },
        {
          id: 8,
          title: 'Deployment Setup',
          description: 'Set up CI/CD pipeline and configure production deployment environment.',
          status: 'in-progress',
          dueDate: '2023-12-28'
        }
      ]
    }
  },
  mounted() {

this.$echo
  .channel('add-task')
  .listen('.TaskEvent', e => {
    console.log('Got TaskEvent:', e);
  });

  },
  computed: {
    filteredTasks() {
      if (this.filter === 'all') {
        return this.tasks
      }
      return this.tasks.filter(task => task.status === this.filter)
    },
    pendingTasks() {
      return this.tasks.filter(task => task.status === 'pending')
    },
    inProgressTasks() {
      return this.tasks.filter(task => task.status === 'in-progress')
    },
    completedTasks() {
      return this.tasks.filter(task => task.status === 'completed')
    }
  },
  methods: {
    getStatusColor(status) {
      const colors = {
        'pending': 'orange',
        'in-progress': 'blue',
        'completed': 'green'
      }
      return colors[status] || 'grey'
    },
    formatStatus(status) {
      const statusMap = {
        'pending': 'Pending',
        'in-progress': 'In Progress',
        'completed': 'Completed'
      }
      return statusMap[status] || status
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' }
      return new Date(dateString).toLocaleDateString('en-US', options)
    }
  }
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

.status-pending {
  border-left-color: #FF9800;
}

.status-in-progress {
  border-left-color: #2196F3;
}

.status-completed {
  border-left-color: #4CAF50;
}

.task-description {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 60px;
}

.q-badge {
  font-size: 12px;
  padding: 4px 8px;
}
</style>
