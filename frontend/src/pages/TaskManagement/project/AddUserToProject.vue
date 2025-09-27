<template>
  <q-dialog :model-value="true" persistent>
    <q-card class="md:min-w-[500px]">
      <!-- header -->
      <q-card-section class="flex items-center justify-between">
        <p class="text-lg font-semibold">
          {{ translate('Add User To Project') }}
        </p>
        <q-btn icon="close" flat size="sm" @click="handleModelClose" />
      </q-card-section>

      <q-card-section>
        <!-- input -->
        <q-input
          class="col-span-4"
          outlined
          dense
          :label="translate('Enter User Name or Email')"
          v-model="search"
          debounce="300"
          @update:model-value="loadData"
        >
          <template v-slot:append>
            <q-spinner v-if="loading" size="sm" />
          </template>
        </q-input>

        <div v-if="data?.length" class="my-5">
          <q-item v-for="user in data" :key="user.id" clickable v-ripple @click="addUser(user.id)">
            <q-item-section side>
              <q-avatar rounded size="48px">
                <img :src="user.image" />
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ user.name }}</q-item-label>
              <q-item-label caption>{{ user.email }}</q-item-label>
            </q-item-section>
          </q-item>
        </div>

        <div v-else-if="!loading && search">
          <p class="text-center text-gray-500">
            {{ translate('No users found') }}
          </p>
        </div>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import { defineComponent } from 'vue'
import { useQuasar } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
import { api } from 'src/boot/axios'

export default defineComponent({
  name: 'AddUserProjectDialog',
  props: {
    model: Boolean,
    handleModelClose: Function,
    mutate: Function,
    project: Object
  },

  setup () {
    const q = useQuasar()
    const generalStore = useGeneralStore()
    const { translate } = useLanguageStore()

    return {
      q,
      generalStore,
      translate
    }
  },

  data () {
    return {
      search: '',
      data: null,
      loading: false
    }
  },
  methods: {
    async loadData () {
      if (!this.search) {
        this.data = null
        return
      }
      this.loading = true
      try {
        const result = await api.get(`projects/add/user?search=${this.search}`)
        this.data = result.data?.data
      } catch (e) {
        console.error(e)
      } finally {
        this.loading = false
      }
    }
    , addUser(UserID){
      try {
        console.log(this.project)
       const result = api.post(`projects/add/user/${this.project?.id}`,{
          user_id : UserID
        });
             this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
      }catch(e) {
        console.log(e)
          this.q.notify({
                        message: this.$translate(e.message),
                        color: 'red',
                    })
      }
    }
  }
})
</script>
