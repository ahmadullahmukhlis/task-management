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
                        :action="
                            client ? `client/update/${client.id}` : `client/add`
                        "
                        class-name="grid grid-cols-2 gap-x-3"
                        :on-submit-completed="
                            response => {
                                $q.notify({
                                    message: response?.data?.message,
                                    color: 'green',
                                })
                                handleModelClose()
                                $generalStore.revalidate('client')
                            }
                        "
                        :onValuesChanged="
                            values => {
                             console.log(values)
                            }
                        "
                        :method="client ? 'PUT' : `POST`"
                        service="CashrenevalSystem"
                        submit-area-class-name="mt-3"
                        :fields="[
                            {
                                label: $translate('Project Name'),
                                type: 'text',
                                name: 'name',
                                value:'',
                                validation: yup.string().required(),
                            },
                            {
                                label: $translate('Description'),
                                type: 'tip_editor',
                                name: 'comment',
                                value:  '',
                                validation: yup.string().nulleable(),
                            },


                        ]"
                    />

            </q-card-section>

        </q-card>
    </q-dialog>
</template>
<script>
import FormBuilderComponent from 'src/components/FormBuilderComponent.vue';
import { defineComponent } from 'vue'

export default defineComponent({

    name: 'ProjectFormModel',
    props: ['model', 'handleModelClose', 'mutate', 'project'],
    components:{FormBuilderComponent}

})
</script>
