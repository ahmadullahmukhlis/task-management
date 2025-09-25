<template>
  <q-layout view="hHh Lpr lff" class="bg-gray-100">
    <!-- Header -->
    <q-header elevated class="text-gray-800 bg-white border-b border-gray-200 shadow-sm">
      <q-toolbar>
        <q-btn flat round dense icon="menu" class="q-mr-sm" @click="toggleLeftDrawer" />

        <q-toolbar-title class="flex items-center">
          <div class="flex items-center justify-center w-8 h-8 font-bold text-white bg-purple-600 rounded-md q-mr-sm">C</div>
          ClickUp Clone
        </q-toolbar-title>

        <q-space />

        <div class="items-center row q-gutter-sm">
          <q-input
            dense
            standout
            v-model="search"
            placeholder="Search..."
            class="w-64 bg-gray-100 rounded-md"
          >
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>

          <q-btn flat round dense icon="notifications" />

          <q-avatar size="32px" class="text-white bg-green-500">U</q-avatar>
        </div>
      </q-toolbar>

      <q-tabs
        v-model="tab"
        inline-label
        class="bg-white text-grey-800"
        active-color="purple"
        indicator-color="purple"
      >
        <q-route-tab name="dashboard" icon="dashboard" label="Dashboard" />
        <q-route-tab name="tasks" icon="assignment" label="Tasks" />
        <q-route-tab name="calendar" icon="event" label="Calendar" />
        <q-route-tab name="docs" icon="description" label="Docs" />
      </q-tabs>
    </q-header>

    <!-- Left Drawer (Sidebar) -->
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="280"
      class="bg-white"
    >
      <q-scroll-area class="fit custom-scrollbar">
        <q-list padding class="text-grey-800">
          <!-- Workspace Section -->
          <q-item-label header class="text-sm font-semibold tracking-wider text-gray-500 uppercase">
            Workspace
          </q-item-label>

          <q-item clickable v-ripple class="q-py-sm">
            <q-item-section avatar>
              <q-avatar size="24px" color="blue" text-color="white">
                <q-icon name="work" size="16px" />
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label class="font-medium">My Workspace</q-item-label>
            </q-item-section>
          </q-item>

          <!-- Spaces Section -->
          <q-item-label header class="text-sm font-semibold tracking-wider text-gray-500 uppercase q-pt-md">
            Spaces
          </q-item-label>

          <q-item
            v-for="space in spaces"
            :key="space.id"
            clickable
            v-ripple
            class="q-py-xs"
          >
            <q-item-section avatar>
              <q-icon :name="space.icon" color="grey-6" size="20px" />
            </q-item-section>

            <q-item-section>
              <q-item-label>{{ space.name }}</q-item-label>
            </q-item-section>
          </q-item>

          <!-- Favorites Section -->
          <q-item-label header class="text-sm font-semibold tracking-wider text-gray-500 uppercase q-pt-md">
            Favorites
          </q-item-label>

          <q-item
            v-for="favorite in favorites"
            :key="favorite.id"
            clickable
            v-ripple
            class="q-py-xs"
          >
            <q-item-section avatar>
              <q-icon name="star" color="yellow-7" size="20px" />
            </q-item-section>

            <q-item-section>
              <q-item-label>{{ favorite.name }}</q-item-label>
            </q-item-section>
          </q-item>

          <!-- New Space Button -->
          <q-item clickable v-ripple class="text-purple-600 q-mt-md">
            <q-item-section avatar>
              <q-icon name="add" color="purple" size="20px" />
            </q-item-section>

            <q-item-section>
              <q-item-label class="font-medium text-purple-600">New Space</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <!-- Main Content -->
    <q-page-container>
      <q-page class="q-pa-md">
        <!-- Page Header -->
        <div class="q-mb-md">
          <h1 class="text-2xl font-bold text-gray-800 q-mb-xs">Dashboard</h1>
          <p class="text-gray-600">Overview of your tasks and projects</p>
        </div>

        <!-- Stats Cards -->
        <div class="row q-col-gutter-md q-mb-lg">
          <div class="col-12 col-sm-6 col-md-3" v-for="stat in stats" :key="stat.title">
            <q-card class="bg-white border-l-4 rounded-lg shadow-sm" :class="`border-${stat.color}`">
              <q-card-section class="q-pa-md">
                <div class="items-center justify-between row">
                  <div>
                    <div class="text-sm text-gray-500">{{ stat.title }}</div>
                    <div class="text-2xl font-bold text-gray-800">{{ stat.value }}</div>
                    <div class="mt-1 text-xs" :class="`text-${stat.trendColor}`">{{ stat.trend }}</div>
                  </div>

                  <q-avatar size="48px" :color="`${stat.color}-1`" text-color="white">
                    <q-icon :name="stat.icon" :color="stat.color" />
                  </q-avatar>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <!-- Task Lists -->
        <div class="row q-col-gutter-lg">
          <!-- My Tasks Column -->
          <div class="col-12 col-lg-6">
            <q-card class="bg-white rounded-lg shadow-sm">
              <q-card-section class="q-pa-none">
                <div class="items-center justify-between border-b border-gray-200 row q-pa-md">
                  <div class="text-lg font-semibold text-gray-800">My Tasks</div>
                  <q-btn flat label="View All" color="purple" size="sm" />
                </div>

                <q-list separator class="q-py-sm">
                  <q-item
                    v-for="task in myTasks"
                    :key="task.id"
                    class="cursor-pointer q-px-md q-py-md hover:bg-gray-50"
                  >
                    <q-item-section>
                      <q-item-label class="font-medium text-gray-800">{{ task.title }}</q-item-label>
                      <q-item-label caption class="text-gray-600 q-mt-xs">{{ task.description }}</q-item-label>

                      <div class="items-center justify-between row q-mt-sm">
                        <div class="items-center row q-gutter-md">
                          <div class="items-center row">
                            <q-icon name="event" size="16px" class="text-gray-500 q-mr-xs" />
                            <span class="text-xs text-gray-500">{{ task.dueDate }}</span>
                          </div>

                          <div class="items-center row">
                            <q-icon name="person" size="16px" class="text-gray-500 q-mr-xs" />
                            <span class="text-xs text-gray-500">{{ task.assignee }}</span>
                          </div>
                        </div>

                        <q-badge
                          :color="task.statusColor"
                          text-color="white"
                          class="text-xs rounded-full"
                        >
                          {{ task.statusText }}
                        </q-badge>
                      </div>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-card-section>
            </q-card>
          </div>

          <!-- Recent Activity Column -->
          <div class="col-12 col-lg-6">
            <q-card class="bg-white rounded-lg shadow-sm">
              <q-card-section class="q-pa-none">
                <div class="items-center justify-between border-b border-gray-200 row q-pa-md">
                  <div class="text-lg font-semibold text-gray-800">Recent Activity</div>
                  <q-btn flat label="View All" color="purple" size="sm" />
                </div>

                <q-list separator class="q-py-sm">
                  <q-item
                    v-for="activity in recentActivities"
                    :key="activity.id"
                    class="q-px-md q-py-md hover:bg-gray-50"
                  >
                    <q-item-section avatar>
                      <q-avatar size="32px" color="blue-1" text-color="blue">
                        <q-icon name="person" size="16px" />
                      </q-avatar>
                    </q-item-section>

                    <q-item-section>
                      <q-item-label class="text-sm text-gray-800">
                        <span class="font-medium">{{ activity.user }}</span> {{ activity.action }}
                      </q-item-label>
                      <q-item-label caption class="text-gray-500">{{ activity.time }}</q-item-label>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'taskPage',
  setup() {
    const leftDrawerOpen = ref(false)
    const tab = ref('dashboard')
    const search = ref('')

    const spaces = ref([
      { id: 1, name: 'Design Projects', icon: 'folder' },
      { id: 2, name: 'Development', icon: 'folder' },
      { id: 3, name: 'Marketing', icon: 'folder' },
      { id: 4, name: 'Operations', icon: 'folder' }
    ])

    const favorites = ref([
      { id: 1, name: 'Q4 Planning' },
      { id: 2, name: 'Website Redesign' }
    ])

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
      leftDrawerOpen,
      tab,
      search,
      spaces,
      favorites,
      stats,
      myTasks,
      recentActivities,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
}
</script>

<style scoped>
/* Custom scrollbar styling */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

/* Ensure proper border radius for cards */
.q-card {
  border-radius: 8px;
}

/* Custom badge styling */
.q-badge.rounded-full {
  border-radius: 12px;
  padding: 4px 8px;
}
</style>
