<template>
    <div
        v-if="fullPageLoading"
        class="flex items-center justify-center h-screen bg-gradient-to-br from-blue-50 to-indigo-100"
    >
        <div class="text-center">
            <q-spinner color="primary" size="3rem" />
            <p class="mt-4 text-gray-600">Loading...</p>
        </div>
    </div>

    <div v-else class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="w-full max-w-md">
            <!-- Card with soft shadow and rounded corners -->
            <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                <!-- Header with gradient background -->
                <div class="px-6 py-8 text-center bg-gradient-to-r from-blue-500 to-purple-600">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-white/20">
                        <q-icon name="lock" size="28px" color="white" />
                    </div>
                    <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                    <p class="mt-2 text-blue-100">Sign in to your account</p>
                </div>

                <!-- Form section -->
                <div class="px-6 py-8">
                    <ValidationForm
                        :validation-schema="schema"
                        @submit="onSubmit"
                        class="space-y-6"
                    >
                        <!-- Email Field -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                            <Field
                                name="email"
                                v-slot="{ errorMessage, value, field }"
                            >
                                <q-input
                                    :model-value="value"
                                    v-bind="field"
                                    :error-message="$translate(errorMessage)"
                                    :error="!!errorMessage"
                                    outlined
                                    dense
                                    placeholder="Enter your email"
                                    class="rounded-lg"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="email" class="text-gray-400" />
                                    </template>
                                </q-input>
                            </Field>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Forgot?</a>
                            </div>
                            <Field
                                name="password"
                                v-slot="{ errorMessage, value, field }"
                            >
                                <q-input
                                    :model-value="value"
                                    v-bind="field"
                                    :error-message="$translate(errorMessage)"
                                    :error="!!errorMessage"
                                    outlined
                                    dense
                                    placeholder="Enter your password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="rounded-lg"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="lock" class="text-gray-400" />
                                    </template>
                                    <template v-slot:append>
                                        <q-btn
                                            :icon="showPassword ? 'visibility_off' : 'visibility'"
                                            size="sm"
                                            round
                                            flat
                                            @click="onPasswordButtonClick"
                                            class="text-gray-400"
                                        />
                                    </template>
                                </q-input>
                            </Field>
                        </div>

                        <!-- Remember Me -->
                        <Field
                            :value="false"
                            name="remember"
                            v-slot="{ value, field }"
                        >
                            <div class="flex items-center">
                                <q-toggle
                                    v-bind="field"
                                    :model-value="value"
                                    color="blue"
                                />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </div>
                        </Field>

                        <!-- Submit Button -->
                        <q-btn
                            color="primary"
                            :loading="loading"
                            type="submit"
                            class="w-full py-3 font-medium transition-all duration-200 rounded-lg shadow-lg hover:shadow-xl"
                            :label="loading ? 'Signing in...' : $translate('Sign In')"
                            no-caps
                        />

                        <!-- Divider -->
                        <div class="relative flex items-center my-6">
                            <div class="flex-grow border-t border-gray-200"></div>
                            <span class="flex-shrink mx-4 text-sm text-gray-400">or continue with</span>
                            <div class="flex-grow border-t border-gray-200"></div>
                        </div>

                        <!-- Social Login -->
                        <div class="grid grid-cols-2 gap-3">
                            <q-btn
                                outline
                                class="py-2 rounded-lg"
                                icon="img:https://cdn-icons-png.flaticon.com/512/300/300221.png"
                                label="Google"
                                no-caps
                            />
                            <q-btn
                                outline
                                class="py-2 rounded-lg"
                                icon="img:https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                label="GitHub"
                                no-caps
                            />
                        </div>
                    </ValidationForm>

                    <!-- Sign up link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- App download links (mobile-friendly) -->
            <div class="mt-6 text-center">
                <p class="mb-3 text-xs text-gray-500">Get our mobile app</p>
                <div class="flex justify-center space-x-3">
                    <button class="flex items-center px-4 py-2 text-xs text-white bg-black rounded-lg">
                        <q-icon name="android" class="mr-1" size="16px" />
                        Google Play
                    </button>
                    <button class="flex items-center px-4 py-2 text-xs text-white bg-black rounded-lg">
                        <q-icon name="apple" class="mr-1" size="16px" />
                        App Store
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { useQuasar } from 'quasar'
import { errorHandler } from 'src/lib/errorHandler'
import { useRouter } from 'vue-router/dist/vue-router'

export default defineComponent({
    name: 'LoginPage',
    components: {
        ValidationForm,
        Field,
    },
    setup() {
        const authStore = useAuthStore()
        const q = useQuasar()
        const router = useRouter()
        const schema = yup.object({
            email: yup.string().email('Please enter a valid email').required('Email is required'),
            remember: yup.boolean(),
            password: yup
                .string()
                .required('Password is required')
                .min(6, 'Password must be at least 6 characters')
        })
        return {
            schema,
            q,
            router,
            authStore,
        }
    },
    data() {
        return {
            email: '',
            password: '',
            showPassword: false,
            loading: false,
            fullPageLoading: true,
            sh: 0,
        }
    },
    methods: {
        onPasswordButtonClick() {
            this.showPassword = !this.showPassword
        },
        async onSubmit(values, actions) {
            this.loading = true

            try {
                await this.authStore.getToken()
                const result = await this.authStore.login(
                    values?.email,
                    values?.password,
                    values?.remember,
                )
                this.loading = false
                this.authStore.token = result.data
                localStorage.setItem('token', result.data)
                this.$q.notify({
                    message: 'Logged in successfully',
                    color: 'green',
                    position: 'top',
                    icon: 'check_circle'
                })
                await this.router.push('/')
                window.location.reload()
            } catch (e) {
                this.loading = false
                this.$q.notify({
                    message: 'Login failed. Please check your credentials.',
                    color: 'red',
                    position: 'top',
                    icon: 'error'
                })
                errorHandler(e, actions.setErrors)
            }
        },
    },
    async mounted() {
        try {
            await this.authStore.getLoggedInUse()
            this.router.push('/')
        } catch (e) {
            this.fullPageLoading = false
        }
    },
})
</script>

<style scoped>
/* Custom styles for better mobile experience */
@media (max-width: 640px) {
    .max-w-md {
        margin: 0 1rem;
    }
}

/* Smooth transitions for interactive elements */
.q-btn {
    transition: all 0.2s ease-in-out;
}

/* Improve touch targets for mobile */
.q-field {
    font-size: 16px; /* Prevents zoom on iOS */
}

.q-btn--dense {
    min-height: 44px; /* Minimum touch target size */
}
</style>
