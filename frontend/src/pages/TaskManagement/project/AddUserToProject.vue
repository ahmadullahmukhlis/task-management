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
        />

        <ServerData
          :url="url"
          v-slot="{ data }"
          :fetch-data="search  ?true : false"

        >
          <div v-if="data?.length" class="my-5">
            <q-item v-for="user in data" :key="user.id" clickable v-ripple>
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


        </ServerData>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import { defineComponent } from 'vue'
import { useQuasar } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
import ServerData from 'src/components/ServerData.vue'

export default defineComponent({
  name: 'AddUserProjectDialog',
  props: {
    model: Boolean,
    handleModelClose: Function,
    mutate: Function,
    project: Object
  },
  components: { ServerData },

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
      search: null,
      triggerSearch: false,
      url: '/projects/add/user'+ `?search=${this.search}`
    }
  },



})
</script>
