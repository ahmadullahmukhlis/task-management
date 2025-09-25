<template>
    <div class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="w-full max-w-md">
            <!-- Success Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-2xl animate-fade-in">
                <!-- Header with Success Icon -->
                <div class="relative px-6 py-8 text-center bg-gradient-to-r from-green-500 to-teal-600">
                    <!-- Animated Checkmark -->
                    <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 rounded-full bg-white/20">
                        <div class="checkmark-container">
                            <svg class="checkmark" viewBox="0 0 52 52">
                                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Account Created Successfully!</h1>
                    <p class="mt-2 text-green-100">You're almost there</p>
                </div>

                <!-- Message Content -->
                <div class="px-6 py-8">
                    <!-- Main Message -->
                    <div class="mb-6 text-center">
                        <h2 class="mb-3 text-xl font-semibold text-gray-800">Verify Your Email Address</h2>
                        <p class="leading-relaxed text-gray-600">
                            We've sent a verification link to your email address:
                        </p>
                        <div class="p-3 mt-3 border border-blue-200 rounded-lg bg-blue-50">
                            <p class="font-medium text-blue-700">{{ userEmail }}</p>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="p-4 mb-6 bg-gray-50 rounded-xl">
                        <h3 class="flex items-center mb-3 font-semibold text-gray-700">
                            <q-icon name="info" class="mr-2 text-blue-500" />
                            What to do next:
                        </h3>
                        <ol class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-2 mt-0.5">1</span>
                                Check your email inbox (and spam folder)
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-2 mt-0.5">2</span>
                                Click the verification link in the email
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-2 mt-0.5">3</span>
                                Your account will be activated automatically
                            </li>
                        </ol>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <!-- Open Email App Button -->
                        <q-btn
                            color="primary"
                            class="w-full py-3 font-semibold transition-all duration-300 rounded-lg shadow-lg hover:shadow-xl"
                            label="Open Email App"
                            icon="email"
                            no-caps
                            @click="openEmailApp"
                        />

                        <!-- Resend Email Button -->
                        <q-btn
                            outline
                            color="green"
                            class="w-full py-3 font-medium rounded-lg"
                            :label="resendButtonLabel"
                            :disabled="resendCooldown > 0"
                            icon="refresh"
                            no-caps
                            @click="resendVerificationEmail"
                        />

                        <!-- Check Verification Status -->
                        <q-btn
                            flat
                            color="blue"
                            class="w-full py-2 font-medium rounded-lg"
                            label="I've verified my email"
                            icon="check_circle"
                            no-caps
                            @click="checkVerificationStatus"
                        />
                    </div>

                    <!-- Support Section -->
                    <div class="pt-4 mt-6 border-t border-gray-200">
                        <div class="text-sm text-center text-gray-500">
                            <p class="mb-2">Didn't receive the email?</p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="flex items-center text-blue-600 hover:text-blue-500" @click.prevent="resendVerificationEmail">
                                    <q-icon name="send" size="16px" class="mr-1" />
                                    Resend
                                </a>
                                <a href="#" class="flex items-center text-blue-600 hover:text-blue-500" @click.prevent="contactSupport">
                                    <q-icon name="support" size="16px" class="mr-1" />
                                    Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div v-if="resendCooldown > 0" class="p-4 mt-4 text-center bg-white/80 backdrop-blur-sm rounded-xl">
                <div class="flex items-center justify-center text-sm text-gray-600">
                    <q-icon name="schedule" class="mr-2 text-blue-500" />
                    <span>You can resend verification email in</span>
                </div>
                <div class="mt-1 text-lg font-bold text-blue-600">
                    {{ formatTime(resendCooldown) }}
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="p-4 mt-4 border border-yellow-200 bg-yellow-50 rounded-xl">
                <h4 class="flex items-center mb-2 font-semibold text-yellow-800">
                    <q-icon name="lightbulb" class="mr-2" />
                    Quick Tips
                </h4>
                <ul class="space-y-1 text-sm text-yellow-700">
                    <li>• Check your spam or junk folder</li>
                    <li>• Make sure you entered the correct email</li>
                    <li>• Verification links expire in 24 hours</li>
                </ul>
            </div>
        </div>

        <!-- Success Dialog -->
        <q-dialog v-model="verificationSuccess" persistent>
            <q-card class="max-w-sm p-4 mx-auto rounded-2xl">
                <q-card-section class="text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full">
                        <q-icon name="check_circle" size="32px" color="green" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Email Verified!</h3>
                    <p class="mt-2 text-gray-600">Your account has been successfully verified.</p>
                </q-card-section>

                <q-card-actions align="center" class="pb-4">
                    <q-btn
                        color="green"
                        label="Continue to Dashboard"
                        no-caps
                        class="px-6 rounded-lg"
                        @click="goToDashboard"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <!-- Support Dialog -->
        <q-dialog v-model="supportDialog">
            <q-card class="max-w-sm p-4 mx-auto rounded-2xl">
                <q-card-section>
                    <h3 class="mb-2 text-lg font-bold text-gray-800">Contact Support</h3>
                    <p class="text-gray-600">If you're having trouble verifying your email, our support team is here to help.</p>

                    <div class="mt-4 space-y-2">
                        <div class="flex items-center text-sm">
                            <q-icon name="email" class="mr-2 text-blue-500" />
                            <span>support@yourapp.com</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <q-icon name="phone" class="mr-2 text-blue-500" />
                            <span>+1 (555) 123-4567</span>
                        </div>
                    </div>
                </q-card-section>

                <q-card-actions align="right" class="pb-4">
                    <q-btn flat label="Close" color="gray" v-close-popup />
                    <q-btn color="primary" label="Send Email" @click="sendSupportEmail" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { useQuasar } from 'quasar'
