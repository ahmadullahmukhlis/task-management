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
                            <div v-if="task.description" class="task-description text-caption text-grey-6" v-html=" task.description">

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
                              <!-- Comments Badge - Click to toggle comments -->
                              <div class="col-auto">
                                <q-badge
                                  outline
                                  :color="task.comments && task.comments.length > 0 ? 'primary' : 'grey'"
                                  class="q-mr-sm pointer"
                                  @click="toggleComments(task.id)"
                                  clickable
                                >
                                  <q-icon name="chat" size="12px" class="q-mr-xs" />
                                  {{ task.comments ? task.comments.length : 0 }}
                                  <q-tooltip>
                                    {{ task.comments && task.comments.length > 0 ? 'Click to show comments' : 'No comments' }}
                                  </q-tooltip>
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

                            <!-- Comments Section -->
                            <div v-if="showComments[task.id]" class="q-mt-md q-ml-md comments-section">
                              <div class="text-caption text-weight-medium q-mb-sm">Comments:</div>

                              <div v-if="!task.comments || task.comments.length === 0" class="text-grey-6 text-caption q-pa-sm">
                                No comments yet
                              </div>

                              <div v-else>
                                <div
                                  v-for="comment in task.comments"
                                  :key="comment.id"
                                  class="q-mb-xs comment-item"
                                >
                                  <q-card flat bordered class="bg-grey-1 q-pa-xs">
                                    <div class="text-caption">
                                      <strong>{{ comment.user }}:</strong>
                                      <span v-html="comment.comment"></span>
                                    </div>
                                    <div class="text-caption text-grey-6">
                                      {{ formatDate(comment.created_at) }}
                                    </div>
                                  </q-card>
                                </div>
                              </div>

                              <!-- Add Comment Button -->
                              <q-btn
                                flat
                                dense
                                color="primary"
                                icon="add_comment"
                                label="Add Comment"
                                size="sm"
                                @click="openComment(task)"
                                class="q-mt-sm"
                              />
                            </div>
                          </div>

                          <!-- Task Actions -->
                          <div>
                            <q-btn flat round dense icon="more_vert" size="sm">
                              <q-menu>
                                <q-list>
                                  <q-item clickable v-close-popup @click="openComment(task)">
                                    <q-item-section>Comment</q-item-section>
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
            <div class="text-h6 q-mb-md">Completed ({{ completedTasks(data)?.length }})</div>
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

                        <!-- Completed Task Comments Badge -->
                        <div class="items-center row q-mt-xs">
                          <div class="col-auto" v-if="task.comments && task.comments.length > 0">
                            <q-badge
                              outline
                              color="grey"
                              class="q-mr-sm pointer"
                              @click="toggleComments(task.id)"
                              clickable
                            >
                              <q-icon name="chat" size="12px" class="q-mr-xs" />
                              {{ task.comments.length }} comment{{ task.comments.length !== 1 ? 's' : '' }}
                            </q-badge>
                          </div>
                        </div>

                        <!-- Comments Section for Completed Tasks -->
                        <div v-if="showComments[task.id]" class="q-mt-md q-ml-md comments-section">
                          <div class="text-caption text-weight-medium q-mb-sm">Comments:</div>
                          <div
                            v-for="comment in task.comments"
                            :key="comment.id"
                            class="q-mb-xs comment-item"
                          >
                            <q-card flat bordered class="bg-grey-1 q-pa-xs">
                              <div class="text-caption">
                                <strong>{{ comment.user }}:</strong>
                                <span v-html="comment.comment"></span>
                              </div>
                              <div class="text-caption text-grey-6">
                                {{ formatDate(comment.created_at) }}
                              </div>
                            </q-card>
                          </div>
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
          <full-editor-component
    :value="editTaskDescription"
    :label="'Description'"
    :on-change="data => editTaskDescription = data"
    :error="null"
/>



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
    <CommentModel
      v-if="commentModel"
      :handle-modal="commentModel"
      :handleModelClose="closeComment"
      :project_id="route.params.id"
      :task="commentTask"
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
import CommentModel from './commentModel.vue';
import FullEditorComponent from 'src/components/FullEditorComponent.vue';

export default {
  name: 'TaskListApp',
  components: { ServerData, AssignModel, TaskDetails ,ProtectedComponent ,CommentModel ,FullEditorComponent },
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
      showComments: {}, // Track comment visibility for each task
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
        this.assignPeople = this.peopleSelected;
        this.addAssignModel = false;
      }
    },
    removeUser(taskId , userId) {
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
    openDetail(task) {
      this.taskDetailModel = true;
      this.taskinfo = task;
    },
    closeDetail() {
      this.taskDetailModel = false;
      this.taskinfo = null;
    },
 toggleComments(taskId) {
    // Fixed: Directly set the reactive property instead of using this.$set
    this.showComments[taskId] = !this.showComments[taskId];

    // Force reactivity by creating a new object if needed
    this.showComments = { ...this.showComments };
  },

  openComment(task) {
    this.commentModel = true;
    this.commentTask = task;
    // Fixed: Direct assignment instead of this.$set
    this.showComments[task.id] = true;
    this.showComments = { ...this.showComments }; // Force reactivity
  },

  closeComment() {
    this.commentModel = false;
    this.commentTask = null;
  },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },

    getPriorityColor(priority) {
      const map = { Low: 'grey', Medium: 'blue', High: 'orange', Urgent: 'red' };
      return map[priority] || 'grey';
    },
    pendingTasks(data) {
      return data?.filter(t => !t.completed);
    },
    completedTasks(data) {
      return data?.filter(t => t.completed);
    },
    setDueDate() {
      // Implementation for setting due date
      this.showDueDatePicker = false;
    },
    setPriority() {
      // Implementation for setting priority
      this.showPriorityDialog = false;
    },
    loadUser() {
      // Implementation for loading users
      this.addAssignModel = true;
    }
  },
};
</script>

<style scoped>
.pointer {
  cursor: pointer;
}

.comments-section {
  border-left: 3px solid #e0e0e0;
  padding-left: 12px;
  background-color: #fafafa;
  border-radius: 4px;
  padding: 12px;
  margin-top: 8px;
}

.comment-item {
  animation: fadeIn 0.3s ease-in;
}

.task-card {
  transition: all 0.3s ease;
}

.task-card:hover {
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Smooth transition for comments section */
.comments-section {
  transition: all 0.3s ease;
}

.task-title {
  font-weight: 500;
  font-size: 1rem;
}

.task-description {
  margin-top: 2px;
}

.completed-tasks .task-card {
  opacity: 0.7;
}
</style>
