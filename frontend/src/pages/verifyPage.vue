<template>
  <q-card class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md mx-4">
      <!-- Main Card -->
      <div class="overflow-hidden bg-white shadow-xl rounded-2xl">
        <!-- Header -->
        <div class="px-6 py-8 bg-blue-600">
          <div class="flex justify-center mb-4">
            <div class="flex items-center justify-center w-16 h-16 bg-white rounded-full bg-opacity-20">
              <q-icon name="mail" class="text-2xl text-white" />
            </div>
          </div>
          <h2 class="text-2xl font-bold text-center text-white">Verify Your Email</h2>
        </div>

        <!-- Content -->
        <div class="px-6 py-8">
          <div class="py-4">
            <div class="mb-6 text-center">
              <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                  <q-icon name="mail_outline" class="text-3xl text-blue-600" />
                </div>
              </div>
              <h3 class="mb-2 text-xl font-semibold text-gray-900">Verify Your Account</h3>
              <p class="text-gray-600">
                Please enter the verification code below.
              </p>
            </div>

            <form class="space-y-4">
              <div>
                <label for="code" class="block mb-2 text-sm font-medium text-gray-700">
                  Code
                </label>
                <input
                  id="code"
                  v-model="code"
                  type="text"
                  required
                  class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="xxxxxx"
                >
              </div>

              <button
                type="button"
                class="flex items-center justify-center w-full px-4 py-3 font-medium text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                :disabled="loading"
                @click="verify()"
              >
                <template v-if="loading">
                  <q-spinner size="20px" color="white" class="mr-2" />
                  Verifying...
                </template>
                <template v-else>
                  Verify Code
                </template>
              </button>
            </form>

            <div class="mt-4 text-center">
              <button
                type="button"
                class="font-medium text-blue-600 transition duration-200 hover:text-blue-700"
                @click="login()"
              >
                Back to Login
              </button>
            </div>
          </div>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <p class="text-sm text-center text-gray-500">
            Need help? <a href="#" class="font-medium text-blue-600 hover:text-blue-700">Contact Support</a>
          </p>
        </div>
      </div>
    </div>
  </q-card>
</template>

<script>
import { useRouter ,useRoute} from 'vue-router'
import { useAuthStore } from 'src/stores/UserManagementStores/AuthStore'

export default {
  name: 'VerifyEmailPage',
  data () {
    const router = useRouter();
    const authStore = useAuthStore()
    const route = useRoute()

    return {
      code: '',
      loading: false,
      router,
      authStore,
      route
    }
  },
  methods : {
    login() {
      this.router.push('/login')
    },
    async verify() {
      this.loading = true
      try {
        await this.authStore.getToken()
        const result = await this.authStore.verify(
          this.route.params.id,
          this.code,
        )
        this.$q.notify({
          message: 'Logged in successfully',
          color: 'green',
        })
        this.router.push('/login')
      } catch (e) {
        this.$q.notify({
          message: 'Something went wrong',
          color: 'red',
        })
        console.log(e)
      } finally {
        this.loading = false
      }
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
