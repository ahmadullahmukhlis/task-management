import { userManagementRoutes } from 'pages/UserManagement/userManagementRoutes'
import { configurationRoutes } from 'pages/Configurations/configurationRoutes'

const routes = [
    {
        path: '/',
        component: () => import('layouts/MainLayout.vue'),
        children: [
            { path: '', component: () => import('pages/IndexPage.vue') },
            { ...configurationRoutes },
            { ...userManagementRoutes },
            {
                path: '/pos',
                component: () => import('pages/POSPage.vue'),
                meta: {
                    disable_layout: true,
                },
            },
            { path: 'projects/:id', component: () => import('pages/TaskManagement/TaskPage.vue') },
            { path: 'all-task/:id', component: () => import('pages/TaskManagement/allTaskPage.vue') },

        ],

    },
            { path: '/real-time', component: () => import('pages/TaskManagement/RealTaskDashboardPage.vue') },

{
    path: '/verify/:id',
    component: () => import('pages/verifyPage.vue'),
    meta: { auth: false }
},
    {
        path: '/login',
        component: () => import('pages/LoginPage.vue'),
    },     {
        path: '/message/:email',
        component: () => import('pages/messagePage.vue'),
    },

    {
        path: '/server-error',
        component: () => import('pages/ServerErrorPage.vue'),
    },
    {
        path: '/forbidden',
        component: () => import('pages/ForbiddenPage.vue'),
    },

    // Always leave this as last one,
    // but you can also remove it
    {
        path: '/:catchAll(.*)*',
        component: () => import('pages/ErrorNotFound.vue'),
    },
]

export default routes
