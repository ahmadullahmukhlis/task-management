<template>
    <!-- Full Page Loading State -->
    <div
        v-if="fullPageLoading"
        class="flex items-center justify-center h-screen bg-gradient-to-br from-blue-50 to-indigo-100"
    >
        <div class="text-center">
            <q-spinner color="primary" size="3rem" />
            <p class="mt-4 text-gray-600">Loading...</p>
        </div>
    </div>

    <!-- Main Auth Container -->
    <div v-else class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="w-full max-w-md">
            <!-- Tab Navigation - Clear and Distinct -->
            <div class="flex mb-1 overflow-hidden bg-white shadow-sm rounded-t-2xl">
                <!-- Login Tab -->
                <button
                    @click="switchTab('login')"
                    :class="[
                        'flex-1 py-4 font-semibold text-sm transition-all duration-300 flex items-center justify-center',
                        activeTab === 'login'
                            ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-inner'
                            : 'text-gray-600 hover:text-blue-600 bg-gray-50'
                    ]"
                >
                    <q-icon name="login" size="20px" class="mr-2" />
                    <span>Sign In</span>
                    <div v-if="activeTab === 'login'" class="w-2 h-2 ml-2 bg-white rounded-full"></div>
                </button>

                <!-- Divider between tabs -->
                <div class="w-px my-2 bg-gray-200"></div>

                <!-- Signup Tab -->
                <button
                    @click="switchTab('signup')"
                    :class="[
                        'flex-1 py-4 font-semibold text-sm transition-all duration-300 flex items-center justify-center',
                        activeTab === 'signup'
                            ? 'bg-gradient-to-r from-green-500 to-teal-600 text-white shadow-inner'
                            : 'text-gray-600 hover:text-green-600 bg-gray-50'
                    ]"
                >
                    <q-icon name="person_add" size="20px" class="mr-2" />
                    <span>Sign Up</span>
                    <div v-if="activeTab === 'signup'" class="w-2 h-2 ml-2 bg-white rounded-full"></div>
                </button>
            </div>

            <!-- Auth Card Container -->
            <div class="overflow-hidden bg-white shadow-xl rounded-2xl">
                <!-- Login Form Section -->
                <div v-if="activeTab === 'login'" class="animate-fade-in">
                    <!-- Login Header -->
                    <div class="relative px-6 py-8 text-center bg-gradient-to-r from-blue-500 to-purple-600">
                        <div class="absolute top-4 left-4">
                            <div class="p-2 rounded-full bg-white/20">
                                <q-icon name="login" size="20px" color="white" />
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-white/20">
                            <q-icon name="lock" size="28px" color="white" />
                        </div>
                        <h1 class="text-2xl font-bold text-white">Welcome Back</h1>
                        <p class="mt-2 text-blue-100">Sign in to your account</p>
                    </div>

                    <!-- Login Form -->
                    <div class="px-6 py-8">
                        <ValidationForm
                            :validation-schema="loginSchema"
                            @submit="onLoginSubmit"
                            class="space-y-6"
                        >
                            <!-- Email Field -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    <q-icon name="email" size="16px" class="mr-1 text-blue-500" />
                                    Email Address
                                </label>
                                <Field
                                    name="email"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="your.email@example.com"
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
                                    <label class="block text-sm font-medium text-gray-700">
                                        <q-icon name="lock" size="16px" class="mr-1 text-blue-500" />
                                        Password
                                    </label>
                                    <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-500">
                                        <q-icon name="help" size="14px" class="mr-1" />
                                        Forgot?
                                    </a>
                                </div>
                                <Field
                                    name="password"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="Enter your password"
                                        :type="showLoginPassword ? 'text' : 'password'"
                                        class="rounded-lg"
                                    >
                                        <template v-slot:prepend>
                                            <q-icon name="lock" class="text-gray-400" />
                                        </template>
                                        <template v-slot:append>
                                            <q-btn
                                                :icon="showLoginPassword ? 'visibility_off' : 'visibility'"
                                                size="sm"
                                                round
                                                flat
                                                @click="showLoginPassword = !showLoginPassword"
                                                class="text-gray-400"
                                            />
                                        </template>
                                    </q-input>
                                </Field>
                            </div>

                            <!-- Remember Me & Quick Actions -->
                            <div class="flex items-center justify-between">
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
                                            size="sm"
                                        />
                                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                    </div>
                                </Field>

                                <q-btn
                                    flat
                                    dense
                                    color="blue"
                                    icon="fingerprint"
                                    label="Quick Login"
                                    size="sm"
                                    @click="quickLogin"
                                />
                            </div>

                            <!-- Submit Button -->
                            <q-btn
                                color="primary"
                                :loading="loginLoading"
                                type="submit"
                                class="w-full py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]"
                                :label="loginLoading ? 'Signing in...' : 'Sign In to Your Account'"
                                no-caps
                            >
                                <template v-slot:loading>
                                    <q-spinner class="mr-2" />
                                    Signing in...
                                </template>
                            </q-btn>
                        </ValidationForm>

                        <!-- Social Login Section -->
                        <div class="mt-8">
                            <div class="relative flex items-center mb-4">
                                <div class="flex-grow border-t border-gray-200"></div>
                                <span class="flex-shrink mx-4 text-sm font-medium text-gray-500">Or continue with</span>
                                <div class="flex-grow border-t border-gray-200"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <q-btn
                                    outline
                                    class="py-3 border-2 rounded-lg"
                                    icon="img:https://cdn-icons-png.flaticon.com/512/300/300221.png"
                                    label="Google"
                                    no-caps
                                    @click="socialLogin('google')"
                                />
                                <q-btn
                                    outline
                                    class="py-3 border-2 rounded-lg"
                                    icon="img:https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                    label="GitHub"
                                    no-caps
                                    @click="socialLogin('github')"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signup Form Section -->
                <div v-else class="animate-fade-in">
                    <!-- Signup Header -->
                    <div class="relative px-6 py-8 text-center bg-gradient-to-r from-green-500 to-teal-600">
                        <div class="absolute top-4 left-4">
                            <div class="p-2 rounded-full bg-white/20">
                                <q-icon name="person_add" size="20px" color="white" />
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-white/20">
                            <q-icon name="person" size="28px" color="white" />
                        </div>
                        <h1 class="text-2xl font-bold text-white">Join Us Today</h1>
                        <p class="mt-2 text-green-100">Create your account in seconds</p>
                    </div>

                    <!-- Signup Form -->
                    <div class="px-6 py-2">
                        <ValidationForm
                            :validation-schema="signupSchema"
                            @submit="onSignupSubmit"
                            class="space-y-1"
                        >
                            <!-- Full Name Field -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    <q-icon name="person" size="16px" class="mr-1 text-green-500" />
                                    Full Name
                                </label>
                                <Field
                                    name="name"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="John Doe"
                                        class="rounded-lg"
                                    >
                                        <template v-slot:prepend>
                                            <q-icon name="person" class="text-gray-400" />
                                        </template>
                                    </q-input>
                                </Field>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    <q-icon name="email" size="16px" class="mr-1 text-green-500" />
                                    Email Address
                                </label>
                                <Field
                                    name="email"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="your.email@example.com"
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
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    <q-icon name="lock" size="16px" class="mr-1 text-green-500" />
                                    Password
                                </label>
                                <Field
                                    name="password"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="Create a strong password"
                                        :type="showSignupPassword ? 'text' : 'password'"
                                        class="rounded-lg"
                                    >
                                        <template v-slot:prepend>
                                            <q-icon name="lock" class="text-gray-400" />
                                        </template>
                                        <template v-slot:append>
                                            <q-btn
                                                :icon="showSignupPassword ? 'visibility_off' : 'visibility'"
                                                size="sm"
                                                round
                                                flat
                                                @click="showSignupPassword = !showSignupPassword"
                                                class="text-gray-400"
                                            />
                                        </template>
                                    </q-input>
                                </Field>

                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    <q-icon name="lock" size="16px" class="mr-1 text-green-500" />
                                    Confirm Password
                                </label>
                                <Field
                                    name="confirmPassword"
                                    v-slot="{ errorMessage, value, field }"
                                >
                                    <q-input
                                        :model-value="value"
                                        v-bind="field"
                                        :error-message="errorMessage"
                                        :error="!!errorMessage"
                                        outlined
                                        dense
                                        placeholder="Re-enter your password"
                                        :type="showConfirmPassword ? 'text' : 'password'"
                                        class="rounded-lg"
                                    >
                                        <template v-slot:prepend>
                                            <q-icon name="lock" class="text-gray-400" />
                                        </template>
                                        <template v-slot:append>
                                            <q-btn
                                                :icon="showConfirmPassword ? 'visibility_off' : 'visibility'"
                                                size="sm"
                                                round
                                                flat
                                                @click="showConfirmPassword = !showConfirmPassword"
                                                class="text-gray-400"
                                            />
                                        </template>
                                    </q-input>
                                </Field>
                            </div>

                            <!-- Terms Agreement -->
                            <Field
                                :value="false"
                                name="terms"
                                v-slot="{ errorMessage, value, field }"
                            >
                                <div class="flex items-start p-1 rounded-lg bg-gray-50">
                                    <q-toggle
                                        v-bind="field"
                                        :model-value="value"
                                        color="green"
                                        class="mt-1"
                                        dense
                                    />
                                    <span class="ml-2 text-sm text-gray-600">
                                        I agree to the
                                        <a href="#" class="font-medium text-green-600 hover:text-green-500">Terms of Service</a>
                                        and
                                        <a href="#" class="font-medium text-green-600 hover:text-green-500">Privacy Policy</a>
                                    </span>
                                </div>
                                <p v-if="errorMessage" class="mt-1 text-xs text-red-500">{{ errorMessage }}</p>
                            </Field>

                            <!-- Submit Button -->
                            <q-btn
                                color="green"
                                :loading="signupLoading"
                                type="submit"
                                class="w-full py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]"
                                :label="signupLoading ? 'Creating Account...' : 'Create Your Account'"
                                no-caps
                            >
                                <template v-slot:loading>
                                    <q-spinner class="mr-2" />
                                    Creating Account...
                                </template>
                            </q-btn>
                        </ValidationForm>

                        <!-- Social Signup Section -->
                        <div class="mt-3">
                            <div class="relative flex items-center mb-4">
                                <div class="flex-grow border-t border-gray-200"></div>
                                <span class="flex-shrink mx-4 text-sm font-medium text-gray-500">Or sign up with</span>
                                <div class="flex-grow border-t border-gray-200"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <q-btn
                                    outline
                                    class="py-3 border-2 rounded-lg"
                                    icon="img:https://cdn-icons-png.flaticon.com/512/300/300221.png"
                                    label="Google"
                                    no-caps
                                    @click="socialSignup('google')"
                                />
                                <q-btn
                                    outline
                                    class="py-3 border-2 rounded-lg"
                                    icon="img:https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                    label="GitHub"
                                    no-caps
                                    @click="socialSignup('github')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Navigation Helper -->
            <div class="p-4 mt-2 text-center bg-white/80 rounded-2xl backdrop-blur-sm">
                <p v-if="activeTab === 'login'" class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="#" @click.prevent="switchTab('signup')" class="ml-1 font-semibold text-green-600 hover:text-green-500">
                        Sign up here →
                    </a>
                </p>
                <p v-else class="text-sm text-gray-600">
                    Already have an account?
                    <a href="#" @click.prevent="switchTab('login')" class="ml-1 font-semibold text-blue-600 hover:text-blue-500">
                        Sign in here →
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'
import { errorHandler } from 'src/lib/errorHandler'
import { useAuthStore } from 'src/stores/UserManagementStores/AuthStore'
import {  LocalEncrypt } from 'src/lib/crypto'

