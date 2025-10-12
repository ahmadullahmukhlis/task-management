<template>
  <q-layout view="hHh Lpr fFf">

    <!-- Main Content -->
    <q-page-container>
      <q-page class="q-pa-md">
        <!-- Page Header -->
        <div class="items-center row q-mb-md">
          <div class="col">
            <div class="text-h4 text-weight-bold">All Tasks</div>
            <div class="text-grey-6">all pending and Completed tasks</div>
          </div>
        </div>
        <ProtectedComponent permission-key="task-create-task">
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
                    <q-btn flat round icon="group" class="q-mr-sm" @click="loadUser" />
                    <q-btn flat round icon="schedule" class="q-mr-sm" @click="showDueDatePicker = true" />
                    <q-btn flat round icon="flag" @click="showPriorityDialog = true" />
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
        </ProtectedComponent>
        <!-- Quick Actions / Add Task -->


        <!-- Task List -->
        <server-data :url="`tasks/project/${route.params.id}`" v-slot="{ data }" id="tasks">
          <div class="q-mb-xl">
            <div class="text-h6 q-mb-md">Pending List {{ pendingTasks(data)?.length }}</div>
            <div class="task-list">
              <div v-for="task in pendingTasks(data)" :key="task.id" class="q-mb-sm">
                <q-card class="task-card" flat bordered>
                  <q-card-section class="q-pa-sm">
                    <div class="items-center row">
                      <div class="col-auto q-px-sm">
                        <q-checkbox
                          :model-value="task.completed"
                          @update:model-value="toggleTask(task ,'Complete')"
                          color="primary"
                        />
                      </div>

                      <div class="col">
                        <div class="items-center row">
                          <div class="col">
                            <div :class="['task-title', task.completed ? 'text-strike text-grey-6' : '']">
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
                                  {{ (task.dueDate) }}
                                </q-badge>
                              </div>
                              <div class="col-auto" v-if="task.priority">
                                <q-badge outline :color="getPriorityColor(task.priority)" class="q-mr-sm">
                                  <q-icon name="flag" size="12px" class="q-mr-xs" />
                                  {{ task.priority }}
                                </q-badge>
                              </div>
                            </div>

                            <!-- Assigned Users -->
                            <div class="flex mt-1 -space-x-2">
                              <q-avatar
                                v-for="member in task.assign || []"
                                :key="member.id"
                                size="28px"
                                class="border-2 border-white cursor-pointer"
                                :color="member.color"
                                text-color="white"
                                @click="removeUser(task.id,member.id)"
                              >
                                {{ member.initials }}
                              </q-avatar>
                            </div>
                          </div>

                          <!-- Task Actions -->
                          <div>
                            <q-btn flat round dense icon="more_vert" size="sm">
                              <q-menu>
                                  <q-list>
                                  <q-item clickable v-close-popup @click="openDetail(task)">
                                    <q-item-section>comment</q-item-section>
                                  </q-item>
                                </q-list>
                                <q-list>
                                  <q-item clickable v-close-popup @click="openDetail(task)">
                                    <q-item-section>View</q-item-section>
                                  </q-item>
                                </q-list>
                                <q-list style="min-width: 150px" v-if="task.created_by">
                                  <q-item clickable v-close-popup @click="editTask(task)">
                                    <q-item-section>Edit</q-item-section>
                                  </q-item>
                                  <q-item clickable v-close-popup @click="assign(task)">
                                    <q-item-section>Assign User</q-item-section>
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

          <!-- Completed Tasks -->
          <div v-if="completedTasks(data)?.length > 0">
            <div class="text-h6 q-mb-md">Completed ({{ completedTasks(data)?.lengt }})</div>
            <div class="task-list completed-tasks">
                 <div v-for="task in completedTasks(data)" :key="task.id" class="q-mb-sm">
                <q-card class="task-card completed" flat bordered>
                  <q-card-section class="q-pa-sm">
                    <div class="items-center row">
                      <div class="col-auto q-px-sm">
                        <q-checkbox
                          :model-value="task.completed"
                          @update:model-value="toggleTask(task ,'Pending')"
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

          <!-- No Tasks -->
          <div v-if="completedTasks(data)?.length === 0 && pendingTasks(data)?.length === 0" class="text-center q-pa-xl">
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

    <!-- Assign Users Dialog -->
    <q-dialog v-model="addAssignModel">
      <q-card style="width: 420px">
        <q-card-section>
          <div class="text-h6">Assign Task</div>
        </q-card-section>
        <q-card-section>
          <q-select
          outlined
            v-model="peopleSelected"
            :options="people.map(u => ({ label: u.name, value: u.id }))"
            option-label="label"
            option-value="value"
            multiple
            emit-value
            map-options
          />
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn flat label="Set" color="primary" @click="assigny" v-close-popup />
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
          <q-option-group :options="priorityOptions" type="radio" v-model="selectedPriority" />
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
          <q-input v-model="editTaskTitle" label="Task title" class="q-mb-md" autofocus />
          <q-input v-model="editTaskDescription" label="Description" type="textarea" class="q-mb-md" />

          <div class="row q-mb-md">
            <div class="col-6">
              <q-input v-model="editDueDate" label="Due Date" readonly>
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
              <q-select v-model="editPriority" :options="priorityOptions.map(p => p.label)" label="Priority" />
            </div>
          </div>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn flat label="Save" color="primary" @click="saveTask" />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <!-- Assign & Task Details Components -->
    <AssignModel
      v-if="assignModelvr"
      :handle-modal="assignModelvr"
      :handleModelClose="closeModel"
      :project_id="route.params.id"
      :task="currentTask"
    />

    <TaskDetails
      v-if="taskDetailModel"
      :handle-modal="taskDetailModel"
      :handleModelClose="closeDetail"
      :task="taskinfo"
    />
  </q-layout>
