import { boot } from 'quasar/wrappers'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { urlFinder } from 'src/lib/helpers'

export default boot(({ app }) => {
  const useCurrentRoute = import.meta.env.VITE_USE_CURRENT_HOST
  let host = ''

  if (typeof useCurrentRoute !== 'undefined') {
    host = window.location.hostname
  } else {
    host = import.meta.env.VITE_REVERB_HOST
  }

  window.Pusher = Pusher

  app.config.globalProperties.$echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: host,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: `${urlFinder(true)}broadcasting/auth`,
    auth: {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token'),
      },
    },
  })
})
