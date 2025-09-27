<template>
  <q-dialog :model-value="true" persistent>
    <q-card class="md:min-w-[500px]">
      <q-card-section class="flex justify-between">
        <p class="text-lg font-semibold">
          {{ translate('Add User To Project') }}
        </p>
             <q-btn
                    icon="close"
                    flat
                    size="sm"
                    @click="handleModelClose()"
                />
      </q-card-section>
      <q-card-section>
              <q-input
                    class="col-span-4"
                    outlined
                    dense
                    :label="translate('Enter User Name or Email')"
                    v-model="search"
                    debounce="300"
                />
             <ServerData
            :url="`projects/add/user?search=${search}`"
            v-slot="{ data }"
            :fetch-data="search ?? false"
            id="project"
        >
          <div v-if="data.length > 0">
                <q-item clickable v-ripple>
      <q-item-section side>
        <q-avatar rounded size="48px">
          <img src="https://cdn.quasar.dev/img/avatar.png">
          <q-badge floating color="teal">new</q-badge>
        </q-avatar>
      </q-item-section>
      <q-item-section>
        <q-item-label>Mary</q-item-label>
        <q-item-label caption>2 new messages</q-item-label>
      </q-item-section>
      <q-item-section side>
        3 min ago
      </q-item-section>
    </q-item>
          </div>
          <div class="text-center text-red-600" v-else>
            No User Found
          </div>
        </ServerData>

      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import { defineComponent } from 'vue'
import * as yup from 'yup'
import { useQuasar } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
import ServerData from 'src/components/ServerData.vue'

export default defineComponent({
  name: 'ProjectFormModel',
  props: ['model', 'handleModelClose', 'mutate', 'project'],
  components: {  ServerData },

  setup() {
    const q = useQuasar()
    const generalStore = useGeneralStore()
    const { translate } = useLanguageStore()



    return {
      q,
      generalStore,
      translate,
      yup,

    }
  },
  data () {
    return {
      search : null
    }
  }
})
</script>