export default defineComponent({
    name: 'AuthPage',
    components: {
        ValidationForm,
        Field,
    },
    setup() {
        const authStore = useAuthStore()
        const router = useRouter()
        const $q = useQuasar()


        // Login form validation schema
        const loginSchema = yup.object({
            email: yup.string().email('Please enter a valid email address').required('Email is required'),
            password: yup.string().required('Password is required'),
            remember: yup.boolean()
        })

        // Signup form validation schema
        const signupSchema = yup.object({
            name: yup.string().required('Full name is required').min(2, 'Name must be at least 2 characters'),
            email: yup.string().email('Please enter a valid email address').required('Email is required'),
            password: yup.string()
                .required('Password is required')
                .min(8, 'Password must be at least 8 characters')
                .matches(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/, 'Password must contain at least one uppercase letter, one lowercase letter, and one number'),
            confirmPassword: yup.string()
                .required('Please confirm your password')
                .oneOf([yup.ref('password')], 'Passwords must match'),
            terms: yup.boolean().oneOf([true], 'You must accept the terms and conditions')
        })

        return {
            loginSchema,
            signupSchema,
            $q,
            router,
            authStore
        }
    },
    data() {
        return {
            activeTab: 'login',
            fullPageLoading: false,
            loginLoading: false,
            signupLoading: false,
            showLoginPassword: false,
            showSignupPassword: false,
            showConfirmPassword: false
        }
    },
    methods: {
        // Clear tab switching with animation
        switchTab(tab) {
            this.activeTab = tab
        },

        // Login form submission
        async onLoginSubmit(values, actions) {
            this.loginLoading = true

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
                })
                await this.router.push('/')
                window.location.reload()
            } catch (e) {
                this.loading = false
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
                console.log(e)
                errorHandler(e, actions.setErrors)
            }finally {
                this.loginLoading = false
            }
        },

        // Signup form submission
        async onSignupSubmit(values, actions) {
            this.signupLoading = true

         try {
                await this.authStore.getToken()
                const result = await this.authStore.register(
                    values?.name,
                    values?.email,
                    values?.password,
                    values?.terms,
                )
                this.loading = false
                this.authStore.token = result.data
                localStorage.setItem('token', result.data)
                this.$q.notify({
                    message: 'The Account Has been Register Please Confirm Your email',
                    color: 'green',
                })
               // inside onSignupSubmit
const encrypted = LocalEncrypt(values.email)
await this.router.push(`/message/${encodeURIComponent(encrypted)}`)

            } catch (e) {
                this.loading = false
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
                console.log(e)
                errorHandler(e, actions.setErrors)
            }finally {
               this.signupLoading = false
            }
        },

        // Social authentication methods
        socialLogin(provider) {
            this.$q.notify({
                message: `Signing in with ${provider}...`,
                color: 'info',
                position: 'top',
                icon: 'public'
            })
        },

        socialSignup(provider) {
            this.$q.notify({
                message: `Signing up with ${provider}...`,
                color: 'info',
                position: 'top',
                icon: 'public'
            })
        },

        // Quick login demo
        quickLogin() {
            this.$q.dialog({
                title: 'Quick Login',
                message: 'This feature would use biometric authentication on supported devices.',
                ok: {
                    label: 'Try Demo',
                    color: 'primary'
                },
                cancel: {
                    label: 'Cancel',
                    flat: true
                }
            }).onOk(() => {
                this.$q.notify({
                    message: 'Biometric authentication simulated!',
                    color: 'info',
                    icon: 'fingerprint'
                })
            })
        }
    },
    mounted() {
        // Simulate initial loading
        setTimeout(() => {
            this.fullPageLoading = false
        }, 1000)
    }
})
</script>

<style scoped>
/* Custom animations for smooth transitions */
.animate-fade-in {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile-specific optimizations */
@media (max-width: 640px) {
    .max-w-md {
        margin: 0 0.5rem;
        width: calc(100% - 1rem);
    }

    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-8 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Larger touch targets for mobile */
    .q-btn {
        min-height: 48px;
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .q-field {
        font-size: 16px; /* Prevents zoom on iOS */
    }

    /* Tab buttons larger on mobile */
    .flex-1 {
        min-height: 54px;
    }
}

/* Enhanced focus states for accessibility */
button:focus-visible,
.q-btn:focus-visible {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Smooth transitions for all interactive elements */
button, .q-btn, .q-field, .q-toggle, .q-input {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for better mobile experience */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
