<template>
  <q-layout view="hHh Lpr fFf">

    <!-- Main Content -->
    <q-page-container>
      <q-page class="q-pa-md">
        <!-- Page Header -->
        <div class="items-center row q-mb-md">
          <div class="col">
            <div class="text-h4 text-weight-bold">Today's Tasks</div>
            <div class="text-grey-6"> 20 tasks</div>
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
                        <q-icon name="add" class="cursor-pointer"  @click="addTask" />

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

          <server-data :url="`tasks/project/${this.route.params.id}`"  v-slot="{ data }" id="tasks" >
        <div class="q-mb-xl">

           <div class="text-h6 q-mb-md">Pending List  {{ data.panding.length }}</div>
              <div class="task-list">
            <div
              v-for="task in data.panding"
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
                        <div v-if="task.created_by">
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
                                <q-item clickable v-close-popup @click="assign(task)">
                                  <q-item-section>Delete</q-item-section>
                                </q-item>
                                <q-separator />

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
        <div v-if="data.complate.length > 0">
          <div class="text-h6 q-mb-md">Completed ({{ data.length }})</div>

          <div class="task-list completed-tasks">
            <div
              v-for="task in data.complate"
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
              <div v-if="data.complate.length === 0 && data.panding.length === 0 " class="text-center q-pa-xl">
          <q-icon name="check_circle" size="64px" color="grey-4" />
          <div class="text-h6 text-grey-6 q-mt-md">No tasks yet</div>
          <div class="text-grey-6">Add your first task to get started!</div>
        </div>
          </server-data>



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
    <AssignModel   v-if="assignModelvr"
        :handle-modal="assignModelvr"
        :handleModelClose="closeModel"
        :project_id="this.route.params.id"
        :task="currentTask"
        />
</template>

<script>
import { api } from 'src/boot/axios'
import { useQuasar } from 'quasar'
import ServerData from 'src/components/ServerData.vue';
import { useRoute } from 'vue-router';
import { useGeneralStore } from 'src/stores/generalStore';
import AssignModel from './AssignModel.vue';

export default {
  name: 'TaskListApp',
  components : {
    ServerData ,AssignModel
  },

  data () {
    const q = useQuasar();
    const route = useRoute();
    const generalStore = useGeneralStore()
    return {
      leftDrawerOpen: true,
      newTaskTitle: '',
      showDueDatePicker: false,
      showPriorityDialog: false,
      showEditDialog: false,
      selectedDueDate: '',
      selectedPriority: 'Medium',
      activeMenu: 'today',
      activeProject: 1,
generalStore,
      editingTask: null,
      editTaskTitle: '',
      editTaskDescription: '',
      editDueDate: '',
      editPriority: 'Medium',
      q,
      route,
      assignModelvr : false ,
      currentTask :null,

      priorityOptions: [
        { label: 'Low', value: 'Low' },
        { label: 'Medium', value: 'Medium' },
        { label: 'High', value: 'High' },
        { label: 'Urgent', value: 'Urgent' }
      ]
    }
  },

  computed: {

    currentDate () {
      return new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  },

  methods: {
    async addTask () {
      if (!this.newTaskTitle.trim()) return
      try {
         const result =await api.post('tasks/add', {
          title: this.newTaskTitle.trim(),
          description: '',
          status: false,
          dueDate: this.selectedDueDate || '',
          type: this.selectedPriority,
          project_id: this.$route.params.id
        })
        this.q.notify({ message: result.data.message, color: 'green' })
         this.generalStore.revalidate('tasks')

      } catch (e) {
        console.error(e)
        this.q.notify({ message: e.message, color: 'red' })
      }
      this.newTaskTitle = ''
      this.selectedDueDate = ''
      this.selectedPriority = 'Medium'
    },

   async toggleTask (task) {
            try {
         const result =await api.post('tasks/complate/'+task.id, {})
        this.q.notify({ message: result.data.message, color: 'green' })
         this.generalStore.revalidate('tasks')

      } catch (e) {
        console.error(e)
        this.q.notify({ message: e.message, color: 'red' })
      }
    },

    editTask (task) {
      this.editingTask = task
      this.editTaskTitle = task.title
      this.editTaskDescription = task.description || ''
      this.editDueDate = task.dueDate || ''
      this.editPriority = task.priority || 'Medium'
      this.showEditDialog = true
    },

   async saveTask () {
      if (!this.editTaskTitle.trim()) return
      if (this.editingTask) {

           try {
         const result =await api.post('tasks/update/'+this.editingTask.id, {

         title: this.editTaskTitle.trim(),
            description: this.editTaskDescription,
            dueDate: this.editDueDate,
            type: this.editPriority
        })
        this.q.notify({ message: result.data.message, color: 'green' })
         this.generalStore.revalidate('tasks')

      } catch (e) {
        console.error(e)
        this.q.notify({ message: e.message, color: 'red' })
      }
      }
      this.closeEditDialog()
    },

    closeEditDialog () {
      this.showEditDialog = false
      this.editingTask = null
      this.editTaskTitle = ''
      this.editTaskDescription = ''
      this.editDueDate = ''
      this.editPriority = 'Medium'
    },

    assign (task) {
      this. assignModelvr = true
      this.currentTask  =task
    },
    closeModel(){
      this. assignModelvr = false
      this.currentTask  =null

    },

    setDueDate () {
      console.log('Due date set to:', this.selectedDueDate)
    },

    setPriority () {
      console.log('Priority set to:', this.selectedPriority)
    },

    formatDate (dateString) {
      if (!dateString) return ''
      const d = new Date(dateString)
      return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
    },

    getPriorityColor (priority) {
      const colors = {
        Low: 'green',
        Medium: 'blue',
        High: 'orange',
        Urgent: 'red'
      }
      return colors[priority] || 'grey'
    }
  },  mounted () {
    const generalStore = useGeneralStore()
    generalStore.setActivePage(this.route.params.id)
    generalStore.setPageTitle('all tasks')
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
