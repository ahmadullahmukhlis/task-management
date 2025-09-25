<template>
    <protected-component for-all>
        <q-intersection transition="fade">
            <q-page class="p-3">

            </q-page>
        </q-intersection>
    </protected-component>
</template>

<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'IndexPage',
    components: {

        ProtectedComponent,
    },
    setup() {
        const generalStore = useGeneralStore()
        const { translate } = useLanguageStore()
        return {
            generalStore,
            translate,
        }
    },
    data() {
        return {
            dashboardBoxNumber: [1, 2, 3, 4, 5, 6],
        }
    },
    mounted() {
        this.generalStore.setActivePage('home')
        this.generalStore.setPageTitle('Home page')
    },
})
</script>
