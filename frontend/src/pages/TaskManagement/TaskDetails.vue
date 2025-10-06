<template>
  <q-dialog :model-value="true" persistent>

          <q-card class="md:min-w-[500px] max-w-2xl bg-white shadow-xl rounded-xl overflow-hidden">
            <server-data :url="`tasks/task/load/${task.id}`" v-slot="{ data }" id="task">
      <!-- Header -->
      <q-card-section
        class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50"
      >
        <div class="flex items-center space-x-3">
          <div class="w-2 h-8 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600"></div>
          <p class="text-xl font-bold text-gray-800">
            {{ translate('Task Details') }}
          </p>
        </div>
        <q-btn
          icon="close"
          flat
          size="sm"
          class="p-2 text-gray-500 transition-colors duration-200 rounded-full hover:bg-gray-100 hover:text-gray-700"
          @click="handleModelClose()"
        />
      </q-card-section>

      <!-- Content -->
      <q-card-section class="p-6 space-y-6 bg-gray-50">
        <!-- Title -->
        <div class="p-4 bg-white border rounded-lg shadow-sm">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
            {{ translate('Title') }}
          </p>
          <p class="text-lg font-semibold leading-relaxed text-gray-900">{{ data.title }}</p>
        </div>

        <!-- Description -->
        <div v-if="data.description" class="p-4 bg-white border rounded-lg shadow-sm">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
            {{ translate('Description') }}
          </p>
          <p class="text-base leading-relaxed text-gray-700 whitespace-pre-wrap">
            {{ data.description }}
          </p>
        </div>

        <!-- Due Date & Status -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div class="p-4 bg-white border rounded-lg shadow-sm">
            <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
              {{ translate('Due Date') }}
            </p>
            <div class="flex items-center space-x-2">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                <q-icon name="event" class="text-sm text-blue-600" />
              </div>
              <p class="text-base font-medium text-gray-900">{{ data.dueDate }}</p>
            </div>
          </div>

          <div class="p-4 bg-white border rounded-lg shadow-sm">
            <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
              {{ translate('Status') }}
            </p>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 rounded-full" :class="statusColorClass"></div>
              <q-chip size="sm" class="font-medium capitalize border" :class="statusChipClass">
                {{ taskStatus }}
              </q-chip>
            </div>
          </div>
        </div>

        <!-- Priority -->
        <div class="p-4 bg-white border rounded-lg shadow-sm">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
            {{ translate('Priority') }}
          </p>
          <div class="flex items-center space-x-2">
            <div
              class="flex items-center justify-center w-8 h-8 rounded-lg"
              :class="priorityIconClass"
            >
              <q-icon name="flag" class="text-sm" :class="priorityIconColor" />
            </div>
            <q-chip size="sm" class="font-medium capitalize border" :class="priorityChipClass">
              {{ data.priority  }}
            </q-chip>
          </div>
        </div>

        <!-- Assigned -->
        <div v-if="data?.assign" class="p-4 bg-white border rounded-lg shadow-sm">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
            {{ translate('Assigned To') }}
          </p>
          <div class="space-y-3">
            <div
              v-for="user in data.assign"
              :key="user.id"
              class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50 hover:bg-gray-100"
            >
              <!-- Avatar -->
              <div class="flex-shrink-0">
                <div
                  v-if="user.image && user.image !== 'http://localhost:8000/storage'"
                  class="w-10 h-10 bg-center bg-cover border-2 border-white rounded-full shadow-sm"
                  :style="{ backgroundImage: `url(${user.image})` }"
                ></div>
                <div
                  v-else
                  class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white rounded-full shadow-sm"
                  :class="getUserColorClass(user.color)"
                >
                  {{ user.initials }}
                </div>
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ user.name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ user.email }}</p>
              </div>

              <!-- Remove -->
              <q-btn
                flat
                round
                dense
                size="sm"
                icon="close"
                color="red"
                @click="removeUser(data.id, user.id)"
              />

              <div class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                {{ translate('Assign') }}
              </div>
            </div>



            <div v-if="!data.assign || data.assign.length === 0" class="py-4 text-center text-gray-500">
              <q-icon name="person_off" class="mb-2 text-2xl text-gray-400" />
              <p class="text-sm">{{ translate('No one assigned') }}</p>
            </div>
          </div>
        </div>
             <div v-if="task?.documents" class="p-4 bg-white border rounded-lg shadow-sm">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">
            {{ translate('Documents') }}
          </p>
          <div class="space-y-3">
            <div
              v-for="doc in data.documents"
              :key="doc.id"
              class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50 hover:bg-gray-100"
            >
              <!-- Avatar -->


              <!-- Info -->
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ doc.title }}</p>

              </div>

              <!-- Remove -->
              <q-btn
                flat
                round
                dense
                size="sm"
                icon="close"
                color="red"
                @click="removedoc(doc.id)"
              />

                     <q-btn
                flat
                round
                dense
                size="sm"
                icon="download"
                color="green"
                 :href="doc.document"
  target="_blank"
  download
              />

            </div>



            <div v-if="!data.documents || data.documents.length === 0" class="py-4 text-center text-gray-500">
              <q-icon name="person_off" class="mb-2 text-2xl text-gray-400" />
              <p class="text-sm">{{ translate('No Document ') }}</p>
            </div>
          </div>
        </div>
      </q-card-section>

      <!-- Footer -->
      <q-card-actions align="right" class="px-6 py-4 border-t bg-gray-50">
          <q-btn label="upload" color="primary" outline @click="documentModel = true" />
        <q-btn
          flat
          :label="translate('Close')"
          @click="handleModelClose()"
        />
      </q-card-actions>
     </server-data>

    </q-card>

  </q-dialog>

  <!-- Upload Document -->
  <UploadDocumentModel
    v-if="documentModel"
    :handle-modal="documentModel"
    :handleModelClose="closeDOcument"
    :task="task"
  />