</template>

<script>
import { api } from 'src/boot/axios'
import { useQuasar } from 'quasar'
import ServerData from 'src/components/ServerData.vue';
import { useRoute } from 'vue-router';
import { useGeneralStore } from 'src/stores/generalStore';
import AssignModel from './AssignModel.vue';
import { Dialog, Notify } from 'quasar'
import TaskDetails from './TaskDetails.vue';
import ProtectedComponent from 'src/components/ProtectedComponent.vue';

export default {
  name: 'TaskListApp',
  components: { ServerData, AssignModel, TaskDetails ,ProtectedComponent },
  data() {
    const q = useQuasar();
    const route = useRoute();
    const generalStore = useGeneralStore()
    return {
      newTaskTitle: '',
      showDueDatePicker: false,
      showPriorityDialog: false,
      showEditDialog: false,
      selectedDueDate: '',
      selectedPriority: 'Medium',
      editingTask: null,
      editTaskTitle: '',
      editTaskDescription: '',
      editDueDate: '',
      editPriority: 'Medium',
      q, route, generalStore,
      assignModelvr: false,
      addAssignModel: false,
      currentTask: null,
      people: [],
      peopleSelected: [],
      priorityOptions: [
        { label: 'Low', value: 'Low' },
        { label: 'Medium', value: 'Medium' },
        { label: 'High', value: 'High' },
        { label: 'Urgent', value: 'Urgent' }
      ],
      taskDetailModel: false,
      taskinfo: null,
      assignPeople: null ,
      commentTask:null,
      commentModel:false,

    }
  },
  methods: {
    async addTask() {
      if (!this.newTaskTitle.trim()) return;
      try {
        const payload = {
          title: this.newTaskTitle.trim(),
          description: '',
          status: false,
          dueDate: this.selectedDueDate || '',
          type: this.selectedPriority,
          project_id: this.route.params.id,
          assign: this.assignPeople || []
        };
        const result = await api.post('tasks/add', payload);
        this.q.notify({ message: result.data.message, color: 'green' });
        this.generalStore.revalidate('tasks');
        this.newTaskTitle = '';
        this.selectedDueDate = '';
        this.selectedPriority = 'Medium';
        this.assignPeople = null;
      } catch (e) {
        console.error(e);
        this.q.notify({ message: e.message, color: 'red' });
      }
    },
    async toggleTask(task, status) {
      Dialog.create({
        title: 'Task Confirmation',
        message: `Do you want to ${status}?`,
        cancel: true,
        persistent: true,
        ok: { label: 'Yes', color: 'primary' },
        cancel: { label: 'No' }
      }).onOk(async () => {
        try {
          const result = await api.post('tasks/complate/' + task.id, {});
          Notify.create({ message: result.data.message, color: 'green' });
          this.generalStore.revalidate('tasks');
        } catch (e) {
          console.error(e);
          Notify.create({ message: e.message, color: 'red' });
        }
      });
    },
    editTask(task) {
      this.editingTask = task;
      this.editTaskTitle = task.title;
      this.editTaskDescription = task.description || '';
      this.editDueDate = task.dueDate || '';
      this.editPriority = task.priority || 'Medium';
      this.showEditDialog = true;
    },
    async saveTask() {
      if (!this.editTaskTitle.trim()) return;
      if (this.editingTask) {
        try {
          const result = await api.post('tasks/update/' + this.editingTask.id, {
            title: this.editTaskTitle.trim(),
            description: this.editTaskDescription,
            dueDate: this.editDueDate,
            type: this.editPriority
          });
          this.q.notify({ message: result.data.message, color: 'green' });
          this.generalStore.revalidate('tasks');
        } catch (e) {
          console.error(e);
          this.q.notify({ message: e.message, color: 'red' });
        }
      }
      this.closeEditDialog();
    },
    closeEditDialog() {
      this.showEditDialog = false;
      this.editingTask = null;
      this.editTaskTitle = '';
      this.editTaskDescription = '';
      this.editDueDate = '';
      this.editPriority = 'Medium';
    },
    assign(task) {
      this.assignModelvr = true;
      this.currentTask = task;
      this.peopleSelected = task.assign || [];
    },
    closeModel() {
      this.assignModelvr = false;
      this.currentTask = null;
      this.peopleSelected = [];
    },
    assigny() {
      if (this.currentTask) {
        // assign to existing task
        api.post(`tasks/assign/${this.currentTask.id}`, { users: this.peopleSelected })
          .then(res => {
            this.q.notify({ message: res.data.message, color: 'green' });
            this.generalStore.revalidate('tasks');
            this.closeModel();
          })
          .catch(err => {
            this.q.notify({ message: err.message, color: 'red' });
          });
      } else {
        // assign for new task
        this.assignPeople = this.peopleSelected;
        this.addAssignModel = false;
      }
    },removeUser(taskId , userId) {
        Dialog.create({
        title: 'Remove Confirmation',
        message: `Do you want to Remove this user From this task`,
        cancel: true,
        persistent: true,
        ok: { label: 'Yes', color: 'primary' },
        cancel: { label: 'No' }
      }).onOk(async () => {
        try {
          const result = await api.post('tasks/cremove-user/', {
            user_id:userId,
            task_id:taskId
          });
          Notify.create({ message: result.data.message, color: 'green' });
          this.generalStore.revalidate('tasks');
        } catch (e) {
          console.error(e);
          Notify.create({ message: e.message, color: 'red' });
        }
      });
    },
    async loadUser() {
      try {
        const result = await api.get(`projects/user/${this.route.params.id}`);
        this.people = result.data.data || result.data;
        this.addAssignModel = true;
      } catch (e) {
        console.error(e);
        this.q.notify({ message: 'Failed to load users', color: 'red' });
      }
    },
    formatDate(dateString) {
      if (!dateString) return '';
      const d = new Date(dateString);
      return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    },
    openDetail(task) {
      this.taskDetailModel = true;
      this.taskinfo = task;
    },
    closeDetail() {
      this.taskDetailModel = false;
      this.taskinfo = null;
    },  openComment(task) {
      this.commentModel = true;
      this.commentTask = task;
    },
    closeComment() {
         this.commentModel = false;
      this.commentTask = null;
    },
    getPriorityColor(priority) {
      const colors = { Low: 'green', Medium: 'blue', High: 'orange', Urgent: 'red' };
      return colors[priority] || 'grey';
    },
    setDueDate() { console.log('Due date set to:', this.selectedDueDate); },
    setPriority() { console.log('Priority set to:', this.selectedPriority); },
     pendingTasks(tasks) {
      if (tasks && Array.isArray(tasks)) {
        return tasks.filter(t => !t.completed)
      }
      return []
    },
    completedTasks(tasks) {
        if (tasks && Array.isArray(tasks)) {
        return tasks.filter(t => t.completed)
      }
      return []
    }
  },
  mounted() {
    this.generalStore.setActivePage(this.route.params.id);
    this.generalStore.setPageTitle('all tasks');
  }
}
</script>

<style scoped>
/* Same styles as your previous component */
.task-list { min-height: 20px; }
.task-card { transition: all 0.3s ease; border-left: 3px solid transparent; }
.task-card:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 3px solid #1976d2; }
.task-card.completed { opacity: 0.7; background-color: #fafafa; }
.task-title { font-size: 14px; font-weight: 500; line-height: 1.4; }
.task-description { font-size: 12px; margin-top: 2px; line-height: 1.3; }
.text-strike { text-decoration: line-through; }
.completed-tasks { opacity: 0.8; }
.q-badge { font-size: 10px; }
</style>
