export const userManagementRoutes = {
    path: '/user-management',
    children: [
        {
            path: '',
            component: () =>
                import('pages/UserManagement/UserManagementIndex.vue'),
        },
        {
            path: 'users',
            children: [
                {
                    path: '',
                    component: () =>
                        import('pages/UserManagement/Users/UserPage.vue'),
                },
                {
                    path: ':id/:active',
                    component: () =>
                        import(
                            'pages/UserManagement/Users/UserDetails/UserDetailPage.vue'
                        ),
                },
            ],
        },
        {
            path: 'customers',
            children: [
                {
                    path: '',
                    component: () =>
                        import(
                            'pages/UserManagement/Customers/CustomerPage.vue'
                        ),
                },
            ],
        },
        {
            path: 'suppliers',
            children: [
                {
                    path: '',
                    component: () =>
                        import(
                            'pages/UserManagement/Suppliers/SupplierPage.vue'
                        ),
                    meta: {
                        active: '',
                        breadcrumb: [
                            {
                                text: 'User Management',
                                link: '/user-management',
                            },
                            {
                                text: 'Suppliers',
                                link: '',
                            },
                        ],
                    },
                },
            ],
        },
        {
            path: 'activity-log',
            component: () =>
                import('pages/UserManagement/ActivityLog/ActivityLogPage.vue'),
        },
        {
            path: 'login-log',
            component: () =>
                import('pages/UserManagement/LoginLog/LoginLogPage.vue'),
        },
        {
            path: 'roles',
            children: [
                {
                    path: '',
                    component: () =>
                        import('pages/UserManagement/Roles/RolePage.vue'),
                },
                {
                    path: ':id/:name?',
                    component: () =>
                        import(
                            'pages/UserManagement/Roles/RoleDetails/RoleDetailsPage.vue'
                        ),
                },
            ],
        },
        {
            path: 'permissions',
            component: () =>
                import('pages/UserManagement/Permissions/PermissionsPage.vue'),
        },
    ],
}