</template>

<script>
import { defineComponent } from 'vue'
import { useQuasar, Dialog, Notify } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
import { api } from 'src/boot/axios'
import UploadDocumentModel from './uploadDocument.Model.vue'
import ServerData from 'src/components/ServerData.vue'

export default defineComponent({
  name: 'TaskDetails',
  props: ['model', 'handleModelClose', 'mutate', 'task'],
  components: { UploadDocumentModel ,ServerData },
  data() {
    return {
      documentModel: false
    }
  },
  computed: {
    translate() {
      return useLanguageStore().translate
    },
    taskStatus() {
      return this.task.completed ? 'Completed' : 'Pending'
    },
    statusColorClass() {
      return this.task.completed ? 'bg-green-500' : 'bg-orange-500 animate-pulse'
    },
    statusChipClass() {
      return this.task.completed
        ? 'bg-green-50 text-green-700 border-green-200'
        : 'bg-orange-50 text-orange-700 border-orange-200'
    },
    priorityChipClass() {
      const priority = this.task.priority?.toLowerCase()
      switch (priority) {
        case 'high':
          return 'bg-red-50 text-red-700 border-red-200'
        case 'medium':
          return 'bg-yellow-50 text-yellow-700 border-yellow-200'
        case 'low':
          return 'bg-green-50 text-green-700 border-green-200'
        default:
          return 'bg-blue-50 text-blue-700 border-blue-200'
      }
    },
    priorityIconClass() {
      const priority = this.task.priority?.toLowerCase()
      switch (priority) {
        case 'high':
          return 'bg-red-100'
        case 'medium':
          return 'bg-yellow-100'
        case 'low':
          return 'bg-green-100'
        default:
          return 'bg-blue-100'
      }
    },
    priorityIconColor() {
      const priority = this.task.priority?.toLowerCase()
      switch (priority) {
        case 'high':
          return 'text-red-600'
        case 'medium':
          return 'text-yellow-600'
        case 'low':
          return 'text-green-600'
        default:
          return 'text-blue-600'
      }
    }
  },
  methods: {
    getUserColorClass(color) {
      const map = {
        pink: 'bg-pink-500',
        blue: 'bg-blue-500',
        green: 'bg-green-500',
        yellow: 'bg-yellow-500',
        purple: 'bg-purple-500',
        indigo: 'bg-indigo-500',
        red: 'bg-red-500',
        gray: 'bg-gray-500'
      }
      return map[color] || 'bg-blue-500'
    },
    async removeUser(taskId, userId) {
      Dialog.create({
        title: 'Remove Confirmation',
        message: 'Do you want to remove this user from this task?',
        cancel: true,
        persistent: true,
        ok: { label: 'Yes', color: 'primary' },
        cancel: { label: 'No' }
      }).onOk(async () => {
        try {
          const result = await api.post('tasks/cremove-user', {
            user_id: userId,
            task_id: taskId
          })
          Notify.create({ message: result.data.message, color: 'green' })

          useGeneralStore().revalidate('task')
        } catch (e) {
          Notify.create({ message: e.message, color: 'red' })
        }
      })
    },removedoc(id) {
          Dialog.create({
        title: 'Delete Confirmation',
        message: 'Do you want to Delete this Document?',
        cancel: true,
        persistent: true,
        ok: { label: 'Yes', color: 'primary' },
        cancel: { label: 'No' }
      }).onOk(async () => {
        try {
          const result = await api.delete('tasks/cremove-document/'+id)
          Notify.create({ message: result.data.message, color: 'green' })

          useGeneralStore().revalidate('task')
        } catch (e) {
          Notify.create({ message: e.message, color: 'red' })
        }
      })
    },
    closeDOcument() {
      this.documentModel = false
    }
  }
})
</script>
