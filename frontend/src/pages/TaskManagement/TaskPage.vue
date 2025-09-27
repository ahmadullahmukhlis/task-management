<template>
  <q-layout view="hHh Lpr fFf">

    <!-- Main Content -->
    <q-page-container>
      <q-page class="q-pa-md">
        <!-- Page Header -->
        <div class="items-center row q-mb-md">
          <div class="col">
            <div class="text-h4 text-weight-bold">Today's Tasks</div>
            <div class="text-grey-6">{{ currentDate }} • {{ pendingTasks.length }} tasks</div>
          </div>
          <div class="col-auto">
            <q-btn-group rounded>
              <q-btn color="primary" icon="view_list" label="List" />
              <q-btn color="grey-4" text-color="black" icon="calendar_today" label="Calendar" />
              <q-btn color="grey-4" text-color="black" icon="dashboard" label="Board" />
            </q-btn-group>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row q-mb-lg">
          <div class="col-12">
            <q-card flat bordered class="bg-blue-1">
              <q-card-section class="q-pa-sm">
                <div class="items-center row">
                  <div class="col">
                    <q-input
                      v-model="newTaskTitle"
                      placeholder="Add a new task..."
                      dense
                      borderless
                      @keyup.enter="addTask"
                    >
                      <template v-slot:prepend>
                        <q-icon name="add" class="cursor-pointer" @click="addTask" />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-auto">
                    <q-btn
                      flat
                      round
                      icon="schedule"
                      class="q-mr-sm"
                      @click="showDueDatePicker = true"
                    />
                    <q-btn flat round icon="flag" @click="showPriorityDialog = true" />
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <!-- Task List -->
        <div class="q-mb-xl">
          <div class="text-h6 q-mb-md">Pending List ({{ pendingTasks.length }})</div>

          <div class="task-list">
            <div
              v-for="task in pendingTasks"
              :key="task.id"
              class="q-mb-sm"
            >
              <q-card class="task-card" flat bordered>
                <q-card-section class="q-pa-sm">
                  <div class="items-center row">
                    <!-- Checkbox -->
                    <div class="col-auto q-px-sm">
                      <q-checkbox
                        :model-value="task.completed"
                        @update:model-value="toggleTask(task)"
                        color="primary"
                      />
                    </div>

                    <!-- Task Content -->
                    <div class="col">
                      <div class="items-center row">
                        <div class="col">
                          <div
                            :class="['task-title', task.completed ? 'text-strike text-grey-6' : '']"
                          >
                            {{ task.title }}
                          </div>
                          <div v-if="task.description" class="task-description text-caption text-grey-6">
                            {{ task.description }}
                          </div>

                          <!-- Task Meta -->
                          <div class="items-center row q-mt-xs">
                            <div class="col-auto" v-if="task.dueDate">
                              <q-badge outline color="orange" class="q-mr-sm">
                                <q-icon name="schedule" size="12px" class="q-mr-xs" />
                                {{ formatDate(task.dueDate) }}
                              </q-badge>
                            </div>
                            <div class="col-auto" v-if="task.priority">
                              <q-badge
                                outline
                                :color="getPriorityColor(task.priority)"
                                class="q-mr-sm"
                              >
                                <q-icon name="flag" size="12px" class="q-mr-xs" />
                                {{ task.priority }}
                              </q-badge>
                            </div>
                            <div class="col-auto" v-if="task.tags && task.tags.length">
                              <q-badge
                                v-for="tag in task.tags"
                                :key="tag"
                                outline
                                color="blue"
                                class="q-mr-sm"
                              >
                                {{ tag }}
                              </q-badge>
                            </div>
                          </div>
                        </div>

                        <!-- Task Actions -->
                        <div class="col-auto">
                          <q-btn
                            flat
                            round
                            dense
                            icon="more_vert"
                            size="sm"
                          >
                            <q-menu>
                              <q-list style="min-width: 150px">
                                <q-item clickable v-close-popup @click="editTask(task)">
                                  <q-item-section>Edit</q-item-section>
                                </q-item>
                                <q-item clickable v-close-popup @click="deleteTask(task)">
                                  <q-item-section>Delete</q-item-section>
                                </q-item>
                                <q-separator />
                                <q-item clickable v-close-popup>
                                  <q-item-section>Duplicate</q-item-section>
                                </q-item>
                              </q-list>
                            </q-menu>
                          </q-btn>
                        </div>
                      </div>
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </div>

        <!-- Completed Tasks Section -->
        <div v-if="completedTasks.length > 0">
          <div class="text-h6 q-mb-md">Completed ({{ completedTasks.length }})</div>

          <div class="task-list completed-tasks">
            <div
              v-for="task in completedTasks"
              :key="task.id"
              class="q-mb-sm"
            >
              <q-card class="task-card completed" flat bordered>
                <q-card-section class="q-pa-sm">
                  <div class="items-center row">
                    <div class="col-auto q-px-sm">
                      <q-checkbox
                        :model-value="task.completed"
                        @update:model-value="toggleTask(task)"
                        color="green"
                      />
                    </div>
                    <div class="col">
                      <div class="task-title text-strike text-grey-6">
                        {{ task.title }}
                      </div>
                      <div v-if="task.description" class="task-description text-caption text-grey-6">
                        {{ task.description }}
                      </div>
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="tasks.length === 0" class="text-center q-pa-xl">
          <q-icon name="check_circle" size="64px" color="grey-4" />
          <div class="text-h6 text-grey-6 q-mt-md">No tasks yet</div>
          <div class="text-grey-6">Add your first task to get started!</div>
        </div>
      </q-page>
    </q-page-container>

    <!-- Due Date Dialog -->
    <q-dialog v-model="showDueDatePicker">
      <q-card style="width: 320px">
        <q-card-section>
          <div class="text-h6">Set Due Date</div>
        </q-card-section>
        <q-card-section>
          <q-date v-model="selectedDueDate" minimal />
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn flat label="Set" color="primary" @click="setDueDate" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!-- Priority Dialog -->
    <q-dialog v-model="showPriorityDialog">
      <q-card style="width: 200px">
        <q-card-section>
          <div class="text-h6">Set Priority</div>
        </q-card-section>
           <q-card-section>
              <q-option-group
            :options="priorityOptions"
            type="radio"
            v-model="selectedPriority"
          />
        </q-card-section>


        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn flat label="Set" color="primary" @click="setPriority" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!-- Edit Task Dialog -->
    <q-dialog v-model="showEditDialog" persistent>
      <q-card style="width: 500px; max-width: 90vw;">
        <q-card-section>
          <div class="text-h6">{{ editingTask ? 'Edit Task' : 'Add Task' }}</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-input
            v-model="editTaskTitle"
            label="Task title"
            class="q-mb-md"
            autofocus
          />

          <q-input
            v-model="editTaskDescription"
            label="Description"
            type="textarea"
            class="q-mb-md"
          />

          <div class="row q-mb-md">
            <div class="col-6">
              <q-input
                v-model="editDueDate"
                label="Due Date"
                readonly
              >
                <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy>
                      <q-date v-model="editDueDate" minimal />
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-6 q-pl-md">
              <q-select
                v-model="editPriority"
                :options="priorityOptions.map(p => p.label)"
                label="Priority"
              />
            </div>
          </div>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn flat label="Save" color="primary" @click="saveTask" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script>
