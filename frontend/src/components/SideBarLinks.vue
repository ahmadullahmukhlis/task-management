<template>
    <q-list padding>
        <SidebarLink
            icon="dashboard"
            :name="$translate('Dashboard')"
            to="/"
            :active="generalStore.active_page === 'home'"
        />
        <ServerData
            url="projects"
            v-slot="{ data }"
            id="project"
        >
            <div v-for="item in data" :key="item.id" class="my-1" @click="projectUrl(item.id)">
                   <SidebarLink
                    :icon="item.icon"
                    :name="$translate(item.name)"
                    :to="`/projects/${item.id}`"
                    :active="generalStore.active_page == item.id"
                />
            </div>

        </ServerData>
        <protected-component permission-key="user-management-access">
            <SidebarLink
                icon="people"
                :name="$translate('User management')"
                to="/user-management"
                :active="generalStore.active_page === 'user-management'"
            />
        </protected-component>
        <protected-component permission-key="configurations-access">
            <SidebarLink
                icon="settings"
                :name="$translate('Configurations')"
                to="/configurations"
                :active="generalStore.active_page === 'configurations'"
            />
        </protected-component>
    </q-list>
</template>

<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import SidebarLink from 'components/SidebarLink.vue'
import { LocalEncrypt } from 'src/lib/crypto'
import ServerData from './ServerData.vue'
import ProtectedComponent from './ProtectedComponent.vue'
import { useRoute ,useRouter } from 'vue-router';
export default defineComponent({
    name: 'SidebarLinks',
    components: { SidebarLink, ServerData ,ProtectedComponent },
    setup() {
        const generalStore = useGeneralStore()
        const route = useRoute();
                const router = useRouter();

        return {
            generalStore,route,router
        }
    },
    methods:{
projectUrl(id) {
  if (this.route.path.startsWith('/projects/')) {
    this.router.push('/all-task/' + id);
  } else {
    this.router.push('/projects/' + id);
  }
}

    }

})
</script>
