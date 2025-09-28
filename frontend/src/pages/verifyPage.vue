<template>
  <q-card class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md mx-4">
      <!-- Main Card -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-8">
          <div class="flex justify-center mb-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
              <q-icon name="mail" class="text-white text-2xl" />
            </div>
          </div>
          <h2 class="text-2xl font-bold text-white text-center">Verify Your Email</h2>
        </div>

        <!-- Content -->
        <div class="px-6 py-8">
          <div class="py-4">
            <div class="text-center mb-6">
              <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                  <q-icon name="mail_outline" class="text-blue-600 text-3xl" />
                </div>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Verify Your Account</h3>
              <p class="text-gray-600">
                Please enter the verification code below.
              </p>
            </div>

            <form class="space-y-4">
              <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                  Code
                </label>
                <input
                  id="code"
                  v-model="code"
                  type="text"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                  placeholder="xxxxx"
                >
              </div>

              <button
                type="button"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
              >
                Verify Code
              </button>
            </form>

            <div class="mt-4 text-center">
              <button
                type="button"
                class="text-blue-600 hover:text-blue-700 font-medium transition duration-200"
                @click="login()"
              >
                Back to Login
              </button>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <p class="text-center text-sm text-gray-500">
            Need help? <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Contact Support</a>
          </p>
        </div>
      </div>
    </div>
  </q-card>
</template>

<script>
import { useRouter } from 'vue-router'

export default {
  name: 'VerifyEmailPage',
  data () {
    const router = useRouter();
    return {
      code: '',
      router
    }
  },
  methods : {
    login() {
      this.router.push('/login')
    }
  }
}
</script>

<style scoped>
.q-page {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

button, input {
  transition: all 0.2s ease-in-out;
}

input:focus {
  outline: none;
  ring: 2px;
  ring-color: #3b82f6;
}
</style>