import { ref, computed, onMounted } from 'vue'

export default {
  name: 'TaskListApp',
  setup() {
    // State
    const leftDrawerOpen = ref(true)
    const newTaskTitle = ref('')
    const showDueDatePicker = ref(false)
    const showPriorityDialog = ref(false)
    const showEditDialog = ref(false)
    const selectedDueDate = ref('')
    const selectedPriority = ref('Medium')
    const activeMenu = ref('today')
    const activeProject = ref(1)

    // Edit task state
    const editingTask = ref(null)
    const editTaskTitle = ref('')
    const editTaskDescription = ref('')
    const editDueDate = ref('')
    const editPriority = ref('Medium')

    // Static data
    const tasks = ref([
      {
        id: 1,
        title: 'Design new dashboard layout',
        description: 'Create wireframes and mockups for the new dashboard',
        completed: false,
        dueDate: '2024/09/28',
        priority: 'High',
        tags: ['Design', 'UI/UX']
      },
      {
        id: 2,
        title: 'Implement user authentication',
        description: 'Set up login and registration functionality',
        completed: false,
        dueDate: '2024/09/30',
        priority: 'Medium',
        tags: ['Backend', 'Security']
      },
      {
        id: 3,
        title: 'Write documentation for API',
        description: 'Create comprehensive API documentation for developers',
        completed: false,
        dueDate: '2024/10/02',
        priority: 'Low',
        tags: ['Documentation']
      },
      {
        id: 4,
        title: 'Meeting with design team',
        description: 'Weekly sync with design team about new features',
        completed: true,
        dueDate: '2024/09/26',
        priority: 'Medium',
        tags: ['Meeting', 'Design']
      },
      {
        id: 5,
        title: 'Fix mobile responsive issues',
        description: 'Address CSS issues on mobile devices',
        completed: false,
        dueDate: '2024/09/29',
        priority: 'High',
        tags: ['Frontend', 'CSS']
      },
      {
        id: 6,
        title: 'Setup CI/CD pipeline',
        description: 'Configure continuous integration and deployment',
        completed: true,
        dueDate: '2024/09/25',
        priority: 'Medium',
        tags: ['DevOps', 'CI/CD']
      }
    ])

    const projects = ref([
      { id: 1, name: 'Website Redesign', icon: 'public', color: 'blue', count: 12 },
      { id: 2, name: 'Mobile App', icon: 'phone_iphone', color: 'green', count: 8 },
      { id: 3, name: 'Marketing Campaign', icon: 'campaign', color: 'orange', count: 5 },
      { id: 4, name: 'API Development', icon: 'code', color: 'purple', count: 3 },
      { id: 5, name: 'Customer Portal', icon: 'people', color: 'teal', count: 7 }
    ])

    const priorityOptions = [
      { label: 'Low', value: 'Low' },
      { label: 'Medium', value: 'Medium' },
      { label: 'High', value: 'High' },
      { label: 'Urgent', value: 'Urgent' }
    ]

    // Computed properties
    const pendingTasks = computed(() => {
      return tasks.value.filter(task => !task.completed)
    })

    const completedTasks = computed(() => {
      return tasks.value.filter(task => task.completed)
    })

    const currentDate = computed(() => {
      return new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    })

    // Methods
    const addTask = () => {
      if (newTaskTitle.value.trim()) {
        tasks.value.unshift({
          id: Date.now(),
          title: newTaskTitle.value.trim(),
          description: '',
          completed: false,
          dueDate: selectedDueDate.value || '',
          priority: selectedPriority.value,
          tags: []
        })
        newTaskTitle.value = ''
        selectedDueDate.value = ''
        selectedPriority.value = 'Medium'
      }
    }

    const toggleTask = (task) => {
      const taskIndex = tasks.value.findIndex(t => t.id === task.id)
      if (taskIndex !== -1) {
        tasks.value[taskIndex].completed = !tasks.value[taskIndex].completed
      }
    }

    const editTask = (task) => {
      editingTask.value = task
      editTaskTitle.value = task.title
      editTaskDescription.value = task.description || ''
      editDueDate.value = task.dueDate || ''
      editPriority.value = task.priority || 'Medium'
      showEditDialog.value = true
    }

    const saveTask = () => {
      if (editTaskTitle.value.trim()) {
        if (editingTask.value) {
          // Update existing task
          const taskIndex = tasks.value.findIndex(t => t.id === editingTask.value.id)
          if (taskIndex !== -1) {
            tasks.value[taskIndex] = {
              ...tasks.value[taskIndex],
              title: editTaskTitle.value.trim(),
              description: editTaskDescription.value,
              dueDate: editDueDate.value,
              priority: editPriority.value
            }
          }
        } else {
          // Add new task
          tasks.value.unshift({
            id: Date.now(),
            title: editTaskTitle.value.trim(),
            description: editTaskDescription.value,
            completed: false,
            dueDate: editDueDate.value,
            priority: editPriority.value,
            tags: []
          })
        }
        closeEditDialog()
      }
    }

    const closeEditDialog = () => {
      showEditDialog.value = false
      editingTask.value = null
      editTaskTitle.value = ''
      editTaskDescription.value = ''
      editDueDate.value = ''
      editPriority.value = 'Medium'
    }

    const deleteTask = (task) => {
      tasks.value = tasks.value.filter(t => t.id !== task.id)
    }

    const setDueDate = () => {
      // Implementation for setting due date
      console.log('Due date set to:', selectedDueDate.value)
    }

    const setPriority = () => {
      // Implementation for setting priority
      console.log('Priority set to:', selectedPriority.value)
    }

    const addProject = () => {
      const newProject = {
        id: projects.value.length + 1,
        name: `New Project ${projects.value.length + 1}`,
        icon: 'folder',
        color: 'grey',
        count: 0
      }
      projects.value.push(newProject)
    }

    const formatDate = (dateString) => {
      if (!dateString) return ''
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
    }

    const getPriorityColor = (priority) => {
      const colors = {
        'Low': 'green',
        'Medium': 'blue',
        'High': 'orange',
        'Urgent': 'red'
      }
      return colors[priority] || 'grey'
    }

    return {
      leftDrawerOpen,
      newTaskTitle,
      showDueDatePicker,
      showPriorityDialog,
      showEditDialog,
      selectedDueDate,
      selectedPriority,
      activeMenu,
      activeProject,
      editingTask,
      editTaskTitle,
      editTaskDescription,
      editDueDate,
      editPriority,
      tasks,
      projects,
      priorityOptions,
      pendingTasks,
      completedTasks,
      currentDate,
      addTask,
      toggleTask,
      editTask,
      saveTask,
      deleteTask,
      setDueDate,
      setPriority,
      addProject,
      formatDate,
      getPriorityColor,
      closeEditDialog
    }
  }
}
</script>

<style scoped>
.active-menu {
  background-color: #e3f2fd;
  color: #1976d2;
  border-right: 3px solid #1976d2;
}

.q-item--active {
  background-color: #e3f2fd;
  color: #1976d2;
  border-right: 3px solid #1976d2;
}

.task-list {
  min-height: 20px;
}

.task-card {
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
}

.task-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-left: 3px solid #1976d2;
}

.task-card.completed {
  opacity: 0.7;
  background-color: #fafafa;
}

.task-title {
  font-size: 14px;
  font-weight: 500;
  line-height: 1.4;
}

.task-description {
  font-size: 12px;
  margin-top: 2px;
  line-height: 1.3;
}

.text-strike {
  text-decoration: line-through;
}

.completed-tasks {
  opacity: 0.8;
}

/* Custom badge styles */
.q-badge {
  font-size: 10px;
  padding: 2px 6px;
}

/* Responsive adjustments */
@media (max-width: 600px) {
  .text-h4 {
    font-size: 1.5rem;
  }

  .q-btn-group {
    flex-direction: column;
  }

  .q-btn-group .q-btn {
    margin-bottom: 4px;
  }
}
</style>