import { useRoute, useRouter } from 'vue-router'

import { lOCALdecrypt } from 'src/lib/crypto'
import { errorHandler } from 'src/lib/errorHandler'
import { useAuthStore } from 'src/stores/UserManagementStores/AuthStore'

export default defineComponent({
    name: 'EmailVerificationPage',
    setup() {
        const $q = useQuasar()
        const router = useRouter()
        const route = useRoute();
        const authStore = useAuthStore()
      const encryptedParam = decodeURIComponent(route.params.email)
        // Get user email from route params or store
        const userEmail = lOCALdecrypt(encryptedParam) // This would typically come from your auth store

        return {
            userEmail,
            $q,
            router,
            route,authStore
        }
    },
    data() {
        return {
            resendCooldown: 0,
            resendCooldownInterval: null,
            verificationSuccess: false,
            supportDialog: false,
            checkingStatus: false ,

        }
    },
    computed: {
        resendButtonLabel() {
            if (this.resendCooldown > 0) {
                return `Resend in ${this.formatTime(this.resendCooldown)}`
            }
            return 'Resend Verification Email'
        }
    },
    methods: {
        // Format time for countdown display
        formatTime(seconds) {
            const minutes = Math.floor(seconds / 60)
            const remainingSeconds = seconds % 60
            return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`
        },

        // Open user's email app
        openEmailApp() {
            this.$q.notify({
                message: 'Opening your email app...',
                color: 'info',
                icon: 'email',
                position: 'top'
            })

            // In a real app, this would open the default email client
            setTimeout(() => {
                window.location.href = 'mailto:'
            }, 100)
        },

        // Resend verification email
        async resendVerificationEmail() {

          try {
                await this.authStore.getToken()
                const result = await this.authStore.resend(
                  this.userEmail
                )
                this.loading = false
                this.authStore.token = result.data
                localStorage.setItem('token', result.data)
                this.$q.notify({
                    message: 'The Account Has been Register Please Confirm Your email',
                    color: 'green',
                })


            } catch (e) {
                this.loading = false
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
                console.log(e)
                errorHandler(e)
            }
        },

        // Check if user has verified their email
        async checkVerificationStatus() {
            this.checkingStatus = true

            this.$q.notify({
                message: 'Checking verification status...',
                color: 'info',
                icon: 'hourglass_empty',
                position: 'top'
            })

            try {
                // Simulate API call to check verification status
                await new Promise(resolve => setTimeout(resolve, 2000))

                // For demo purposes, sometimes show success, sometimes show not verified
                const isVerified = Math.random() > 0.5

                if (isVerified) {
                    this.verificationSuccess = true
                } else {
                    this.$q.notify({
                        message: 'Email not verified yet. Please check your inbox.',
                        color: 'warning',
                        icon: 'warning',
                        position: 'top'
                    })
                }
            } catch (error) {
                this.$q.notify({
                    message: 'Error checking verification status.',
                    color: 'negative',
                    icon: 'error',
                    position: 'top'
                })
            } finally {
                this.checkingStatus = false
            }
        },

        // Start cooldown timer for resend button
        startCooldownTimer() {
            this.resendCooldownInterval = setInterval(() => {
                if (this.resendCooldown > 0) {
                    this.resendCooldown--
                } else {
                    clearInterval(this.resendCooldownInterval)
                }
            }, 1000)
        },

        // Contact support
        contactSupport() {
            this.supportDialog = true
        },

        // Send support email
        sendSupportEmail() {
            this.$q.notify({
                message: 'Opening support email...',
                color: 'info',
                icon: 'email',
                position: 'top'
            })
            this.supportDialog = false
        },

        // Redirect to dashboard
        goToDashboard() {
            this.verificationSuccess = false
            this.router.push('/dashboard')
        }
    },
    mounted() {
        // Start with a short cooldown for demo purposes
        this.resendCooldown = 10
        this.startCooldownTimer()
    },
    beforeUnmount() {
        if (this.resendCooldownInterval) {
            clearInterval(this.resendCooldownInterval)
        }
    }
})
</script>

<style scoped>
/* Animation for page load */
.animate-fade-in {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animated checkmark */
.checkmark-container {
    width: 60px;
    height: 60px;
}

.checkmark {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: block;
    stroke-width: 3;
    stroke: #ffffff;
    stroke-miterlimit: 10;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 3;
    stroke-miterlimit: 10;
    stroke: #ffffff;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px transparent;
    }
}
</style>
