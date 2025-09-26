<template>
  <q-dialog :model-value="true" persistent>
    <q-card class="md:min-w-[500px]">
      <q-card-section>
        <p class="font-semibold text-lg">
          {{ translate('Create Project') }}
        </p>
      </q-card-section>
      <q-card-section>
        <form-builder-component
          :action="project ? `projects/${project?.id}` : `projects/add`"
          class-name="grid grid-cols-1 gap-x-3"
          :on-submit-completed="
            response => {
              q.notify({
                message: response?.data?.message,
                color: 'green',
              })
              handleModelClose()
              generalStore.revalidate('project')
            }
          "
          :onValuesChanged="values => { console.log(values) }"
          :method="project ? 'PUT' : 'POST'"
          service="CashrenevalSystem"
          submit-area-class-name="mt-3"
          :fields="
 [               {
        label: translate('Project Name'),
        type: 'text',
        name: 'name',
        value: project?.name ??'',
        validation: yup.string().required(),
      },
      {
        label: translate('Description'),
        type: 'editor',
        name: 'comment',
              value: project?.description ??'',

        validation: yup.string().required(),
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
  name: 'ProjectFormModel',
  props: ['model', 'handleModelClose', 'mutate', 'project'],
  components: { FormBuilderComponent },

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
