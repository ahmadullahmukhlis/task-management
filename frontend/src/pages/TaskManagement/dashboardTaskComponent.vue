<template>
  <div class="min-h-screen p-6 bg-gray-100">
    <!-- Page Header -->
    <div class="mb-6">
      <h1 class="mb-2 text-2xl font-bold text-gray-800">Dashboard</h1>
      <p class="text-gray-600">Overview of your tasks and projects</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-4">
      <div
        v-for="stat in stats"
        :key="stat.title"
        class="p-4 bg-white border-l-4 rounded-lg shadow-sm"
        :class="`border-${stat.color}-500`"
      >
        <div class="flex items-start justify-between">
          <div>
            <p class="text-sm text-gray-500">{{ stat.title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ stat.value }}</p>
          </div>
          <div class="p-2 rounded-md" :class="`bg-${stat.color}-100`">
            <q-icon :name="stat.icon" :class="`text-${stat.color}-500`" />
          </div>
        </div>
        <p class="mt-2 text-xs" :class="`text-${stat.trendColor}-500`">{{ stat.trend }}</p>
      </div>
    </div>

    <!-- Task Lists -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- My Tasks -->
      <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
          <h3 class="font-semibold text-gray-800">My Tasks</h3>
          <q-btn
            flat
            label="View All"
            color="purple"
            size="sm"
            no-caps
          />
        </div>
        <div class="divide-y divide-gray-100">
          <div
            v-for="task in myTasks"
            :key="task.id"
            class="p-4 cursor-pointer hover:bg-gray-50"
          >
            <div class="flex items-start justify-between mb-2">
              <h4 class="font-medium text-gray-800">{{ task.title }}</h4>
              <q-badge
                :color="task.statusColor"
                text-color="white"
                class="rounded-full"
              >
                {{ task.statusText }}
              </q-badge>
            </div>
            <p class="mb-3 text-sm text-gray-600">{{ task.description }}</p>
            <div class="flex items-center justify-between text-xs text-gray-500">
              <div class="flex items-center">
                <q-icon name="event" size="16px" class="mr-1" />
                <span>{{ task.dueDate }}</span>
              </div>
              <div class="flex items-center">
                <q-icon name="person" size="16px" class="mr-1" />
                <span>{{ task.assignee }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
          <h3 class="font-semibold text-gray-800">Recent Activity</h3>
          <q-btn
            flat
            label="View All"
            color="purple"
            size="sm"
            no-caps
          />
        </div>
        <div class="divide-y divide-gray-100">
          <div
            v-for="activity in recentActivities"
            :key="activity.id"
            class="p-4 hover:bg-gray-50"
          >
            <div class="flex items-start">
              <div class="flex items-center justify-center w-8 h-8 mt-1 mr-3 text-blue-600 bg-blue-100 rounded-full">
                <q-icon name="person" size="16px" />
              </div>
              <div>
                <p class="text-sm text-gray-800">
                  <span class="font-medium">{{ activity.user }}</span> {{ activity.action }}
                </p>
                <p class="mt-1 text-xs text-gray-500">{{ activity.time }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Projects Section -->
    <div class="mt-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">Projects</h2>
        <q-btn
          label="New Project"
          color="purple"
          icon="add"
          no-caps
          @click="openProject(null)"
        />
      </div>

          <ServerData
            url="projects"
            v-slot="{ data }"
            id="project"
        >
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

           <q-card
          v-for="project in data"
          :key="project.id"
          class="transition-shadow bg-white rounded-lg shadow-sm cursor-pointer hover:shadow-md"
        >
          <q-card-section class="p-4">
            <div class="flex justify-between mb-3">
              <div>
                        <div
                class="flex items-center justify-center w-10 h-10 mr-3 font-bold text-white rounded-md"
                :class="project.color"
              >

                 {{ project.initials }}

              </div>
              <div>
                <h4 class="font-semibold text-gray-800">{{ project.name }}</h4>
                <p class="text-xs text-gray-500">{{ project.tasks }} tasks</p>
              </div>
              </div>

            <div >
    <q-btn  icon="more_vert" flat
  dense  >
      <q-menu persistent auto-close>
        <q-list style="min-width: 100px">
          <q-item clickable>
            <q-item-section @click="openProject(project)">edit</q-item-section>
          </q-item>
          <q-item clickable @click="opentUser(project)">
           Add User
          </q-item>

        </q-list>
      </q-menu>
    </q-btn>
  </div>
            </div>

            <p class="mb-4 text-sm text-gray-600" v-html="project.description"></p>

            <div class="flex items-center justify-between">
              <div class="flex -space-x-2">
                <q-avatar
                  v-for="member in project.members"
                  :key="member"
                  size="24px"
                  class="border-2 border-white"
                  :color="member.color"
                  text-color="white"
                >
                  {{ member.initials }}
                </q-avatar>
              </div>

              <div class="text-xs text-gray-500">
                {{ project.progress }}% complete
              </div>
            </div>

            <q-linear-progress
              :value="project.progress / 100"
              :color="project.progressColor"
              class="q-mt-2"
            />
          </q-card-section>
        </q-card>
      </div>
        </ServerData>

    </div>
  </div>
  <ProjectFormModel   v-if="projectModel"
        :handle-modal="projectModel"
        :handleModelClose="closeModel"
        :project="project"
        />
          <AddUserToProject   v-if="userModel"
        :handle-modal="userModel"
        :handleModelClose="closeUserModel"
        :project="project"
        />
</template>

<script>
import { ref } from 'vue'
import ProjectFormModel from './ProjectFormModel.vue'
import ServerData from 'src/components/ServerData.vue'
import AddUserToProject from './project/AddUserToProject.vue'

export default {
  name: 'dashboardTaskComponent',
  components:{ProjectFormModel , ServerData ,AddUserToProject},
  setup() {
    const stats = ref([
      {
        title: 'Total Tasks',
        value: '42',
        icon: 'assignment',
        color: 'blue',
        trend: '+2 from last week',
        trendColor: 'green'
      },
      {
        title: 'Completed',
        value: '18',
        icon: 'check_circle',
        color: 'green',
        trend: '+5 from last week',
        trendColor: 'green'
      },
      {
        title: 'In Progress',
        value: '12',
        icon: 'autorenew',
        color: 'yellow',
        trend: '-3 from last week',
        trendColor: 'red'
      },
      {
        title: 'Overdue',
        value: '4',
        icon: 'warning',
        color: 'red',
        trend: '+1 from last week',
        trendColor: 'red'
      }
    ])

    const myTasks = ref([
      {
        id: 1,
        title: 'Create dashboard mockup',
        description: 'Design the main dashboard interface with Tailwind CSS',
        statusText: 'In Progress',
        statusColor: 'blue',
        dueDate: 'Tomorrow',
        assignee: 'You'
      },
      {
        id: 2,
        title: 'Implement user authentication',
        description: 'Set up login and registration functionality',
        statusText: 'To Do',
        statusColor: 'grey-6',
        dueDate: 'Sep 30',
        assignee: 'Alex'
      },
      {
        id: 3,
        title: 'Fix mobile responsiveness',
        description: 'Ensure the app works well on all screen sizes',
        statusText: 'In Review',
        statusColor: 'yellow',
        dueDate: 'Today',
        assignee: 'You'
      },
      {
        id: 4,
        title: 'Write API documentation',
        description: 'Document all endpoints for the backend API',
        statusText: 'Completed',
        statusColor: 'green',
        dueDate: 'Sep 25',
        assignee: 'Sam'
      }
    ])

    const recentActivities = ref([
      {
        id: 1,
        user: 'Alex Johnson',
        action: 'completed the task "Update user profile page"',
        time: '2 hours ago'
      },
      {
        id: 2,
        user: 'You',
        action: 'commented on "Dashboard design discussion"',
        time: '4 hours ago'
      },
      {
        id: 3,
        user: 'Sam Wilson',
        action: 'assigned you a task "Fix mobile responsiveness"',
        time: 'Yesterday'
      },
      {
        id: 4,
        user: 'Taylor Smith',
        action: 'created a new space "Marketing Campaigns"',
        time: '2 days ago'
      }
    ])


    return {
      stats,
      myTasks,
      recentActivities,

    }
  },data(){
    return {
      projectModel :false ,
      open : false ,
      project:null ,
      userModel:false,

    }
  },
      methods: {
        closeModel(){
          this.projectModel =false
          this.project =null
        },openProject(project = null) {
          this.projectModel = true;
          this.project =project

        }
        ,closeUserModel(){
          this.userModel = false
        } ,
        opentUser(project) {
          this.userModel = true
          this.project = project
        }
      }
}
</script>

<style scoped>
/* Custom styling for badges */
.q-badge.rounded-full {
  border-radius: 12px;
  padding: 4px 8px;
  font-size: 11px;
}

/* Smooth transitions for hover effects */
.q-card {
  transition: box-shadow 0.2s ease-in-out;
}
</style>
