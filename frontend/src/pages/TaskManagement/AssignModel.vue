<template>
  <q-dialog :model-value="true" persistent>
    <q-card class="md:min-w-[500px]">
      <q-card-section class="flex justify-between">
        <p class="text-lg font-semibold">
          {{ translate('Assign Task') }}
        </p>
             <q-btn
                    icon="close"
                    flat
                    size="sm"
                    @click="handleModelClose()"
                />
      </q-card-section>
      <q-card-section>

          <form-builder-component
          :action="`tasks/assign`"
          class-name="grid grid-cols-1 gap-x-3"
          :on-submit-completed="
            response => {
              q.notify({
                message: response?.data?.message,
                color: 'green',
              })
              handleModelClose()
              generalStore.revalidate('tasks')
            }
          "
          :hiddenFields ="[
            {
              name :'task_id',
              value:task.id
            }
          ]"
          :onValuesChanged="values => { console.log(values) }"
          :method=" 'POST'"
          service="CashrenevalSystem"
          submit-area-class-name="mt-3"
          :fields="
 [               {
        label: translate('Project Name'),
        type: 'server-select',
        name: 'user_id',
        value: '',
        validation: yup.string().required(),
        server_search_able:true ,
        url:'projects/user/'+project_id
 },]
      "
        />


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
import FormBuilderComponent from 'src/components/FormBuilderComponent.vue'

export default defineComponent({
  name: 'AssignModel',
  props: ['model', 'handleModelClose', 'mutate', 'project_id','task'],
  components: { FormBuilderComponent  },

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
})
</script>
