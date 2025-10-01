<template>
  <q-dialog :model-value="true" persistent>
    <q-card class="md:min-w-[500px] max-w-2xl bg-white shadow-xl rounded-xl overflow-hidden">
      <!-- Header -->
      <q-card-section class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
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
        <!-- Title Section -->
        <div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Title') }}</p>
          <p class="text-lg font-semibold leading-relaxed text-gray-900">{{ task.title }}</p>
        </div>

        <!-- Description Section -->
        <div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md" v-if="task.description">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Description') }}</p>
          <p class="text-base leading-relaxed text-gray-700 whitespace-pre-wrap">{{ task.description }}</p>
        </div>

        <!-- Due Date & Status Grid -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md">
            <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Due Date') }}</p>
            <div class="flex items-center space-x-2">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                <q-icon name="event" class="text-sm text-blue-600" />
              </div>
              <p class="text-base font-medium text-gray-900">{{ task.dueDate }}</p>
            </div>
          </div>

          <div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md">
            <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Status') }}</p>
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 rounded-full" :class="statusColorClass"></div>
              <q-chip
                size="sm"
                class="font-medium capitalize border"
                :class="statusChipClass"
              >
                {{ taskStatus }}
              </q-chip>
            </div>
          </div>
        </div>

        <!-- Priority Section -->
        <div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md">
          <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Priority') }}</p>
          <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg" :class="priorityIconClass">
              <q-icon name="flag" class="text-sm" :class="priorityIconColor" />
            </div>
            <q-chip
              size="sm"
              class="font-medium capitalize border"
              :class="priorityChipClass"
            >
              {{ task.priority }}
            </q-chip>
          </div>
        </div>

        <!-- Assigned Section -->
     <!-- Assigned Section -->
<div class="p-4 transition-all bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md">
  <p class="mb-2 text-xs font-medium tracking-wider text-gray-500 uppercase">{{ translate('Assigned To') }}</p>
  <div class="space-y-3">
    <div
      v-for="user in task.assign"
      :key="user.id"
      class="flex items-center p-3 space-x-3 transition-colors duration-200 rounded-lg bg-gray-50 hover:bg-gray-100"
    >
      <!-- User Avatar -->
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

      <!-- User Info -->
      <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900 truncate">{{ user.name }}</p>
        <p class="text-xs text-gray-500 truncate">{{ user.email }}</p>
      </div>

      <!-- Remove User Button -->
      <q-btn
        flat
        round
        dense
        size="sm"
        icon="close"
        color="red"
        @click="removeUser(task.id, user.id)"
        class="hover:bg-red-50"
      />

      <!-- Created By Badge -->
      <div
        class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 border border-green-200 rounded-full"
      >
        {{ translate('Assign') }}
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-if="!task.assign || task.assign.length === 0"
      class="py-4 text-center text-gray-500"
    >
      <q-icon name="person_off" class="mb-2 text-2xl text-gray-400" />
      <p class="text-sm">{{ translate('No one assigned') }}</p>
    </div>
  </div>
</div>

      </q-card-section>

      <!-- Footer -->
      <q-card-actions align="right" class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        <q-btn
          flat
          :label="translate('Close')"
          @click="handleModelClose()"
          class="px-6 py-2 font-medium text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-gray-800"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { defineComponent, computed } from 'vue'
import { useQuasar, Dialog, Notify } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
import { api } from 'src/boot/axios' // <-- import axios instance

export default defineComponent({
  name: 'TaskDetails',
  props: ['model', 'handleModelClose', 'mutate', 'task'],
  setup (props) {
    const q = useQuasar()
    const generalStore = useGeneralStore()
    const { translate } = useLanguageStore()

    // Computed properties for dynamic styling
    const taskStatus = computed(() => {
      return props.task.completed ? 'Completed' : 'Pending'
    })

    const statusColorClass = computed(() => {
      return props.task.completed ? 'bg-green-500' : 'bg-orange-500 animate-pulse'
    })

    const statusChipClass = computed(() => {
      return props.task.completed
        ? 'bg-green-50 text-green-700 border-green-200'
        : 'bg-orange-50 text-orange-700 border-orange-200'
    })

    const priorityChipClass = computed(() => {
      const priority = props.task.priority?.toLowerCase()
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
    })

    const priorityIconClass = computed(() => {
      const priority = props.task.priority?.toLowerCase()
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
    })

    const priorityIconColor = computed(() => {
      const priority = props.task.priority?.toLowerCase()
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
    })

    const formatDate = (dateString) => {
      if (!dateString) return 'No due date'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }

    const getUserColorClass = (color) => {
      const colorMap = {
        pink: 'bg-pink-500',
        blue: 'bg-blue-500',
        green: 'bg-green-500',
        yellow: 'bg-yellow-500',
        purple: 'bg-purple-500',
        indigo: 'bg-indigo-500',
        red: 'bg-red-500',
        gray: 'bg-gray-500'
      }
      return colorMap[color] || 'bg-blue-500'
    }

    // --- REMOVE USER ---
    const removeUser = (taskId, userId) => {
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
     props.handleModelClose();
          generalStore.revalidate('tasks')
        } catch (e) {
          console.error(e)
          Notify.create({ message: e.message, color: 'red' })
        }
      })
    }

    return {
      q,
      generalStore,
      translate,
      taskStatus,
      statusColorClass,
      statusChipClass,
      priorityChipClass,
      priorityIconClass,
      priorityIconColor,
      formatDate,
      getUserColorClass,
      removeUser
    }
  }
})
</script>

